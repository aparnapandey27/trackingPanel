<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Offer;
use App\Models\OfferGoal;
use App\Models\User;
use Illuminate\Http\Request;

class CommonController extends Controller
{
    /**
     * Get All Active Students
     */
    public function getStudents(Request $request)
    {
        $search = $request->search;
        //$role_id = $request->user_type == 'advertiser' ? '3' : '2';

        if ($search == '') {
            $students = User::student()->where('manager_id', auth()->user()->id)->active()
                ->select('id', 'name')
                ->get();
        } else {
            $students = User::student()->where('manager_id', auth()->user()->id)->active()
                ->select('id', 'name')
                ->where('name', 'LIKE', '%' . $search . '%')
                ->orwhere('id', 'LIKE', '%' . $search . '%')
                ->get();
        }

        $response = array();
        foreach ($students as $student) {
            $response[] = array(
                'id' => $student->id,
                'text' => "[$student->id]" . ' ' . $student->name
            );
        }

        echo json_encode($response);
        exit;
    }

    /**
     * Get All Active Offers
     */
    public function getOffers(Request $request)
    {
        $search = $request->search;

        if ($search == '') {
            $offers = Offer::active()
                ->select('id', 'name')
                ->get();
        } else {
            $offers = Offer::active()
                ->select('id', 'name')
                ->where('name', 'LIKE', '%' . $search . '%')
                ->orwhere('id', 'LIKE', '%' . $search . '%')
                ->get();
        }

        $response = array();
        foreach ($offers as $offer) {
            $response[] = array(
                'id' => $offer->id,
                'text' =>  "[$offer->id]" . ' ' . $offer->name
            );
        }

        echo json_encode($response);
        exit;
    }
    
    public function getOfferGoals(Request $request)
    {
        $offer_id = $request->offerId;
        
        $offerGoal = OfferGoal::where('offer_id', $offer_id)->get();
        
        $response = array();
        foreach ($offerGoal as $goals) {
            $response[] = array(
                'name' => $goals->name,
                'offer_model' =>$goals->offer_model,
                'currency'=>$goals->currency,
                'default_payout'=>$goals->default_payout,
                'percent_payout'=>$goals->percent_payout
            );
        }
        echo json_encode($response);
        exit;
    }
}
