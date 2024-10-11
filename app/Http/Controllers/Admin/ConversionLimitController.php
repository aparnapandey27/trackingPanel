<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Offer;
use App\Models\User;
use App\Models\ConversionLimit;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ConversionLimitController extends Controller
{
    public function create($id)
    {
        $offer = Offer::find($id);
        return view('admin.conversionLimit.create', compact('offer'));
    }
    
    public function store(Request $request)
    {
        
        try {
        $request->validate([
            'offer_id' => 'required',
           'student_id'=>'required',
            'goal_name' => 'required',
            'conversion_limit' =>'required',
        ]);
        try {
            $conversionlimit = new ConversionLimit();
            $conversionlimit->offer_id = $request->offer_id;
            $conversionlimit->student_id = $request->student_id;
            $conversionlimit->name = $request->goal_name;
            $conversionlimit->conversionlimit = $request->conversion_limit;
            $conversionlimit->save();
            Toastr::success('Student Offer Conversion Limit Successfully Created', 'Success');
            return redirect()->route('admin.offers.show', $request->offer_id);
        }
        catch (\Exception $e) {
            Toastr::error('Error creating Offer Conversion Limit: Duplicate Entry. To update details click on edit button in offer page ', 'Error');
            return redirect()->back()->withInput();
        }
    
        }
        catch (ValidationException $e) {
           return redirect()->back()->withErrors($e->validator)->withInput();
       }
    }
    
    public function edit($offerid, $convlimitid)
    {
        $conversionlimit = ConversionLimit::where('offer_id', $offerid)->find($convlimitid);
        $offer = Offer::find($offerid);
        return view('admin.conversionLimit.edit', compact(['offer','conversionlimit']));
    }
    
    public function update(Request $request, $offerid, $convlimitid)
    {
        $request->validate([
           'student_id'=>'required',
            'goal_name' => 'required',
        ]);

        $conversionlimit = ConversionLimit::where('offer_id', $offerid)->find($convlimitid);
    
        $conversionlimit->student_id = $request->student_id;
        $conversionlimit->name = $request->goal_name;
        $conversionlimit->conversionlimit = $request->conversion_limit;
        $conversionlimit->update();
        Toastr::success('Offer student Conversion Limit Successfully Updated', 'Success');

        return redirect()->route('admin.offers.show', $offerid);
    }
    
    public function destroy($id)
    {
        $conversionlimit = ConversionLimit::destroy($id);

        if ($conversionlimit) {
            Toastr::success('Offer student Conversion Limit Successfully Deleted', 'Success');
            return;
        } else {
            Toastr::error('Offer student Conversion Limit Not Deleted', 'Error');
            return;
        }
    }



}
