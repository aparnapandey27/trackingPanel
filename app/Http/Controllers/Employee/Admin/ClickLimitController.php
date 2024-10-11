<?php

namespace App\Http\Controllers\Employee\Admin;

use App\Http\Controllers\Controller;
use App\Models\Offer;
use App\Models\User;
use App\Models\ClickLimit;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ClickLimitController extends Controller
{
    public function create($id)
    {
        $offer = Offer::find($id);
        return view('admin.clickLimit.create', compact('offer'));
    }
    
    public function store(Request $request)
    {
        
        try {
        $request->validate([
            'offer_id' => 'required',
           'student_id'=>'required',
            'click_limit' =>'required',
        ]);
        try {
            $clicklimit = new ClickLimit();
            $clicklimit->offer_id = $request->offer_id;
            $clicklimit->student_id = $request->student_id;
            $clicklimit->clicklimit = $request->click_limit;
            $clicklimit->save();
            Toastr::success('Student Offer Click Limit Successfully Created', 'Success');
            return redirect()->route('admin.offer.show', $request->offer_id);
        }
        catch (\Exception $e) {
            Toastr::error('Error creating Offer Click Limit: Duplicate Entry. To update details click on edit button in offer page ', 'Error');
            return redirect()->back()->withInput();
        }

        }
        catch (ValidationException $e) {
           return redirect()->back()->withErrors($e->validator)->withInput();
       }
    }
    
    public function edit($offerid, $clicklimitid)
    {
        $clicklimit = ClickLimit::where('offer_id', $offerid)->find($clicklimitid);
        $offer = Offer::find($offerid);
        return view('admin.clickLimit.edit', compact(['offer','clicklimit']));
    }
    
    public function update(Request $request, $offerid, $clicklimitid)
    {
        $request->validate([
           'student_id'=>'required',
        ]);

        $clicklimit = ClickLimit::where('offer_id', $offerid)->find($clicklimitid);
    
        $clicklimit->student_id = $request->student_id;
        $clicklimit->clicklimit = $request->click_limit;
        $clicklimit->update();
        Toastr::success('Offer Student Click Limit Successfully Updated', 'Success');

        return redirect()->route('admin.offer.show', $offerid);
    }
    
    public function destroy($id)
    {
        $clicklimit = ClickLimit::destroy($id);

        if ($clicklimit) {
            Toastr::success('Offer Student Click Limit Successfully Deleted', 'Success');
            return;
        } else {
            Toastr::error('Offer Student Click Limit Not Deleted', 'Error');
            return;
        }
    }



}
