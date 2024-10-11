<?php

namespace App\Imports;
use Maatwebsite\Excel\Concerns\ToModel;


use App\Models\AppPostback;
use App\Models\Click;
use App\Models\Conversion;
use App\Models\Offer;
use App\Models\IP;
use App\Models\Postback;
use App\Models\ShareConversion;
use App\Models\OfferSharePayout;
use App\Models\User;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use AmrShawky\LaravelCurrency\Facade\Currency;
use App\Models\PostbackLog;
use App\Models\OfferStudent;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ConversionImport implements ToModel
{
   
    protected $ipAddress;

    public function __construct($ipAddress)
    {
        $this->ipAddress = $ipAddress;
    }
    
    protected function isConversionDuplicate($transactionId, $eventName)
    {
        return Conversion::where('click_transaction_id', $transactionId)
            ->where('name', $eventName)
            ->exists();
    }


    protected function isIpConversionDuplicate($ipAddress, $offerId, $eventName)
    {
        return Conversion::where('click_ip', $ipAddress)
            ->where('offer_id', $offerId)
            ->where('name', $eventName)
            ->exists();
    }

    protected function isShareConversionDuplicate($transactionId, $eventName)
    {
        return ShareConversion::where('click_transaction_id', $transactionId)
            ->where('event', $eventName)
            ->exists();
    }
    
    protected function getEventName($offer, $goalId)
    {
        if (!empty($goalId) & $goalId!='1') {
            $goal = $offer->goals->where('id', $goalId)->first();
            return $goal ? $goal->goalName->name : null;
        } else {
            return 'Default_1';
        }
    }

    public function model(array $row)
    {
        // Check if the record with certain column value already exists
        $transaction_id = strval($row[0] ?? ''); 
        $goal_id = strval($row[1] ?? ''); 
        
        if (empty($transaction_id)) 
         {
             return null;
         }
         $click = Click::where('transaction_id', $transaction_id)->first();
         
         if (!$click) {
              return null;
         }
            
          $offer = Offer::find($click->offer_id);
         
         
          $eventName = $this->getEventName($offer, $goal_id);
          if (!$eventName) {
            return null;
          }
          
        // check whether same conversion is coming for same goal
        if ($this->isConversionDuplicate($click->transaction_id, $eventName)) {
        return null;
        }
         /*
        * Check if the offer has same ip conversion block
        * check ip address to search for conversion
        * if found then return
        */
        if (!$offer->same_ip_conversion && $this->isIpConversionDuplicate($click->ip_address, $click->offer_id,$eventName)) {
          return null;
        }
               
        $conversion = $this->conversion($click, $offer, $this->ipAddress, $eventName,null);
        $this->postback($click, $conversion,$eventName);
        if(!is_null($click->paytm_no))
        {
            if ($this->isShareConversionDuplicate($click->transaction_id, $eventName)) {
             return null;
            }

           $share_conversion = $this->share_conversion($click, $eventName);
           //$this->app_postback($click, $share_conversion);
        }
          
    }// function close
                
    public function postback($click, $conversion, $event)
    {
        $postbacks = Postback::where(function ($query) use ($click, $event) {
            $query->where('status',1)
                ->where('offer_id', $click->offer_id)
                ->where('student_id', $click->student_id)
                ->where('event', $event);
        })->orWhere(function ($query) use ($click, $event) {
            $query->whereNull('offer_id')
                ->where('status',1)
                ->where('student_id', $click->student_id)
                ->where('event', $event);
        })->get();
    
        foreach ($postbacks as $postback) {
            $link = $this->replacePlaceholders($postback->postback, $click, $conversion);
    
            try {
                $client = new \GuzzleHttp\Client();
                $response = $client->request('GET', $link);
    
                $pb_sent = $this->createPostbackLog($postback, $click, $conversion, $event, $link, $response);
            } catch (RequestException $ex) {
                $pb_sent = $this->createPostbackLogError($postback, $click, $conversion, $event, $link, $ex);
            }
        }
    }  
    
    protected function replacePlaceholders($link, $click, $conversion)
    {
        $placeholders = [
            '{offer_id}' => $click->offer_id,
            '{stu_sub}' => $click->stu_sub,
            '{stu_sub2}' => $click->stu_sub2,
            '{stu_sub3}' => $click->stu_sub3,
            '{stu_sub4}' => $click->stu_sub4,
            '{stu_sub5}' => $click->stu_sub5,
            '{stu_click}' => $click->stu_click,
            '{source}' => $click->source,
            '{country}' => $click->country,
            '{region}' => $click->region,
            '{city}' => $click->city,
            '{payout}' => $click->payout,
            '{currency}' => $click->currency,
            '{sale_amount}' => $click->sale_amount,
            '{click_ip}' => $click->click_ip,
            '{conversion_ip}' => $conversion->conversion_ip,
            '{operating_system}' => $click->os_name,
            '{browser_name}' => $click->browser_name,
            '{browser_version}' => $click->browser_version,
            '{useragent}' => $click->user_agent,
            '{click_time}' => $click->created_at,
        ];
        return str_replace(array_keys($placeholders), array_values($placeholders), $link);
    }
    
    protected function createPostbackLog($postback, $click, $conversion, $event, $link, $response)
    {
        $pb_sent = new PostbackLog();
        $pb_sent->postback_id = $postback->id;
        $pb_sent->student_id = $click->student_id;
        $pb_sent->offer_id = $click->offer_id;
        $pb_sent->event = $event;
        $pb_sent->postback = $link;
        $pb_sent->status = $response->getStatusCode();
        $pb_sent->body = (string)$response->getBody();
        $pb_sent->save();
    
        return $pb_sent;
    }
    
    protected function createPostbackLogError($postback, $click, $conversion, $event, $link, $ex)
    {
        $pb_sent = new PostbackLog();
        $pb_sent->postback_id = $postback->id;
        $pb_sent->student_id = $click->student_id;
        $pb_sent->offer_id = $click->offer_id;
        $pb_sent->event = $event;
        $pb_sent->postback = $link;
        $pb_sent->status = $ex->getCode();
        $pb_sent->body = $ex->getMessage();
        $pb_sent->save();
    
        return $pb_sent;
    }
    

    protected function conversion($click, $offer, $ip, $event, $sale_amount)
    {
        $conversion = new Conversion();
        $offerStudent = OfferStudent::where('student_id', $click->student_id)->where('offer_id', $click->offer_id)->where('name',$event)->first();
     
        if($offerStudent!=null)
        {
          $conversion->payout = $this->getPayoutStudent($sale_amount,$offerStudent);
        $conversion->revenue = $this->getRevenueStudent($sale_amount,$offer,$offerStudent);  
        }
        else
        {
            $conversion->payout = $this->getPayout($sale_amount, $offer);
            $conversion->revenue = $this->getRevenue($sale_amount, $offer);
        }
        $conversion->student_id = $click->student_id;
        $conversion->offer_id = $click->offer_id;
        $conversion->advertiser_id = $click->advertiser_id;
        $conversion->manager_id = $click->manager_id;
        $conversion->click_transaction_id = $click->transaction_id;
        $conversion->currency = config('app.currency');
        //$conversion->payout = $this->getPayout($sale_amount, $offer);
        //$conversion->revenue = $this->getRevenue($sale_amount, $offer);
        $conversion->sale_amount = $sale_amount != null ? Currency::convert()->from($offer->currency)->to(config('app.currency'))->amount($sale_amount)->get() : null;
        $conversion->status = $offer->conversion_approval ? 'approved' : 'pending';
        $conversion->name = $event;
        $conversion->conversion_ip = $ip;
        $conversion->click_ip = $click->ip_address;
        $conversion->browser_name = $click->browser_name;
        $conversion->country = $click->country;
        $conversion->save();

        return $conversion;
    }
    
    protected function share_conversion($click,$event)
    {
        // to find sharepayout and goal name
        $offerShare =OfferSharePayout::where([
            ['offer_id', '=', $click->offer_id],
            ['student_id', '=', $click->student_id]
        ])->get();

        foreach ($offerShare as $offShare) {
            if(strcasecmp($offShare->goal1_name,$event)==0)
            $payout=$offShare->goal1_share_payout;
            elseif(strcasecmp($offShare->goal2_name,$event)==0)
            $payout=$offShare->goal2_share_payout;            
        }
        
        // save share conversion
        $conversion = new ShareConversion();
        $conversion->student_id = $click->student_id;
        $conversion->offer_id = $click->offer_id;
        $conversion->click_transaction_id = $click->transaction_id;
        $conversion->paytm_no = $click->paytm_no;
        $conversion->event= $event;
        $conversion->payout= $payout;
        $conversion->save();

        return $conversion;
    }
    
    public function app_postback($click, $conversion)
    {
        $user = User::find($click->student_id);
        $redirectlink = 'https://cashbackgullak.com/ptrack';
        $link = 'https://cashbackgullak.com/ptrack?oname=' . $click->offer_name . '&aname=' . $user->name . '&phno=' . $conversion->paytm_no . '&dpay=' . $conversion->payout;
        $event = 'some_event';
    
        try {
            $client = new \GuzzleHttp\Client();
            $access_token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9';
            $response = $client->request('POST', $redirectlink, [
                'headers' => ['Authorization' => 'Bearer ' . $access_token],
                'form_params' => [
                    'oname' => $click->offer_name,
                    'aname' => $user->name,
                    'phno' => $conversion->paytm_no,
                    'dpay' => $conversion->payout,
                ],
            ]);
    
            $pb_sent = $this->createAppPostbackLog($click, $conversion, $event, $link, $response);
        } catch (RequestException $ex) {
            $pb_sent = $this->createAppPostbackLogError($click, $conversion, $event, $link, $ex);
        }
    }
    
    protected function createAppPostbackLog($click, $conversion, $event, $link, $response)
    {
        $pb_sent = new AppPostback();
        $pb_sent->student_id = $click->student_id;
        $pb_sent->offer_id = $click->offer_id;
        $pb_sent->event = $conversion->event;
        $pb_sent->postback = $link;
        $pb_sent->status = $response->getStatusCode();
        $pb_sent->message = (string)$response->getBody();
        $pb_sent->save();
    
        return $pb_sent;
    }
    
    protected function createAppPostbackLogError($click, $conversion, $event, $link, $ex)
    {
        $pb_sent = new AppPostback();
        $pb_sent->student_id = $click->student_id;
        $pb_sent->offer_id = $click->offer_id;
        $pb_sent->event = $conversion->event;
        $pb_sent->postback = $link;
        $pb_sent->status = $ex->getCode();
        $pb_sent->message = $ex->getMessage();
        $pb_sent->save();
    
        return $pb_sent;
    }
    
    protected function getPayout($sale_amount, $offer)
    {
        if ($sale_amount != null && $offer->offer_model == 'RevShare' || $offer->offer_model == 'Dynamic') {
            //$amount = Currency::convert()->from($offer->currency)->to(config('app.currency'))->amount($sale_amount)->get();
            $amount=$sale_amount;
            return $amount * $offer->percent_payout / 100;
        } else {
             return $offer->default_payout != 0 ? $offer->default_payout : 0;
            //return $offer->default_payout != 0 ? Currency::convert()->from($offer->currency)->to(config('app.currency'))->amount($offer->default_payout)->get() : 0;
        }
    }
    
    protected function getPayoutStudent($sale_amount, $offer)
    {
        if ($sale_amount != null && $offer->pay_model == 'RevShare' || $offer->pay_model == 'Dynamic') {
            //$amount = Currency::convert()->from($offer->currency)->to(config('app.currency'))->amount($sale_amount)->get();
             $amount=$sale_amount;
            return $amount * $offer->percent_payout / 100;
        } else {
            
            
            return $offer->default_payout != 0 ? $offer->default_payout : 0;
        }
    }

    protected function getRevenue($sale_amount, $offer)
    {
        if ($sale_amount != null && $offer->offer_model == 'RevShare' || $offer->offer_model == 'Dynamic') {
            //$amount = Currency::convert()->from($offer->currency)->to(config('app.currency'))->amount($sale_amount)->get();
             $amount=$sale_amount;
            return $amount * $offer->percent_revenue / 100;
        } else {
            //return $offer->default_revenue != 0 ? Currency::convert()->from($offer->currency)->to(config('app.currency'))->amount($offer->default_revenue)->get() : 0;
        
            return $offer->default_revenue != 0 ? $offer->default_revenue : 0;
        }
    }
    
    protected function getRevenueStudent($sale_amount, $offer, $offerStudent)
    {
        if ($sale_amount != null && $offerStudent->pay_model == 'RevShare' || $offerStudent->pay_model == 'Dynamic') {
            //$amount = Currency::convert()->from($offerStudent->currency)->to(config('app.currency'))->amount($sale_amount)->get();
            $amount=$sale_amount;
            return $amount * $offer->percent_revenue / 100;
        } else {
            return $offer->default_revenue != 0 ? ($offer->default_revenue) : 0;
        }
    }
    

    
    
    
}
