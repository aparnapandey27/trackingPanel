<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Mail\Student\AccountApproved;
use App\Mail\Student\AccountClosed;
use App\Mail\Student\AccountReject;
use App\Models\Click;
use App\Models\Payment;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\Facades\DataTables;


class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::student()->where('manager_id', Auth::id())->latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('name', function (User $user) {
                    $name = '<a title="' . $user->name . '" style="text-decoration:none" href="' . route('employee.student.show', $user->id) . '">' . $user->name . '</a>';

                    return $name;
                })
                ->editColumn('status', function (User $user) {
                    if ($user->status == 1) {
                        $btn = '<span class="badge bg-success-subtle text-success text-uppercase">Active</span>';
                    } elseif ($user->status == 2) {
                        $btn = '<span class="badge bg-danger-subtle text-danger text-uppercase">Rejected</span>';
                    } elseif ($user->status == 3) {
                        $btn = '<span class="badge bg-danger-subtle text-danger text-uppercase">Closed</span>';
                    } else {
                        $btn = '<span class="badge bg-warning-subtle text-warning text-uppercase">Pending</span>';
                    }

                    return $btn;
                })
                ->editColumn('created_at', function (User $user) {
                    return $user->created_at->format('d-M-Y' . '  -  ' . 'h:i A');
                })



                ->addColumn('action', function (User $user) {

                    $btn = '<a href="javascript:void(0)" onclick="updateStatus(' . $user->id . ', 1)" class="btn btn-info btn-sm mb-2" title="approved this account"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"><path fill="currentColor" fill-rule="evenodd" d="M3 13.5a.5.5 0 0 1-.5-.5V3a.5.5 0 0 1 .5-.5h9.25a.75.75 0 0 0 0-1.5H3a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V9.75a.75.75 0 0 0-1.5 0V13a.5.5 0 0 1-.5.5H3Zm12.78-8.82a.75.75 0 0 0-1.06-1.06L9.162 9.177L7.289 7.241a.75.75 0 1 0-1.078 1.043l2.403 2.484a.75.75 0 0 0 1.07.01L15.78 4.68Z" clip-rule="evenodd"/></svg></a>
                    <a href="javascript:void(0)" onclick="updateStatus(' . $user->id . ', 2)" class="btn btn-primary btn-sm mb-2" title="reject this account"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"><path fill="currentColor" fill-rule="evenodd" d="M6.793 6.793a1 1 0 0 1 1.414 0L12 10.586l3.793-3.793a1 1 0 1 1 1.414 1.414L13.414 12l3.793 3.793a1 1 0 0 1-1.414 1.414L12 13.414l-3.793 3.793a1 1 0 0 1-1.414-1.414L10.586 12L6.793 8.207a1 1 0 0 1 0-1.414Z" clip-rule="evenodd"/></svg></a>
                    <a href="javascript:void(0)" onclick="updateStatus(' . $user->id . ', 3)" class="btn btn-warning btn-sm mb-2" title="close this account"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"><path fill="currentColor" d="M12 2c5.5 0 10 4.5 10 10s-4.5 10-10 10S2 17.5 2 12S6.5 2 12 2m0 2c-1.9 0-3.6.6-4.9 1.7l11.2 11.2c1-1.4 1.7-3.1 1.7-4.9c0-4.4-3.6-8-8-8m4.9 14.3L5.7 7.1C4.6 8.4 4 10.1 4 12c0 4.4 3.6 8 8 8c1.9 0 3.6-.6 4.9-1.7Z"/></svg></a>';
                    return $btn;
                })
                ->addColumn('checkbox', '<input type="checkbox" name="offer_checkbox[]" class="checkbox c-checkbox offer_checkbox" value="{{$id}}" />')
                ->rawColumns(['checkbox', 'action', 'status', 'manager', 'name'])
                ->make(true);
        }
        return view('employee.student.index');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('employee.student.create');
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
            'name' => 'string|required|max:120',
            'email' => 'required|email|max:150|unique:users',
            'phone' => 'required|max:20|unique:users',
            
        ]);

        $user = new User();
        $user->college = $request->college;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->password = Hash::make(12345678);
        $user->address = $request->address;
        $user->zipcode = $request->zipcode;
        $user->status = $request->status;
        $user->country = $request->country;
        $user->manager_id = Auth::user()->id;
        $user->save();

        return redirect()->route('employee.student.index')->with('success', 'Student Created Successfully');
        Toastr::success('Student Added Successful', 'Success');
    }
    
        /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user =  User::find($id);

        return view('employee.student.edit', compact('user'));
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
        $request->validate([
            'name' => 'string|required|max:120',
            'email' => 'required|email|max:150|',
        ]);

        $user = User::find($id);
        $user->college = $request->college;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        // $user->password = Hash::make(12345678);
        $user->address  = $request->address;
        $user->zipcode = $request->zipcode;
        $user->status = $request->status;
        $user->country = $request->country;
        $user->update();

        Toastr::success('Student Updated Successful', 'Success');
        return redirect()->route('employee.student.show', $id);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id) 
{
    $student = User::find($id);

    // Check if the student exists
    if (!$student) {
        return redirect()->back()->with('error', 'Student not found.');
    }

    if ($request->post()) {
        $daterange = explode('-', $request->get('daterange'));
        $from = date('Y-m-d', strtotime(trim($daterange[0])));
        $to = date('Y-m-d', strtotime(trim($daterange[1])));
    } else {
        $from = \Carbon\Carbon::today()->subDays(6)->format('Y-m-d');
        $to = \Carbon\Carbon::today()->format('Y-m-d');
    }

    $reports = Click::select(DB::raw('clicks.offer_id as Oid, clicks.offer_name as Offer, COUNT(clicks.id) as Clicks, SUM(IF(conversions.status IN ("approved", "pending"), 1, 0)) as Leads, SUM(IF(conversions.status = "approved", conversions.payout, 0)) as Payout, SUM(IF(conversions.status = "approved", conversions.revenue, 0)) as Revenue, SUM(IF(conversions.status = "approved", conversions.revenue, 0)) - SUM(IF(conversions.status = "approved", conversions.payout, 0)) as Profit'))
        ->leftJoin('conversions', 'clicks.transaction_id', '=', 'conversions.click_transaction_id')
        ->where('clicks.student_id', $student->id)
        ->whereBetween('clicks.created_at', [$from, $to])
        ->groupBy('clicks.offer_id', 'clicks.offer_name')
        ->paginate(10);

    $payments = Payment::where('student_id', $student->id)->orderBy('id', 'desc')->get();

    return view('employee.student.show', compact('student', 'reports', 'to', 'from', 'payments'));
}


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
 

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::destroy($id);
        Toastr::success('Student has been delete', 'Success');
    }

    public function status(Request $request, $id)
    {
        $student = User::find($id);
        $student->status = $request->status;
        $student->update();
        // if ($request->status == 1) {
        //     Mail::to($student)->send(new AccountApproved($student));
        // } elseif ($request->status == 2) {
        //     Mail::to($student)->send(new AccountReject($student));
        // } elseif ($request->status == 3) {
        //     Mail::to($student)->send(new AccountClosed($student));
        // }

        return redirect()->back();
    }
}
