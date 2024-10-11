<?php

namespace App\Http\Controllers\Employee\Admin;

use App\Http\Controllers\Controller;
use App\Mail\Student\AccountApproved;
use App\Mail\Student\AccountClosed;
use App\Mail\Student\AccountReject;
use App\Models\Click;
use App\Models\Payment;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\Facades\DataTables;
use App\Imports\StudentImport; 
use Maatwebsite\Excel\Facades\Excel;

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
            $data = User::student()->latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('name', function (User $user) {
                    $name = '<a title="' . $user->name . '" style="text-decoration:none" href="' . route('admin.students.manage', $user->id) . '">' . $user->name . '</a>';

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
                ->editColumn('manager', function (User $user) {
                    if ($user->manager) {
                        return '<a href="' . route('admin.employee.show', $user->id) . '">' . $user->manager->name . '</a><br><a href="javascript:void(0)" onclick="editManager(' . $user->id . ')"><small>Change Manager</small></a>';
                    }
                    return '<span class="badge bg-danger">No Manager</span><br><a href="javascript:void(0)" onclick="editManager(' . $user->id . ')"><small>Assign Manager</small></a>';
                })
                ->editColumn('created_at', function (User $user) {
                    return $user->created_at->format('d-M-Y' . '  -  ' . 'h:i A');
                })



                ->addColumn('action', function (User $user) {

                    $btn = '<a href="javascript:void(0)" onclick="updateStatus(' . $user->id . ', 1)" class="btn btn-info btn-sm mb-2" title="approved this account"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"><path fill="currentColor" fill-rule="evenodd" d="M3 13.5a.5.5 0 0 1-.5-.5V3a.5.5 0 0 1 .5-.5h9.25a.75.75 0 0 0 0-1.5H3a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V9.75a.75.75 0 0 0-1.5 0V13a.5.5 0 0 1-.5.5H3Zm12.78-8.82a.75.75 0 0 0-1.06-1.06L9.162 9.177L7.289 7.241a.75.75 0 1 0-1.078 1.043l2.403 2.484a.75.75 0 0 0 1.07.01L15.78 4.68Z" clip-rule="evenodd"/></svg></a>
                            <a href="javascript:void(0)" onclick="updateStatus(' . $user->id . ', 2)" class="btn btn-primary btn-sm mb-2" title="reject this account"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"><path fill="currentColor" fill-rule="evenodd" d="M6.793 6.793a1 1 0 0 1 1.414 0L12 10.586l3.793-3.793a1 1 0 1 1 1.414 1.414L13.414 12l3.793 3.793a1 1 0 0 1-1.414 1.414L12 13.414l-3.793 3.793a1 1 0 0 1-1.414-1.414L10.586 12L6.793 8.207a1 1 0 0 1 0-1.414Z" clip-rule="evenodd"/></svg></a>
                            <a href="javascript:void(0)" onclick="updateStatus(' . $user->id . ', 3)" class="btn btn-warning btn-sm mb-2" title="close this account"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"><path fill="currentColor" d="M12 2c5.5 0 10 4.5 10 10s-4.5 10-10 10S2 17.5 2 12S6.5 2 12 2m0 2c-1.9 0-3.6.6-4.9 1.7l11.2 11.2c1-1.4 1.7-3.1 1.7-4.9c0-4.4-3.6-8-8-8m4.9 14.3L5.7 7.1C4.6 8.4 4 10.1 4 12c0 4.4 3.6 8 8 8c1.9 0 3.6-.6 4.9-1.7Z"/></svg></a>
                            <a href="' . route('admin.student.edit', $user->id) . '" title="Edit" class="btn btn-info btn-sm mb-2"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><path d="m16.474 5.408l2.118 2.117m-.756-3.982L12.109 9.27a2.118 2.118 0 0 0-.58 1.082L11 13l2.648-.53c.41-.082.786-.283 1.082-.579l5.727-5.727a1.853 1.853 0 1 0-2.621-2.621Z"/><path d="M19 15v3a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2h3"/></g></svg></a>
                            <a href="javascript:void(0)" onclick="deleteStudent(' . $user->id . ')" class="btn btn-danger  btn-sm mb-2"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"><path fill="currentColor" d="M7 21q-.825 0-1.413-.588T5 19V6H4V4h5V3h6v1h5v2h-1v13q0 .825-.588 1.413T17 21H7ZM17 6H7v13h10V6ZM9 17h2V8H9v9Zm4 0h2V8h-2v9ZM7 6v13V6Z"/></svg></a>
                            <a href="' . route('admin.loginAs', $user->id) . '" class="btn btn-info btn-sm mb-2" title="Sign in to this account"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"><path fill="currentColor" d="M12 21v-2h7V5h-7V3h7q.825 0 1.413.588T21 5v14q0 .825-.588 1.413T19 21h-7Zm-2-4l-1.375-1.45l2.55-2.55H3v-2h8.175l-2.55-2.55L10 7l5 5l-5 5Z"/></svg></a>';
                    return $btn;
                })
                ->addColumn('checkbox', '<input type="checkbox" name="offer_checkbox[]" class="checkbox c-checkbox offer_checkbox" value="{{$id}}" />')
                ->rawColumns(['checkbox', 'action', 'status', 'manager', 'name'])
                ->make(true);
        }
        return view('admin.students.manage');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.student.create');
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
        $user->company = $request->company;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->password = Hash::make(12345678);
        $user->address = $request->address;
        $user->zipcode = $request->zipcode;
        $user->status = $request->status;
        $user->country = $request->country;
        $user->save();

        return redirect()->route('admin.students.manage')->with('success', 'Student Created Successfully');
        Toastr::success('Student Added Successful', 'Success');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {

        $student = User::find($id);

        if ($request->post()) {
            $daterange = explode('-', $request->get('daterange'));
            $from = date('Y-m-d', strtotime(trim($daterange[0]))); //"2021-10-28"
            $to = date('Y-m-d', strtotime(trim($daterange[1]))); //"2021-11-03"
        } else {
            $from = \Carbon\Carbon::today()->subDays(6)->format('Y-m-d');;
            $to = \Carbon\Carbon::today()->format('Y-m-d');
        }

        $reports = Click::select(DB::raw('clicks.offer_id as Oid, clicks.offer_name as Offer, COUNT(clicks.id) as Clicks , SUM(IF(conversions.status = ("approved" or "pending"), 1, 0)) as Leads, SUM(IF(conversions.status = "approved", conversions.payout, 0)) as Payout, SUM(IF(conversions.status = "approved", conversions.revenue, 0)) as Revenue, SUM(IF(conversions.status = \'approved\', conversions.revenue, 0)) - SUM(IF(conversions.status = "approved", conversions.payout, 0)) as Profit'))
            ->LEFTJOIN('conversions', 'clicks.transaction_id', '=', 'conversions.click_transaction_id')
            ->groupBy(DB::raw("clicks.offer_id"))
            ->where('clicks.student_id', $student->id)
            ->whereBetween('clicks.created_at', [$from, $to])
            ->paginate(10);

        $payments = Payment::where('student_id', $student->id)->orderBy('id', 'desc')->get();

        return view('admin.students.manage', compact('student', 'reports', 'to', 'from', 'payments'));
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

        return view('admin.student.edit', compact('user'));
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
        $user->company = $request->company;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        // $user->password = Hash::make(12345678);
        $user->address = $request->address;
        $user->zipcode = $request->zipcode;
        $user->status = $request->status;
        $user->country = $request->country;
        $user->update();

        Toastr::success('Student Updated Successful', 'Success');
        return redirect()->route('admin.students.manage', $id);
    }

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

    public function manager(Request $request, $id)
    {
        $student = User::find($id);
        $student->manager_id = $request->manager;
        $student->update();
        return redirect()->back();
    }


    public function payment_frequency(Request $request, $id)
    {
        $student = User::find($id);
        $student->payment_frequency = $request->payment_frequency;
        $student->update();
        Toastr::success('Payment frequency Updated', 'Success');
        return redirect()->back();
    }
    
    public function import(Request $request)
    {
        $request->validate([
         'file' => 'required|mimes:xlsx, xls']);
        if(request()->hasFile('file')) {
            Excel::import(new StudentImport, request()->file('file')->store('temp'));
        }
    return redirect()->back()->with('success', 'Import completed.');;
    }
}
