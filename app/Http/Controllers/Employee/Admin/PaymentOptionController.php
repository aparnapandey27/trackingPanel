<?php

namespace App\Http\Controllers\Employee\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentOption;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PaymentOptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = PaymentOption::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()

                ->editColumn('minimum_threshold', function ($row) {
                    return $row->minimum_threshold . ' ' . config('app.currency');
                })

                ->editColumn('created_at', function (PaymentOption $paymentOption) {
                    return $paymentOption->created_at->format('d-M-Y' . '  -  ' . 'h:i A');
                })
                ->addColumn('action', function (PaymentOption $paymentOption) {

                    $btn = '<a href="javascript:void(0)" onclick="editPaymentMethod(' . $paymentOption->id . ')" class="btn btn-info  btn-sm mb-2"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><path d="m16.474 5.408l2.118 2.117m-.756-3.982L12.109 9.27a2.118 2.118 0 0 0-.58 1.082L11 13l2.648-.53c.41-.082.786-.283 1.082-.579l5.727-5.727a1.853 1.853 0 1 0-2.621-2.621Z"/><path d="M19 15v3a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2h3"/></g></svg></a>
                            <a href="javascript:void(0)" data-toggle="tooltip"  onclick="deletePaymentMethod(' . $paymentOption->id . ')" data-original-title="Delete" class="btn btn-danger  btn-sm mb-2"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"><path fill="currentColor" d="M7 21q-.825 0-1.413-.588T5 19V6H4V4h5V3h6v1h5v2h-1v13q0 .825-.588 1.413T17 21H7ZM17 6H7v13h10V6ZM9 17h2V8H9v9Zm4 0h2V8h-2v9ZM7 6v13V6Z"/></svg></a>';
                    return $btn;
                })
                ->addColumn('checkbox', '<input type="checkbox" name="offer_checkbox[]" class="checkbox c-checkbox offer_checkbox" value="{{$id}}" />')
                ->rawColumns(['minimum_threshold', 'checkbox', 'action',])
                ->make(true);
        }
        return view('admin.preference.payment_option');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'name' => 'required|unique:payment_options',
        ]);
        $paymentOption = new PaymentOption();
        $paymentOption->name = $request->name;
        $paymentOption->minimum_threshold = $request->minimum_threshold;
        $paymentOption->save();
        return response()->json(['success' => 'Payment Option Added successfully.']);
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
    public function edit($id)
    {
        $paymentOption = PaymentOption::find($id);
        return response()->json($paymentOption);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $paymentOption = PaymentOption::find($id);
        $paymentOption->name = $request->name;
        $paymentOption->minimum_threshold = $request->minimum_threshold;
        $paymentOption->update();
        return response()->json(['success' => 'Payment Option Updated successfully.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        PaymentOption::destroy($id);
    }
}
