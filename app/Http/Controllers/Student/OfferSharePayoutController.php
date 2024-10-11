<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;

use App\Models\OfferSharePayout;

use Illuminate\Http\Request;


use Symfony\Component\Console\Output\ConsoleOutput;


class OfferSharePayoutController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'offer_id' => 'required',
            'student_id' => 'required',
            'name' => 'required',
        ]);
        // if offer share payout already exists
       
        $offerShare = OfferSharePayout::updateOrCreate(['offer_id'=> $request->offer_id,'student_id'=>$request->student_id]);
        $offerShare->name = $request->name;
        $offerShare->goal1_name = $request->goal1_name != null ? $request->goal1_name : null;
        $offerShare->goal1_share_payout = $request->goal1_share_payout != null ? $request->goal1_share_payout : 0;
        $offerShare->goal2_name = $request->goal2_name != null ? $request->goal2_name : null;
        $offerShare->goal2_share_payout = $request->goal2_share_payout != null ? $request->goal2_share_payout : 0;
        $offerShare->has_goals = $request->has_goals != null ? $request->has_goals : 0;
        $offerShare->save();
    
        //Toastr::success('Offer Share Payout Successfully Created', 'Success');
        return redirect()->route('student.offer.show', $request->offer_id);
       
    }

    
}
