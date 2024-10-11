<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Offer;
use App\Models\OfferRequest;
use App\Models\OfferSharePayout;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OfferFeedController extends Controller
{
    public function index()
    {
        return view('student.offer-feed.index');
    }
    
    public function offer_feed(Request $request)
    {
        $stuid = $request->stuid;

        if (!$stuid) {
            return response()->json(['error' => 'Student ID is required'], 400);
        } else {
            $user = User::find($stuid);
            if (!$user) {
                return response()->json(['error' => 'Student ID is not found'], 400);
            }
        }
        
        $data = Offer::where('status', 1)
            ->whereIn('offer_permission', ['public', 'request'])
            ->orderBy('id', 'desc')
            ->get();
        $stu_offer_data=$this->student_active_offers($data,$stuid);
            
        return response()->json([
            'success' => true,
            'name'=>'Trackopia',
            'message' => 'Offers retrieved successfully',
            'offers' => $stu_offer_data
        ], 200);
    }
    
 

   // offerid with student id
   public function stu_offer_feed(Request $request)
    {
        $stuid = $request->stuid;
        $offerid=$request->offerid;

        if (!$stuid & !$offerid) {
            return response()->json(['success' => false,'message' => 'Student ID and Offer ID are required'], 400);
        } else {
            $user = User::find($stuid);
            if (!$user) {
                return response()->json(['success' => false,'message' => 'Student ID is not found'], 400);
            }
            $myoffer=Offer::find($offerid);
            if (!$myoffer) {
                return response()->json(['success' => false,'message' => 'Offer ID is not found'], 400);
            }

        }

        // Auth::loginUsingId($stuid);

        $data = Offer::where([['status', 1],['id',$offerid]])
            ->whereIn('offer_permission', ['public', 'request'])
            ->orderBy('id', 'desc')
            ->first();
        
        $offer_data=$this->student_offer_data($data,$stuid);    
     

        return response()->json([
            'success' => true,
            'message' => 'Offers retrieved successfully',
            'offers' => $offer_data
        ], 200);
    }

   
    /**
     * Payout cacuation.
     */
    protected function getPayout($offer)
    {
        if ($offer->offer_model == 'RevShare') {
            return $offer->percent_payout . '%';
        } elseif ($offer->offer_model == 'Hybrid') {
            return $offer->default_payout . ' ' . $offer->currency . ' + ' . $offer->percent_payout . '%';
        } else {
            return $offer->default_payout . ' ' . $offer->currency;
        }
    }

    /**
     * Get offer status.
     */
    protected function getStatus($offer, $stuid)
    {
        if ($offer->offer_permission == 'public') {
            return 'approved';
        } elseif ($offer->offer_permission == 'private') {
            return 'approved';
        } elseif ($offer->offer_permission == 'request') {
            $checkstatus2 = OfferRequest::select('status')->where('offer_id', $offer->id)->where('user_id', $stuid)->pluck('status')->toArray();
            if (!empty($checkstatus2)  == 0) {
                return 'available';
            } else {
                foreach ($checkstatus2 as $checkstatus) {
                    if ($checkstatus == 0) {
                        return 'pending';
                    } elseif ($checkstatus == 1) {
                        return 'approved';
                    } elseif ($checkstatus == 2) {
                        return 'rejected';
                    } elseif ($checkstatus == 3) {
                        return 'blocked';
                    }
                }
            }
        }
        //return  $status;
    }

    /**
     * Check & Get offer goals.
     */
    protected function getGoals($offer)
    {
        $goals = $offer->goals;
        $data = [];
        foreach ($goals as $goal) {
            $data[] = [
                'name' => $goal->name,
                'goal_type' => $goal->offer_model,
                'payout' => $this->getPayout($goal),
            ];
        }
        return $data;
    }
    
    protected function getShareGoals($offerid,$stuid)
    {
        
        $offerShare = OfferSharePayout::select('*')
        ->where('offer_id', $offerid)
        ->where('student_id', $stuid)
        ->orderBy('id', 'desc')
        ->get()
        ->map(function ($offerShare) {
            return [
                'goal1_name' => $offerShare->goal1_name,
                'goal1_share_payout' => $offerShare->goal1_share_payout,
                'goal2_name' => $offerShare->goal2_name,
                'goal2_share_payout' => $offerShare->goal2_share_payout,
            ];
        });
        return $offerShare;
    }
    
     



    /**
     * Get offer GEO.
     */
    public function getCountries($offer)
    {
        $countries = $offer->countries;
        $data = [];
        foreach ($countries as $country) {
            $data[] = [
                'name' => $country->name,
                'code' => $country->code,
            ];
        }
        return $data;
    }

    /**
     * Get offer States.
     */
    public function getStates($offer)
    {
        $states = $offer->states;
        $data = [];
        foreach ($states as $state) {
            $data[] = [
                'name' => $state->state_name,
                'code' => $state->state_code,
            ];
        }
        return $data;
    }

    /**
     * Get offer Categories.
     */
    public function getTrackingDomain()
    {
        if (config('app.tracking_domain') != null) {
            return config('app.tracking_domain') . '/';
        } else {
            return asset('/');
        }
    }
    
    protected function student_active_offers($offdata, $stuid) {
         $stu_data=[];
         foreach($offdata as $data)
         {
            $stu_data[]=[
                    'id'   => $data->id,
                    'name' => $data->name,
                    'image'=>$data->thumbnail,
                    'description' => $data->description,
                    'note'=>$data->note,
                    'conversion_flow' => $data->conv_flow,
                    'offer_type' => $data->offer_model,
                    'final_payout' => $this->getPayout($data),
                    'currency'=>$data->currency,
                    'default_payout'=>$data->default_payout,
                    'percent_payout'=>$data->percent_payout,
                    'category' => $data->category_id != null ? $data->category->name : '',
                    'geo' => $this->getCountries($data),
                    'user_status' => $this->getStatus($data, $stuid),
                    'conversion_tracking' => $data->conversion_tracking,
                    'offer_permission' => $data->offer_permission,
                    'created_at' => $data->created_at,
                    'preview_url' => $data->preview_url,
                    'tracking_url' => $this->getStatus($data, $stuid) == 'approved' ? $this->getTrackingDomain() . 'click?aid=' . $stuid . '&oid=' . $data->id : '',
                    'preview_image' => $data->thumbnail != null ? url('/storage/offers/' . $data->thumbnail) : null,
                    'has_goal' => $data->goals->count() > 0 ? true : false,
                    'goals'=>$data->goals,
                    'is_featured'=>$data->is_featured,
                    'same_ip_conversion'=>$data->same_ip_conversion,
                    'conversion_approval'=>$data->conversion_approval,
                    'min_conversion_time'=>$data->min_conversion_time,
                    'max_conversion_time'=>$data->max_conversion_time,
                    'expire_date'=>$data->expire_at,
                    'refer_rule'=>$data->refer_rule,
                    'redirect_offer_id'=>$data->redirect_offer_id,
                    
                ];
         }
         return $stu_data;
    }
    
    protected function student_offer_data($data, $stuid) {
                 $mydata[]=[
                    'aid'=>$stuid,
                    'id'   => $data->id,
                    'name' => $data->name,
                    'description' => $data->description,
                    'conversion_flow' => $data->conv_flow,
                    'offer_type' => $data->offer_model,
                    //'payout' => $this->getPayout($data),
                    'offer_goals'=> $this->getShareGoals($data->id,$stuid),
                    'category' => $data->category_id != null ? $data->category->name : '',
                    'geo' => $this->getCountries($data),
                    'user_status' => $this->getStatus($data, $stuid),
                    'conversion_tracking' => $data->conversion_tracking,
                    'offer_permission' => $data->offer_permission,
                    'created_at' => $data->created_at,
                    'preview_url' => $data->preview_url,
                    'tracking_url' => $this->getStatus($data, $stuid) == 'approved' ? $this->getTrackingDomain() . 'click?aid=' . $stuid . '&oid=' . $data->id : '',
                    'preview_image' => $data->thumbnail != null ? url('/storage/offers/' . $data->thumbnail) : null,
                    'has_goal' => $data->goals->count() > 0 ? true : false,
                ];
                return $mydata;
            }    
   
            
}
