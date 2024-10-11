<?php

namespace App\Http\Controllers\Employee\Admin;

use App\Http\Controllers\Controller;
use App\Models\Offer;
use App\Models\User;
use App\Models\OfferStudent;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class OfferStudentController extends Controller
{
    public function create($id)
    {
        $offer = Offer::find($id);
        return view('admin.offerStudent.create', compact('offer'));
    }
    
    public function store(Request $request)
    {
        
        try {
        $request->validate([
            'offer_id' => 'required',
           'student_id'=>'required',
            'goal_name' => 'required',
        ]);
        try {
            $offerStudent = new OfferStudent();
            $offerStudent->offer_id = $request->offer_id;
            $offerStudent->student_id = $request->student_id;
            $offerStudent->name = $request->goal_name;
            $offerStudent->pay_model = $request->payModel;
            $offerStudent->currency = $request->currency != null ? $request->currency : config('app.currency');
            $offerStudent->default_payout = $request->defaultPayout != null ? $request->defaultPayout : 0;
            $offerStudent->percent_payout = $request->percentPayout != null ? $request->percentPayout : 0;
            $offerStudent->save();
            Toastr::success('Student Offer Payout Successfully Created', 'Success');
            return redirect()->route('admin.offer.show', $request->offer_id);
        }
        catch (\Exception $e) {
            Toastr::error('Error creating Offer Student: Duplicate Entry. To update details click on edit button in offer page ', 'Error');
            return redirect()->back()->withInput();
        }

        }
        catch (ValidationException $e) {
           return redirect()->back()->withErrors($e->validator)->withInput();
       }
    }
    
    public function edit($offerid, $studentid)
    {
        $offerStudent = OfferStudent::where('offer_id', $offerid)->find($studentid);
        $offer = Offer::find($offerid);
        return view('admin.offerStudent.edit', compact(['offer','offerStudent']));
    }
    
    public function update(Request $request, $offerid, $astudentid)
    {
        $request->validate([
           'student_id'=>'required',
            'goal_name' => 'required',
        ]);

        
        $offerStudent = OfferStudent::where('offer_id', $offerid)->find($studentid);
        
    
        $offerStudent->student_id = $request->student_id;
        $offerStudent->name = $request->goal_name;
        $offerStudent->pay_model = $request->payModel;
        $offerStudent->currency = $request->currency != null ? $request->currency : config('app.currency');
        $offerStudent->default_payout = $request->defaultPayout != null ? $request->defaultPayout : 0;
        $offerStudent->percent_payout = $request->percentPayout != null ? $request->percentPayout : 0;
        
     
        $offerStudent->update();
        Toastr::success('Offer Student Payout Successfully Updated', 'Success');

        return redirect()->route('admin.offer.show', $offerid);
    }
    
    public function destroy($id)
    {
        $offerStudent = OfferStudent::destroy($id);

        if ($offerStudent) {
            Toastr::success('Offer Student Payout Successfully Deleted', 'Success');
            return;
        } else {
            Toastr::error('Offer Student Payout Not Deleted', 'Error');
            return;
        }
    }



}
