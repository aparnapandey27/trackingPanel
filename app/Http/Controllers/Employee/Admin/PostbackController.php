<?php

namespace App\Http\Controllers\Employee\Admin;

use App\Http\Controllers\Controller;
use App\Models\Offer;
use App\Models\Postback;
use App\Models\PostbackLog;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PostbackController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Postback::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('student', function (Postback $pb) {
                    //$offer_name = $offer->title;
                    $student = '<a title="' . $pb->student->name . '" style="text-decoration:none" href="' . route('admin.students.manage', $pb->student->id) . '">' . $pb->student->name . '</a>';
                    return $student;
                })
                ->addColumn('offer', function (Postback $pb) {
                    if ($pb->global == 0) {
                        $offer = Offer::find($pb->offer_id);
                        //$offer_name = $offer->title;
                        $offer_name = '<a title="' . $offer->name . '" style="text-decoration:none" href="' . route('admin.offers.show', $offer->id) . '">' . $offer->name . '</a>';
                        return $offer_name;
                    } else {
                        $offer_name = 'Global Postback';
                        return $offer_name;
                    }
                })
                ->editColumn('status', function (Postback $pb) {
                    if ($pb->status == 1) {
                        $btn = '<span class="badge bg-success">Active</span>';
                    } elseif ($pb->status == 2) {
                        $btn = '<span class="badge bg-danger">Rejected</span>';
                    } elseif ($pb->status == 3) {
                        $btn = '<span class="badge bg-danger">Terminated</span>';
                    } else {
                        $btn = '<span class="badge bg-warning">Pending</span>';
                    }

                    return $btn;
                })
                ->editColumn('code', function (Postback $pb) {
                    $code = '<input type="text" class="form-control" value="' . $pb->postback . '">';
                    return $code;
                })
                ->addColumn('action', function (Postback $pb) {
                    if ($pb->status == 1) {
                        $status = '<a href="javascript:void(0)" data-toggle="tooltip" onclick="updatePostback(' . $pb->id . ')" class="btn btn-success btn-sm"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><path fill="currentColor" fill-rule="evenodd" d="M6.793 6.793a1 1 0 0 1 1.414 0L12 10.586l3.793-3.793a1 1 0 1 1 1.414 1.414L13.414 12l3.793 3.793a1 1 0 0 1-1.414 1.414L12 13.414l-3.793 3.793a1 1 0 0 1-1.414-1.414L10.586 12L6.793 8.207a1 1 0 0 1 0-1.414Z" clip-rule="evenodd"/></svg></a>';
                    } elseif ($pb->status == 0) {
                        $status = '<a href="javascript:void(0)" data-toggle="tooltip" onclick="updatePostback(' . $pb->id . ')" class="btn btn-primary btn-sm"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 16 16"><path fill="currentColor" fill-rule="evenodd" d="M3 13.5a.5.5 0 0 1-.5-.5V3a.5.5 0 0 1 .5-.5h9.25a.75.75 0 0 0 0-1.5H3a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V9.75a.75.75 0 0 0-1.5 0V13a.5.5 0 0 1-.5.5H3Zm12.78-8.82a.75.75 0 0 0-1.06-1.06L9.162 9.177L7.289 7.241a.75.75 0 1 0-1.078 1.043l2.403 2.484a.75.75 0 0 0 1.07.01L15.78 4.68Z" clip-rule="evenodd"/></svg></a>';
                    }
                    $btn = ' <a href="javascript:void(0)" data-toggle="tooltip" onclick="deletePostback(' . $pb->id . ')" class="btn btn-danger btn-sm"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><path fill="currentColor" d="M7 21q-.825 0-1.413-.588T5 19V6H4V4h5V3h6v1h5v2h-1v13q0 .825-.588 1.413T17 21H7ZM17 6H7v13h10V6ZM9 17h2V8H9v9Zm4 0h2V8h-2v9ZM7 6v13V6Z"/></svg></a>';
                    $btn .= ' <a href="' . route('admin.postback.logs', $pb->id) . '" data-toggle="tooltip" data-original-title="Logs" class="btn btn-info btn-sm"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><path fill="currentColor" d="M12 21q-3.45 0-6.013-2.288T3.05 13H5.1q.35 2.6 2.313 4.3T12 19q2.925 0 4.963-2.038T19 12q0-2.925-2.038-4.963T12 5q-1.725 0-3.225.8T6.25 8H9v2H3V4h2v2.35q1.275-1.6 3.113-2.475T12 3q1.875 0 3.513.713t2.85 1.924q1.212 1.213 1.925 2.85T21 12q0 1.875-.713 3.513t-1.924 2.85q-1.213 1.212-2.85 1.925T12 21Zm2.8-4.8L11 12.4V7h2v4.6l3.2 3.2l-1.4 1.4Z"/></svg></a>';
                    return $status . $btn;
                })
                ->rawColumns(['student', 'offer', 'status', 'code', 'action'])
                ->make(true);
        }

        return view('admin.postback.index');
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
            // 'offer_id' => 'required',
            'event' => 'nullable|string',
            'code' => 'required|string',
        ]);
        $postback = new Postback();
        $postback->student_id = $request->student_id;
        $postback->global = $request->is_global ?? false;
        $postback->event = $request->event == null ? 'default' : $request->event;
        $postback->offer_id = $request->offer_id == null ? null : $request->offer_id;
        $postback->postback = $request->code;
        $postback->save();

        Toastr::success('Postback has been Added', 'Success');
        return redirect()->back();
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
        $postback = Postback::find($id);
        $postback->status = $postback->status == 0 ? 1 : 0;
        $postback->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Postback::destroy($id);
    }

    public function logs($id, Request $request)
    {

        if ($request->ajax()) {
            $data = PostbackLog::where('postback_id', $id)->latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('offer', function (PostbackLog $pb) {
                    if ($pb->global == 0) {
                        $offer = Offer::find($pb->offer_id);
                        //$offer_name = $offer->title;
                        $offer_name = '<a title="' . $offer->name . '" style="text-decoration:none" href="' . route('admin.offer.show', $offer->id) . '">' . $offer->name . '</a>';
                        return $offer_name;
                    } else {
                        $offer_name = 'Global Postback';
                        return $offer_name;
                    }
                })
                ->editColumn('code', function (PostbackLog $pb) {
                    $code = '<input type="text" class="form-control" value="' . $pb->postback . '">';
                    return $code;
                })
                ->editColumn('body', function (PostbackLog $pb) {
                    $code = '<textarea rows="3" class="form-control">' . $pb->body . '</textarea>';
                    return $code;
                })
                ->rawColumns(['offer', 'code', 'body'])
                ->make(true);
        }
        //$logs = PostbackLog::where('postback_id', $id)->get();
        return view('admin.postback.log', compact('id'));
    }
}
