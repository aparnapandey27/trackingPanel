<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OfferRequest;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Yajra\DataTables\Facades\DataTables;

class OfferRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = OfferRequest::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('status', function (OfferRequest $offerRequest) {
                    if ($offerRequest->status == 1) {
                        $btn = '<span class="badge badge bg-success-subtle text-success text-uppercase">Approved</span>';
                    } elseif ($offerRequest->status == 2) {
                        $btn = '<span class="badge bg-danger-subtle text-danger text-uppercase">Rejected</span>';
                    } elseif ($offerRequest->status == 3) {
                        $btn = '<span class="badge bg-danger-subtle text-danger text-uppercase">Blocked</span>';
                    } else {
                        $btn = '<span class="badge bg-warning-subtle text-warning text-uppercase">Pending</span>';
                    }
                    return $btn;
                })
                ->addColumn('user', function (OfferRequest $offerRequest) {
                    return '<a style="text-decoration:none" href="' . route('admin.students.manage', $offerRequest->user->id) . '">' . $offerRequest->user->name . '</a>';
                })
                ->addColumn('offer', function (OfferRequest $offerRequest) {
                    return '<a style="text-decoration:none" href="' . route('admin.offers.show', $offerRequest->offer->id) . '">' . $offerRequest->offer->name . '</a>';
                })
                ->editColumn('created_at', function (OfferRequest $offerRequest) {
                    return $offerRequest->created_at->format('d-M-Y' . '  -  ' . 'h:i A');
                })
                ->addColumn('action', function (OfferRequest $offerRequest) {

                    $btn = '<a href="javascript:void(0)" onclick="updateStatus(' . $offerRequest->id . ', 1)" class="btn btn-info btn-sm"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"><path fill="currentColor" fill-rule="evenodd" d="M3 13.5a.5.5 0 0 1-.5-.5V3a.5.5 0 0 1 .5-.5h9.25a.75.75 0 0 0 0-1.5H3a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V9.75a.75.75 0 0 0-1.5 0V13a.5.5 0 0 1-.5.5H3Zm12.78-8.82a.75.75 0 0 0-1.06-1.06L9.162 9.177L7.289 7.241a.75.75 0 1 0-1.078 1.043l2.403 2.484a.75.75 0 0 0 1.07.01L15.78 4.68Z" clip-rule="evenodd"/></svg></a>
                            <a href="javascript:void(0)" onclick="updateStatus(' . $offerRequest->id . ', 2)" class="btn btn-primary btn-sm"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"><path fill="currentColor" fill-rule="evenodd" d="M6.793 6.793a1 1 0 0 1 1.414 0L12 10.586l3.793-3.793a1 1 0 1 1 1.414 1.414L13.414 12l3.793 3.793a1 1 0 0 1-1.414 1.414L12 13.414l-3.793 3.793a1 1 0 0 1-1.414-1.414L10.586 12L6.793 8.207a1 1 0 0 1 0-1.414Z" clip-rule="evenodd"/></svg></a>
                            <a href="javascript:void(0)" onclick="updateStatus(' . $offerRequest->id . ', 3)" class="btn btn-warning btn-sm"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"><path fill="currentColor" d="M12 2c5.5 0 10 4.5 10 10s-4.5 10-10 10S2 17.5 2 12S6.5 2 12 2m0 2c-1.9 0-3.6.6-4.9 1.7l11.2 11.2c1-1.4 1.7-3.1 1.7-4.9c0-4.4-3.6-8-8-8m4.9 14.3L5.7 7.1C4.6 8.4 4 10.1 4 12c0 4.4 3.6 8 8 8c1.9 0 3.6-.6 4.9-1.7Z"/></svg></a>
                            <a href="javascript:void(0)" onclick="deleteOfferRequest(' . $offerRequest->id . ')" class="btn btn-danger btn-sm"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"><path fill="currentColor" d="M7 21q-.825 0-1.413-.588T5 19V6H4V4h5V3h6v1h5v2h-1v13q0 .825-.588 1.413T17 21H7ZM17 6H7v13h10V6ZM9 17h2V8H9v9Zm4 0h2V8h-2v9ZM7 6v13V6Z"/></svg></a>';
                    return $btn;
                })
                ->addColumn('checkbox', '<input type="checkbox" name="offer_checkbox[]" class="checkbox c-checkbox offer_checkbox" value="{{$id}}" />')
                ->rawColumns(['user', 'offer', 'status', 'checkbox', 'action',])
                ->make(true);
        }
        return view('admin.offerRequest.index');
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
        // return $request->all();
        $offerRequest = new OfferRequest();
        $offerRequest->offer_id = $request->offer_id;
        $offerRequest->user_id = $request->student_id;
        $offerRequest->status = $request->status == null ? 0 : $request->status;
        $offerRequest->save();

        return response()->json('created');
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
        return OfferRequest::find($id);
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
        $offerRequest = OfferRequest::find($id);
        $offerRequest->status = $request->status;
        $offerRequest->update();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        OfferRequest::destroy($id);
        return;
    }
}
