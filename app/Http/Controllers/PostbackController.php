<?php

namespace App\Http\Controllers;

use App\Models\AppPostback;
use App\Models\Click;
use App\Models\Conversion;
use App\Models\ConversionLimit;
use App\Models\Offer;
use App\Models\IP;
use App\Models\Postback;
use App\Models\ShareConversion;
use App\Models\OfferSharePayout;
use App\Models\OfferStudent;

use App\Models\User;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;

use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Http;
use AmrShawky\LaravelCurrency\Facade\Currency;
use App\Models\PostbackLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PostbackController extends Controller
{
    public function index(Request $request)
    {
        $token = $request->token;
        $transaction_id = $request->click_id;
        $goal_id = $request->goal_id;
        $sale_amount = $request->sale_amount;
        $ip_check = (isset($_SERVER["HTTP_CF_CONNECTING_IP"]) ? $_SERVER["HTTP_CF_CONNECTING_IP"] : $_SERVER['REMOTE_ADDR']);

        $click = Click::where('transaction_id', $transaction_id)->first();
        
        

        /**
         * checking, click data exist
         */
        if (!$click) {
            return response()->json(['status' => 'error', 'message' => 'Data not found.']);
        }
        
        /*
        first check whether ip is whitelisted or not for a advertiser
        */
        $adver_ip = IP::where('status',1)->where('advertiser_id',$click->advertiser_id)->first();
        if($adver_ip!=null)
        {
          $ips = IP::where('status',1)->where('ipaddress', $ip_check)->first();
          if($ips==null)
          {
            return response()->json(['status' => 'error', 'message' => 'IP not whitelisted with us.']);
          }
        }

        /**
         * If advertiser security token is not match then we will return error
         */
        $offer = Offer::find($click->offer_id);
        if ($offer->advertiser->security_token != $token) {
            return response()->json(['status' => 'error', 'message' => 'Security token is invalid/mismatch.']);
        }

        /*
         * Check if the conversion happen before  min_conversion_time
         * If yes, then don't create a new conversion
         */
        $date1 = Carbon::now();
        $date2 = Carbon::parse($click->created_at);
        if ($date1->diffInSeconds($date2) < $offer->min_conversion_time) {
            return response()->json(['status' => 'error', 'message' => 'Conversion time not reached']);
        }

        /*
         * Check if the conversion happen after  max_conversion_time
         * If yes, then don't create a new conversion
         */

        //return $date1->diffInHours($date2) < $offer->max_conversion_time;

        if ($date1->diffInHours($date2) > $offer->max_conversion_time) {
            return response()->json(['status' => 'error', 'message' => 'Conversion time exceeded']);
        }



        /**
         * Goal Check
         * If the goal_id is set in postback url, then we will check goal details
         * else we will check the offer details
         */
        if ($goal_id != null) {
            $goal = $offer->goals->where('goal_id', $goal_id)->first();
            if ($goal != null) {
                // first check whether we have reached maximum converion limit
                $climit=ConversionLimit::where('offer_id',$click->offer_id)->where('student_id',$click->student_id)->where('name',$goal->goalName->name)->first();
                if($climit!=null)
                {
                    $convlimit=$climit->conversionlimit;
                    $userConversions = Conversion::where('student_id',$click->student_id )
                           ->where('offer_id', $click->offer_id)
                           ->count();
                 if ($userConversions >= $convlimit) {
                     
                   //return redirect()->back()->with('error', 'Maxmium click reached');
                    return redirect(config('app.offer_fallback'));
                  }
               
                }
                
                
                // check whether same conversion is coming for same goal
                $Sameconversion = Conversion::where('click_transaction_id', $click->transaction_id)->where('name', $goal->goalName->name)->count();
                //return $conversion;
                if ($Sameconversion) {
                    return response()->json(['status' => 'error', 'message' => 'Same Conversion already exists']);
                }

                /*
                * Check if the offer has same ip conversion block
                * check ip address to search for conversion
                * if found then return
                */
                if (!$offer->same_ip_conversion) {
                    $conversion = Conversion::where('click_ip', $click->ip_address)->where('offer_id', $click->offer_id)->where('name', $goal->goalName->name)->count();
                    //return $conversion;
                    if ($conversion) {
                        return response()->json(['status' => 'error', 'message' => 'Conversion already exists from this IP']);
                    }
                }

                $conversion = $this->conversion($click, $offer, $ip_check, $goal->goalName->name, $sale_amount);
                $this->postback($click, $conversion, $goal->goalName->name);

                // //
                // $user = User::find($click->student_id);
                // $new_balance = $user->balance + Currency::convert()->from($goal->currency)->to(config('app.currency'))->amount($goal->default_payout)->get();

                // $user->balance = $new_balance;
                // $user->update();
                // //

                
                if(!is_null($click->paytm_no))
                {
                    $user = User::find($click->student_id);
                    $stu_name=$user->name;
                    $shareConversion = ShareConversion::where('click_transaction_id', $click->transaction_id)->where('event',$goal->goalName->name)->count();
                    //return $conversion;
                    if ($shareConversion) { 
                    return response()->json(['status' => 'error', 'message' => 'Conversion already exists for this number']);
                    }
                    else
                    {
                          $share_conversion=$this->share_conversion($click,$goal->name);
                            $this->app_postback($click,$share_conversion); 
                    }
                    
                }

                return response()->json(['success' => 'Conversion Recorded Successfully!']);
            } else {
                return response()->json(['Error' => 'Data not found!']);
            }
        } else {
            
            // first check whether we have reached maximum converion limit
                $climit=ConversionLimit::where('offer_id',$click->offer_id)->where('student_id',$click->student_id)->where('name','Default')->first();
                if($climit!=null)
                {
                    $convlimit=$climit->conversionlimit;
                    $userConversions = Conversion::where('student_id',$click->student_id )
                           ->where('offer_id', $click->offer_id)
                           ->count();
                 if ($userConversions >= $convlimit) {
                     
                   //return redirect()->back()->with('error', 'Maxmium click reached');
                    return redirect(config('app.offer_fallback'));
                  }
               
                }
            
            // check whether same conversion is coming for same goal
             $Sameconversion = Conversion::where('click_transaction_id', $click->transaction_id)->where('name', 'Default_1')->count();
             //return $conversion;
             if ($Sameconversion) {
                 return response()->json(['status' => 'error', 'message' => 'Same Conversion already exists']);
             }

            /*
            * Check if the offer has same ip conversion block
            * check ip address to search for conversion
            * if found then return
            */
            if (!$offer->same_ip_conversion) {
                $conversion = Conversion::where('click_ip', $click->ip_address)->where('offer_id', $click->offer_id)->where('name', 'Default_1')->count();
                //return $conversion;
                if ($conversion) {
                    return response()->json(['status' => 'error', 'message' => 'Conversion already exists from this IP']);
                }
            }

            $conversion = $this->conversion($click, $offer, $ip_check, 'Default_1', $sale_amount);
            
            $this->postback($click, $conversion, 'Default_1');

            // /**
            //  * Update User Balance
            //  */
            // $user = User::find($click->student_id);
            // $new_balance = $user->balance + Currency::convert()->from($offer->currency)->to(config('app.currency'))->amount($offer->default_payout)->get();

            // $user->balance = $new_balance;
            // $user->update();

            /**
             * If offer has postback url, then we will send postback request
             */
             
             if(!is_null($click->paytm_no))
                {
                   
                    $user = User::find($click->student_id);
                    $stu_name=$user->name;
                    //$share_conversion=$this->share_conversion($click,"Default");
                    
                    $shareConversion = ShareConversion::where('click_transaction_id', $click->transaction_id)->where('event', 'Default_1')->count();
                    //return $conversion;
                    if ($shareConversion) { 
                    return response()->json(['status' => 'error', 'message' => 'Conversion already exists for this number']);
                    }
                    else
                    {
                          $share_conversion=$this->share_conversion($click,"Default");
                            $this->app_postback($click,$share_conversion); 
                    }
                }
            

            return response()->json(['success' => 'Conversion Recorded Successfully!']);
        }
    }

    /**
     * Postback
     * @param $id
     * @param $event
     * @return bool|void
     * @throws GuzzleException
     */
    public function postback($click, $conversion, $event)
    {
        //$click = Click::find($id);
        $postbacks = Postback::where([
            ['status', '=',1],
            ['offer_id', '=', $click->offer_id],
            ['student_id', '=', $click->student_id],
            ['event', '=', $event]
        ])
            ->orWhere([
                ['offer_id', '=', null],
                ['status', '=',1],
                ['student_id', '=', $click->student_id],
                ['event', '=', $event]
            ])->get();
        foreach ($postbacks as $postback) {
            $link = $postback->postback;
            $link = str_replace('{offer_id}', $click->offer_id, $link);
            $link = str_replace('{stu_sub}', $click->stu_sub, $link);
            $link = str_replace('{stu_sub2}', $click->stu_sub2, $link);
            $link = str_replace('{stu_sub3}', $click->stu_sub3, $link);
            $link = str_replace('{stu_sub4}', $click->stu_sub4, $link);
            $link = str_replace('{stu_sub5}', $click->stu_sub5, $link);
            $link = str_replace('{stu_click}', $click->stu_click, $link);
            $link = str_replace('{source}', $click->source, $link);
            $link = str_replace('{country}', $click->country, $link);
            $link = str_replace('{region}', $click->state, $link);
            $link = str_replace('{city}', $click->city, $link);
            $link = str_replace('{payout}', $conversion->payout, $link);
            $link = str_replace('{currency}', $conversion->currency, $link);
            $link = str_replace('{sale_amount}', $conversion->sale_amount, $link);
            $link = str_replace('{click_ip}', $conversion->click_ip, $link);
            $link = str_replace('{conversion_ip}', $conversion->conversion_ip, $link);
            $link = str_replace('{operating_system}', $click->os_name, $link);
            $link = str_replace('{browser_name}', $click->browser_name, $link);
            $link = str_replace('{browser_version}', $click->browser_version, $link);
            $link = str_replace('{useragent}', $click->user_agent, $link);
            $link = str_replace('{click_time}', $click->created_at, $link);

            /**
             * If postback url is not empty, then we will send postback request
             */

            try {

                $client = new \GuzzleHttp\Client();
                $response = $client->request('GET', $link);
                $pb_sent = new PostbackLog();
                $pb_sent->postback_id = $postback->id;
                $pb_sent->student_id = $click->student_id;
                $pb_sent->offer_id = $click->offer_id;
                $pb_sent->event = $event;
                $pb_sent->postback = $link;
                $pb_sent->status = $response->getStatusCode();
                $pb_sent->body = (string)$response->getBody();
                $pb_sent->save();
            } catch (RequestException $ex) {
                $pb_sent = new PostbackLog();
                $pb_sent->postback_id = $postback->id;
                $pb_sent->student_id = $click->student_id;
                $pb_sent->offer_id = $click->offer_id;
                $pb_sent->event = $event;
                $pb_sent->postback = $link;
                $pb_sent->status = $ex->getCode();
                $pb_sent->body = $ex->getMessage();
                $pb_sent->save();
            }
        }
    }


    protected function conversion($click, $offer, $ip, $event, $sale_amount)
    {
        $conversion = new Conversion();
        // to check if student payout is sent for this event and offer
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

        $redirectlink='https://cashbackgullak.com/ptrack';
        
        $link='https://cashbackgullak.com/ptrack?oname='.$click->offer_name.'&aname='.$user->name.'&phno='.$conversion->paytm_no.'&dpay='.$conversion->payout;
            try {

                $client = new \GuzzleHttp\Client();
                $access_token='eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9';
                
                $response = $client->request('POST', $redirectlink, [
                'headers' => [ 'Authorization' => 'Bearer ' . $access_token],
                'form_params' => [
                        'oname' =>$click->offer_name, 
                        'aname' => $user->name, 
                        'phno' => $conversion->paytm_no,
                        'dpay' =>$conversion->payout,
                    ]
                ]);
                 

                $pb_sent = new AppPostback();
                $pb_sent->student_id = $click->student_id;
                $pb_sent->offer_id = $click->offer_id;
                $pb_sent->event = $conversion->event;
                $pb_sent->postback = $link;
                $pb_sent->status = $response->getStatusCode();
                $pb_sent->message =($response->getBody()->getContents());
                $pb_sent->save();
              
                //dd($response->getBody());
                
             
            } catch (RequestException $ex) {
                $pb_sent = new AppPostback();
                $pb_sent->student_id = $click->student_id;
                $pb_sent->offer_id = $click->offer_id;
                $pb_sent->event = $conversion->event;
                $pb_sent->postback = $link;
                $pb_sent->status = $ex->getCode();
                $pb_sent->message = $ex->getMessage();
                $pb_sent->save();
                
            }
        
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
    
    public function app_post(Request $request)
    {
        
        //https://api.github.com/user


        //$res = $client->get('https://cashbackgullak.com/ptrack?oname=mac&aname=Shahbaz%20Ansari&phno=7905454611&dpay=1.00');
                $access_token='eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9';
            
                $client = new \GuzzleHttp\Client();
              
                $response = $client->request('POST', 'https://cashbackgullak.com/ptrack',[
                'headers' => [ 'Authorization' => 'Bearer ' . $access_token],
                 'form_params' => [
                        'oname' =>'s', 
                        'aname' => 's', 
                        'phno' => 7905454610,
                        'dpay' =>5,
                    ]
                ]);

                   //var_dump($response->getBody()->getContents());
                   //dd($response);
               
                
    }

    
    
    
}
