<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Offer;
use App\Models\OfferGoal;
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
        // Fetch the latest postbacks
        $data = Postback::latest()->get();

        return DataTables::of($data)
            ->addIndexColumn()

            // Student Column with Null Check
            ->addColumn('student', function (Postback $pb) {
                if ($pb->student) {
                    return '<a title="' . e($pb->student->name) . '" style="text-decoration:none" href="' . route('admin.students.manage', $pb->student->id) . '">' . e($pb->student->name) . '</a>';
                } else {
                    return 'N/A'; // Default value if no student is associated
                }
            })

            // Offer Column with Global Postback Check
            ->addColumn('offer', function (Postback $pb) {
                if ($pb->global == 0 && $pb->offer) {
                    return '<a title="' . e($pb->offer->name) . '" style="text-decoration:none" href="' . route('admin.offers.show', $pb->offer->id) . '">' . e($pb->offer->name) . '</a>';
                } else {
                    return 'Global Postback'; // Handle global postback or no associated offer
                }
            })

            // Status Column with Badges
            ->editColumn('status', function (Postback $pb) {
                switch ($pb->status) {
                    case 1:
                        return '<span class="badge bg-success">Active</span>';
                    case 2:
                        return '<span class="badge bg-danger">Rejected</span>';
                    case 3:
                        return '<span class="badge bg-danger">Terminated</span>';
                    default:
                        return '<span class="badge bg-warning">Pending</span>';
                }
            })

            // Code Column as Input Field
            ->editColumn('code', function (Postback $pb) {
                return '<input type="text" class="form-control" value="' . e($pb->postback) . '">';
            })

            // Action Buttons (using Blade components for better structure)
            ->addColumn('action', function (Postback $pb) {
                // Define action buttons for different statuses
                $statusButton = $pb->status == 1
                    ? '<a href="javascript:void(0)" onclick="updatePostback(' . $pb->id . ')" class="btn btn-success btn-sm" title="Update Postback">' . $this->getSvgIcon('check') . '</a>'
                    : '<a href="javascript:void(0)" onclick="updatePostback(' . $pb->id . ')" class="btn btn-primary btn-sm" title="Update Postback">' . $this->getSvgIcon('edit') . '</a>';

                $deleteButton = '<a href="javascript:void(0)" onclick="deletePostback(' . $pb->id . ')" class="btn btn-danger btn-sm" title="Delete Postback">' . $this->getSvgIcon('trash') . '</a>';
                
                $logsButton = '<a href="' . route('admin.postback.logs', $pb->id) . '" class="btn btn-info btn-sm" title="View Logs">' . $this->getSvgIcon('logs') . '</a>';

                // Return the combined buttons
                return $statusButton . ' ' . $deleteButton . ' ' . $logsButton;
            })

            // Declare columns that contain raw HTML
            ->rawColumns(['student', 'offer', 'status', 'code', 'action'])
            ->make(true);
    }

    // Load the default view for postbacks
    return view('admin.postback.index');
}

/**
 * Helper method to return SVG icons for action buttons.
 * This allows you to keep icons organized and reusable.
 */
private function getSvgIcon($type)
{
    switch ($type) {
        case 'check':
            return '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><path fill="currentColor" fill-rule="evenodd" d="M6.793 6.793a1 1 0 0 1 1.414 0L12 10.586l3.793-3.793a1 1 0 1 1 1.414 1.414L13.414 12l3.793 3.793a1 1 0 0 1-1.414 1.414L12 13.414l-3.793 3.793a1 1 0 0 1-1.414-1.414L10.586 12L6.793 8.207a1 1 0 0 1 0-1.414Z" clip-rule="evenodd"/></svg>';
        case 'edit':
            return '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 16 16"><path fill="currentColor" fill-rule="evenodd" d="M3 13.5a.5.5 0 0 1-.5-.5V3a.5.5 0 0 1 .5-.5h9.25a.75.75 0 0 0 0-1.5H3a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V9.75a.75.75 0 0 0-1.5 0V13a.5.5 0 0 1-.5.5H3Zm12.78-8.82a.75.75 0 0 0-1.06-1.06L9.162 9.177L7.289 7.241a.75.75 0 1 0-1.078 1.043l2.403 2.484a.75.75 0 0 0 1.07.01L15.78 4.68Z" clip-rule="evenodd"/></svg>';
        case 'trash':
            return '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><path fill="currentColor" d="M7 21q-.825 0-1.413-.588T5 19V6H4V4h5V3h6v1h5v2h-1v13q0 .825-.588 1.413T17 21H7ZM17 6H7v13h10V6ZM9 17h2V8H9v9Zm4 0h2V8h-2v9ZM7 6v13V6Z"/></svg>';
        case 'logs':
            return '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><path fill="currentColor" d="M12 21q-3.45 0-6.013-2.288T3.05 13H5.1q.35 2.6 2.313 4.3T12 19q2.925 0 4.963-2.038T19 12q0-2.925-2.038-4.963T12 5q-1.725 0-3.225.8T6.25 8H9v2H3V4h2v2.35q1.275-1.6 3.113-2.475T12 3q1.875 0 3.513.713t2.85 1.924q1.212 1.213 1.925 2.85T21 12q0 1.875-.713 3.513t-1.924 2.85q-1.213 1.212-2.85 1.925T12 21Zm2.8-4.8L11 12.4V7h2v4.6l3.2 3.2l-1.4 1.4Z"/></svg>';
    }
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
                        $offer_name = '<a title="' . $offer->name . '" style="text-decoration:none" href="' . route('admin.offers.show', $offer->id) . '">' . $offer->name . '</a>';
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
        public function getGoalsForOffer($offerId)
{
    // Fetch goals based on the offer ID
    $goals = OfferGoal::where('offer_id', $offerId)->with('goalName')->get();

    // Extract the goal names from the relationships
    $goalNames = $goals->map(function ($goal) {
        return [
            'id' => $goal->goal_id,
            'name' => $goal->goalName->name // Access the goal_name through the relationship
        ];
    });

    return response()->json(['goals' => $goalNames]);
}
}
