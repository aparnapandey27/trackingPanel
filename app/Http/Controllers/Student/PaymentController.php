<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\PaymentProfile;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function index(Request $request)
{
    if ($request->ajax()) {
        $payments = Payment::select(['id', 'created_at', 'amount', 'currency', 'payment_method', 'status']);
        return datatables()->of($payments)
            ->addColumn('action', function ($row) {
                return '<a href="' . route('student.payment.download', $row->id) . '" class="btn btn-sm btn-primary">Download</a>';
            })
            ->make(true); // Ensure the data is returned in JSON format
    }
    
    $payments = Payment::paginate(10);
    return view('student.payment.index', compact('payments'));
}


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $check = PaymentProfile::where('student_id', auth()->user()->id)->first();

        if ($check) {
            $check->payment_method_id = $request->payment_method;
            $check->details = $request->detail;
            $check->update();
        } else {
            $payment = new PaymentProfile();
            $payment->student_id = auth()->user()->id;
            $payment->payment_method_id = $request->payment_method;
            $payment->details = $request->detail;
            $payment->save();
        }

        Toastr::success('Payment Method Updated Successfully', 'Success');
        return redirect()->back();
    }
}
