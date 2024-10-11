<?php

namespace App\Http\Controllers\Employee\Admin;

use App\Http\Controllers\Controller;
use App\Models\IP;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Laravel\Facades\Image;

use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class IPController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = IP::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()

                ->editColumn('ipaddress', function (IP $ipaddr) {
                    $ipaddress = '<a title="' . $ipaddr->ipaddress . '" style="text-decoration:none" href="' . route('admin.ip.show', $ipaddr->id) . '">' . $ipaddr->ipaddress . '</a>';

                    return $ipaddress;
                })

                ->editColumn('advertiser', function (IP $ipaddr) {
                    return $ipaddr->advertiser->name;
                })
                ->editColumn('status', function (IP $ipaddr) {
                    if ($ipaddr->status == 1) {
                        $btn = '<span class="badge bg-success-subtle text-success text-uppercase">Active</span>';
                    } elseif ($ipaddr->status == 2) {
                        $btn = '<span class="badge bg-danger-subtle text-danger text-uppercase">Rejected</span>';
                    } else {
                        $btn = '<span class="badge bg-warning-subtle text-warning text-uppercase">Pending</span>';
                    }                   

                    return $btn;
                })

                ->addColumn('action', function (IP $ipaddr) {

                    $btn = '<a href="javascript:void(0)" onclick="updateStatus(' . $ipaddr->id . ', 1)" class="btn btn-info btn-sm" title="approved this account"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"><path fill="currentColor" fill-rule="evenodd" d="M3 13.5a.5.5 0 0 1-.5-.5V3a.5.5 0 0 1 .5-.5h9.25a.75.75 0 0 0 0-1.5H3a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V9.75a.75.75 0 0 0-1.5 0V13a.5.5 0 0 1-.5.5H3Zm12.78-8.82a.75.75 0 0 0-1.06-1.06L9.162 9.177L7.289 7.241a.75.75 0 1 0-1.078 1.043l2.403 2.484a.75.75 0 0 0 1.07.01L15.78 4.68Z" clip-rule="evenodd"/></svg></a>
                    <a href="javascript:void(0)" onclick="updateStatus(' . $ipaddr->id . ', 2)" class="btn btn-primary btn-sm" title="reject this account"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"><path fill="currentColor" fill-rule="evenodd" d="M6.793 6.793a1 1 0 0 1 1.414 0L12 10.586l3.793-3.793a1 1 0 1 1 1.414 1.414L13.414 12l3.793 3.793a1 1 0 0 1-1.414 1.414L12 13.414l-3.793 3.793a1 1 0 0 1-1.414-1.414L10.586 12L6.793 8.207a1 1 0 0 1 0-1.414Z" clip-rule="evenodd"/></svg></a>
                    <a href="' . route('admin.ip.edit', $ipaddr->id) . '" title="Edit" class="btn btn-info btn-sm"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><path d="m16.474 5.408l2.118 2.117m-.756-3.982L12.109 9.27a2.118 2.118 0 0 0-.58 1.082L11 13l2.648-.53c.41-.082.786-.283 1.082-.579l5.727-5.727a1.853 1.853 0 1 0-2.621-2.621Z"/><path d="M19 15v3a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2h3"/></g></svg></a>
                    <a href="javascript:void(0)" data-toggle="tooltip" onclick="deleteIP(' . $ipaddr->id . ')" data-id="' . $ipaddr->id . '" data-original-title="Delete" class="btn btn-danger btn-sm"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"><path fill="currentColor" d="M7 21q-.825 0-1.413-.588T5 19V6H4V4h5V3h6v1h5v2h-1v13q0 .825-.588 1.413T17 21H7ZM17 6H7v13h10V6ZM9 17h2V8H9v9Zm4 0h2V8h-2v9ZM7 6v13V6Z"/></svg></a>';
                    return $btn;
                })

               ->rawColumns(['action','status','advertiser','ipaddress'])
                ->make(true);
        }
        return view('admin.ip.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $advertisers = User::where('role', 'advertiser')->where('status', 1)->get();
    
        return view('admin.ip.create', compact('advertisers'));
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
            'ipaddress' => 'required|ip',   
        ]);

        $ipaddr = new IP();
        $ipaddr->ipaddress = $request->ipaddress;
        $ipaddr->advertiser_id = $request->advertiser_id;
        $ipaddr->status = $request->status;
        $ipaddr->save();

        Toastr::success('IP Address Added Successful', 'Success');
        return redirect()->route('admin.ip.index')->with('success', 'IP Address created successfully');
       
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ipaddr = IP::findorFail($id);
        return view('admin.ip.show', compact('ipaddr'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $ipaddr = IP::findorFail($id);
        $advertisers = User::where('role', 'advertiser')->where('status', 1)->get();
    
        return view('admin.ip.edit', compact('ipaddr', 'advertisers'));
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
        $ipaddr = IP::find($id);
       
        $ipaddr->status = $request->status;
        $ipaddr->advertiser_id = $request->advertiser_id;
        $ipaddr->ipaddress = $request->ipaddress;
        $ipaddr->update();

        Toastr::success('IP Update Successful', 'Updated');

        return redirect()->route('admin.ip.index', $ipaddr->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        IP::destroy($id);
    }

    public function status(Request $request, $id)
    {
        $ipaddr = IP::find($id);
        $ipaddr->status = $request->status;
        $ipaddr->update();  
    }

}
