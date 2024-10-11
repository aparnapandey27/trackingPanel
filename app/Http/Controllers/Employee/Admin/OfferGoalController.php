<?php

namespace App\Http\Controllers\Employee\Admin;

use App\Http\Controllers\Controller;
use App\Models\Offer;
use App\Models\GoalName;
use App\Models\OfferGoal;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class OfferGoalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $offer = Offer::find($id);
        return view('admin.offerGoal.create', compact('offer'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'offer_id' => 'required',
        ]);
        
        $offer = Offer::find($request->offer_id);
        
        $offerGoal = new OfferGoal();
        $fetchGoal = OfferGoal::where('offer_id',$offer->id)->get();
        $events = GoalName::all(); 
        $nextEvent = null;
    
        foreach ($fetchGoal as $goal) {        
            foreach ($events as $event) {
                
                if ($goal->goal_id == $event->id) {
                    $nextEvent = GoalName::where('id', $goal->goal_id + 1)->first(); 
                    break;            
                }  
                  
            }
        }
    
        
        if (!$nextEvent) {
            return redirect()->route('admin.offer.show', $offer->id);
        }
        $offerGoal->offer_id = $request->offer_id;
        $offerGoal->goal_id = $nextEvent->id;
        $offerGoal->pay_model = $request->pay_model;
        $offerGoal->currency = $request->currency != null ? $request->currency : config('app.currency');
        $offerGoal->default_revenue = $request->revenue != null ? $request->revenue : 0;
        $offerGoal->default_payout = $request->payout != null ? $request->payout : 0;
        $offerGoal->percent_revenue = $request->percent_revenue != null ? $request->percent_revenue : 0;
        $offerGoal->percent_payout = $request->percent_payout != null ? $request->percent_payout : 0;
        $offerGoal->save();
        
        
        Toastr::success('Offer Goal Successfully Created', 'Success');

        return redirect()->route('admin.offer.show', $request->offer_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($offer, $goal)
    {
        $offerGoal = OfferGoal::where('offer_id', $offer)->find($goal);
        return view('admin.offerGoal.edit', compact('offerGoal'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $offer, $goal)
    {
    
        $offerGoal = OfferGoal::where('offer_id', $offer)->find($goal);
        // // $offerGoal->offer_id = $offer;
        // $offerGoal->name = $request->name;
        if ($offerGoal->goal_id == 1) {
            // Update the Offer table if goal_id is 1
            $offer = Offer::find($offer);
            if ($offer) {
                $offer->offer_model = $request->pay_model;
                $offer->currency = $request->currency;
                $offer->default_revenue = $request->revenue != null ? $request->revenue : 0;
                $offer->default_payout = $request->payout != null ? $request->payout : 0;
                $offer->percent_revenue = $request->percent_revenue != null ? $request->percent_revenue : 0;
                $offer->percent_payout = $request->percent_payout != null ? $request->percent_payout : 0;
                $offer->update();
            }
        }
        $offerGoal->pay_model = $request->pay_model;
        $offerGoal->currency = $request->currency;
        $offerGoal->default_revenue = $request->revenue != null ? $request->revenue : 0;
        $offerGoal->default_payout = $request->payout != null ? $request->payout : 0;
        $offerGoal->percent_revenue = $request->percent_revenue != null ? $request->percent_revenue : 0;
        $offerGoal->percent_payout = $request->percent_payout != null ? $request->percent_payout : 0;
        $offerGoal->update();
        Toastr::success('Offer Goal Successfully Updated', 'Success');

        return redirect()->route('admin.offer.show', $offer);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $offerGoal = OfferGoal::destroy($id);

        if ($offerGoal) {
            Toastr::success('Offer Goal Successfully Deleted', 'Success');
        } elseif ($offerGoal->goal_id == 1) {
            // Prevent deletion if goal_id is 1
            Toastr::warning('Cannot Delete this Goal', 'Warning');
        } else {
            $offerGoal->delete();
            Toastr::error('Offer Goal Not Deleted', 'Error');
        }
        return;
    }
}
