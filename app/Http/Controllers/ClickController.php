<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use App\Models\Click;
use App\Models\ClickLimit;
use App\Models\Country;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Jenssegers\Agent\Agent;


class ClickController extends Controller
{
    private function isStudentActive($student)
    {
    
      return $student && $student->status == 1;
    }
    
    function generateRandomAlphaNumericString($length = 6) {
    $characters = 'abcdefghijklmnopqrstuvwxyz';
    $randomString = '';

    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }

    return $randomString;
    }



    public function index(Request $request)
    {
        $ip = (isset($_SERVER["HTTP_CF_CONNECTING_IP"]) ? $_SERVER["HTTP_CF_CONNECTING_IP"] : $_SERVER['REMOTE_ADDR']);
        //$ip_check = geoip()->getLocation($ip);
        //$ip = $ip_check->toArray();
        //$tip = $ip['ip'];
        $c_state = 'Uttar Pradesh';
        $c_country ='IN';
        $aid = $request->aid;
        $oid = $request->oid;
        $stu_sub = $request->stu_sub;
        $stu_sub2 = $request->stu_sub2;
        $stu_sub3 = $request->stu_sub3;
        $stu_sub4 = $request->stu_sub4;
        $stu_sub5 = $request->stu_sub5;
        $stu_click = $request->stu_click;
        $source = $request->source;
        $paytm_no=$request->paytm_no;

        /**
         * Browser and Device info getting start
         */
         $agent = new Agent();
        
        if ($agent->isDesktop() == true) {
            $device = 'Desktop';
        } elseif ($agent->isMobile() == true) {
            $device = 'Mobile';
        } elseif ($agent->isTablet() == true) {
            $device = 'Tablet';
        } elseif ($agent->is('iPhone')== true) {
            $device = 'iPhone';
        }else {
            $device = 'Other';
        }

        if ($agent->device() == 'WebKit') {
            $device_name = 'Computer';
        } else {
            $device_name = $agent->device();
        }

        $browser = $agent->browser();
        $version = $agent->version($browser);
        $os_name = $agent->platform();
        $os_version = $agent->version($os_name);


        /**
         * If student ID and Offer ID is valid then we will generate unique click ID
         */
    
        if ($aid && $oid != 0) {
            //$click_id = substr(md5(strtotime('now') . uniqid()) . rand(0000000000, 9999999999), rand(1, 5), 30);
            $randomString = $this->generateRandomAlphaNumericString(6);
             $click_id='T'.'_'.$aid.'_'.$oid.'_'.now()->format('dmY').'_'.now()->format('His').'_'.$randomString;
        } else {
            die('Invalid Link');
        }

        /*
        *Checking Student acount is active or not
        */
        $student = User::find($aid);
        
        if (!$this->isStudentActive($student)) {
            die('Invalid Link');
        }


        /*
        * getting offer details
        */
        $offer_check = Offer::find($oid);

        /*
        * if offer not found then through the traffic to google
        */
        if ($offer_check==null) {
            return redirect(config('app.offer_fallback'));
            // return 'offer check failed';
        }

        /*
        * checking offer active or not
        */
        if ($offer_check->status != 1) {

            /*
            * checking offer not active then we are looking if offer has 2nd offer for redirect.
            * if no redirect offer found then through the traffic to google
            */
            if ($offer_check->redirect_offer_id) {
                $offer = Offer::findorFail($offer_check->redirect_offer_id);
                $oid = $offer->id;
            } else {
                return redirect(config('app.offer_fallback'));
                // return 'offer redicrect failed';
            }
        } else {
            $offer = $offer_check;
            // find offer click limit for particular student if exists
            $climit=ClickLimit::where('offer_id',$oid)->where('student_id',$aid)->first();
            if($climit!=null)
            {
                $clicklimit=$climit->clicklimit;
                $userClicks = Click::where('student_id', $aid)
                       ->where('offer_id', $oid)
                       ->count();
             if ($userClicks >= $clicklimit) {
                 
               //return redirect()->back()->with('error', 'Maxmium click reached');
                return redirect(config('app.offer_fallback'));
              }
           
            }
           
        }
       

        /**
         * We checking Indian states and then redirecting to the offer url
         */
        if ($c_country == 'IN' && $offer->countries->count() != 0 && $offer->states->count() != 0) {
            $statecheck = Offer::where('id', $oid)
                ->whereHas('states', function ($query) use ($ip) {
                    $query->where('state_code', 'UP');
                })->count();
        } else {
            $statecheck = 1;
        }

      

        /**
         * we are checking geo restriction then we will redirect to the offer url
         */
        if ($offer->countries->count() != 0) {
            $countrycheck = Offer::Where('id', $oid)
                ->whereHas('countries', function ($query) use ($ip) {
                    $query->where('code', 'like', '%' . 'IN' . '%');
                })->count();
        } else {
            $countrycheck = 1;
        }

       

        /**
         * check device restriction
         */

        if ($offer->devices->count() != 0) {
            $devicecheck = Offer::Where('id', $oid)
                ->whereHas('devices', function ($query) use ($device) {
                    $query->where('name', 'like', '%' . $device . '%');
                })->count();
        } else {
            $devicecheck = 1;
        }

        

        /**
         * check browser restriction
         */

        if ($offer->browsers->count() != 0) {
            $browsercheck = Offer::Where('id', $oid)
                ->whereHas('browsers', function ($query) use ($browser) {
                    $query->where('name', 'like', '%' . $browser . '%');
                })->count();
        } else {
            $browsercheck = 1;
        }

        

        if ($countrycheck === 0 || $devicecheck === 0 || $browsercheck === 0) {
            return redirect(config('app.offer_fallback'));
        }

        /**
         * Everything goes well then we will store the click details in the database
         */
        $click = new Click();
        $click->offer_name = $offer->name;
        $click->offer_id = $oid;
        $click->student_id = $aid;
        $click->advertiser_id = $offer->advertiser_id;
        $click->manager_id = $student->manager_id;
        $click->transaction_id = $click_id;
        $click->country = $c_country;
        $click->state = $c_state;
        $click->city = 'test';
        $click->user_agent = $request->header('User-Agent');
        $click->device_type = $device;
        $click->device_name = $device_name;
        $click->os_name = $os_name;
        $click->os_version = $os_version;
        $click->browser_name = $browser;
        $click->browser_version = $version;
        $click->ip_address = $ip;
        $click->stu_sub = $stu_sub;
        $click->stu_sub2 = $stu_sub2;
        $click->stu_sub3 = $stu_sub3;
        $click->stu_sub4 = $stu_sub4;
        $click->stu_sub5 = $stu_sub5;
        $click->stu_click = $stu_click;
        $click->source = $source;
        $click->paytm_no = $paytm_no;
        $click->save();


    // Combine str_replace into a single call
     $link = str_replace(
        ['{click_id}', '{stu_id}', '{offer_id}', '{stu_sub}', '{stu_sub2}', '{stu_sub3}', '{stu_sub4}', '{stu_sub5}', '{stu_click}', '{source}'],
        [$click_id, $aid, $oid, $stu_sub, $stu_sub2, $stu_sub3, $stu_sub4, $stu_sub5, $stu_click, $source],
        $offer->tracking_url
     );

    // Redirect based on refer_rule
    $referrerPolicy = ($offer->refer_rule == '302') ? 'referrer' : 'no-referrer';
    return redirect()->to($link, 302, ['Referrer-Policy' => $referrerPolicy]);
  }
        
}
