<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Offer;
use App\Models\Postback;
use App\Models\PostbackLog;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
            $user_id = Auth::id();
            $data = Postback::where('student_id', $user_id)->latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('offer', function (Postback $pb) {
                    if ($pb->global == 0) {
                        $offer = Offer::find($pb->offer_id);
                        //$offer_name = $offer->title;
                        $offer_name = '<a title="' . $offer->name . '" style="text-decoration:none" href="' . route('student.offer.show', $offer->id) . '">' . $offer->name . '</a>';
                        return $offer_name;
                    } else {
                        $offer_name = 'Global Postback';
                        return $offer_name;
                    }
                })
                ->editColumn('status', function (Postback $pb) {
                    if ($pb->status == 1) {
                        $btn = '<span class="badge bg-success-subtle text-success text-uppercase">Active</span>';
                    } elseif ($pb->status == 2) {
                        $btn = '<span class="badge bg-danger-subtle text-danger text-uppercase">Rejected</span>';
                    } elseif ($pb->status == 3) {
                        $btn = '<span class="badge bg-warning-subtle text-warning text-uppercase">Terminated</span>';
                    } else {
                        $btn = '<span class="badge bg-warning-subtle text-warning text-uppercase">Pending</span>';
                    }

                    return $btn;
                })
                ->editColumn('code', function (Postback $pb) {
                    $code = '<input type="text" class="form-control" value="' . $pb->postback . '">';
                    return $code;
                })
                ->addColumn('action', function (Postback $pb) {

                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip" onclick="deletePostback(' . $pb->id . ')" data-id="' . $pb->id . '" data-original-title="Delete" class="btn btn-danger btn-sm DeletePost"><i class="ri-delete-bin-5-fill fs-16"></i></a>';
                    $btn .= ' <a href="' . route('student.postback.logs', $pb->id) . '" data-toggle="tooltip" data-original-title="Logs" class="btn btn-info btn-sm"><i class=" ri-history-line fs-16"></i></a>';
                    return $btn;
                })
                ->rawColumns(['offer', 'status', 'code', 'action'])
                ->make(true);
        }

        return view('student.postback.index');
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
        $postback->student_id = auth()->user()->id;
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
        //
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
        return view('student.postback.log', compact('id'));
    }
}
