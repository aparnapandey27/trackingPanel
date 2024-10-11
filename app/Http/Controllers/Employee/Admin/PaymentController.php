<?php

namespace App\Http\Controllers\Employee\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Yajra\DataTables\Facades\DataTables;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Payment::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('student', function (Payment $payment) {
                    return '<a href="' . route('admin.students.manage', $payment->user->id) . '">[' . $payment->user->id . '] ' . $payment->user->name . '</a>';
                })
                ->addColumn('method', function (Payment $payment) {
                    return $payment->payment_method;
                })
                ->editColumn('amount', function (Payment $payment) {
                    return $payment->amount . ' ' . $payment->currency;
                })
                ->editColumn('payable_amount', function (Payment $payment) {
                    return '<strong>' . $payment->payable_amount . ' ' . $payment->currency . '</strong>';
                })
                ->editColumn('status', function (Payment $payment) {
                    if ($payment->status == 0) {
                        $status = '<span class="badge badge-success"><i class="fa fa-clock-o"></i> Pending</span>';
                    } elseif ($payment->status == 1) {
                        $status = '<span class="badge badge-primary"><i class="fa fa-check"></i> Paid</span>';
                    } elseif ($payment->status == 2) {
                        $status = '<span class="badge badge-danger"><i class="fa fa-times"></i>
                        Cancelled</span>';
                    } elseif ($payment->status == 3) {
                        $status = '<span class="badge badge-info"><i class="fa fa-exclamation-triangle"></i>
                        Hold</span>';
                    } elseif ($payment->status == 4) {
                        $status = '<span class="badge badge-primary"><i class="fa fa-angle-double-up"></i>
                        Forwarded</span>';
                    }

                    return $status;
                })
                ->editColumn('created_at', function (Payment $payment) {
                    return $payment->created_at->format('h:i:s A, d M, Y');
                })
                ->addColumn('action', function ($row) {
                    if ($row->status == 0) {
                        $btn = '<a href="javascript:void(0)" onclick="paid(' . $row->id . ')"  class="edit btn btn-primary btn-sm"><i class="fa fa-check"></i> mark as paid</a>';
                    } else {
                        $btn = '';
                    }

                    $action = $btn . ' <a href="javascript:void(0)" onclick="adjust(' . $row->id . ')" class="btn btn-success btn-sm"><i class="fa fa-adjust"></i> Adjust</a>';

                    return $action;
                })
                ->rawColumns(['student', 'payable_amount', 'method', 'status', 'action'])
                ->make(true);
        }
        return view('admin.payment.index');
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
        //
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
        //
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
        $payment = Payment::findOrFail($id);
        $payment->status = 1;
        $payment->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Payment invoice generate using artisan command
     * We can use this method for generate invoice for payment from bash
     * Created by: Ruhul Ameen
     * Contact at: contact@ruhulameen.com / Skype: ruhulameen.bd
     * Created at: 2021-11-13 4:30PM
     */
    public function generatePayment(Request $request)
    {
        if ($request->invoice == 'weekly') {
            Artisan::call('invoice --weekly');
        } elseif ($request->invoice == 'monthly') {
            Artisan::call('invoice --monthly');
        }

        //Toastr::success('$msg', 'Success');
        return redirect()->back()->with('success', Artisan::output());
    }

    public function paid(Request $request)
    {
        $payment = Payment::findOrFail($request->id);
        $payment->status = 1;
        $payment->save();
    }
    public function adjust(Request $request)
    {
        //return $request->all();
        $payment = Payment::findOrFail($request->id);
        $payment->payable_amount = $payment->payable_amount - $request->amount;
        $payment->note = $request->reason;
        $payment->update();
    }
}
