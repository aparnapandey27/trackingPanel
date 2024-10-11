<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Offer;
use App\Models\OfferStudent;
use App\Models\OfferRequest;
use App\Models\Postback;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class OfferController extends Controller
{
    public function index(Request $request)
    {


        if ($request->ajax()) {
            $user_id = Auth::id();
            $data = Offer::where('status', 1)
                ->whereIn('offer_permission', ['public', 'request'])
                ->where('name', 'like', '%' . $request->name . '%')
                ->when($request->filled('categories'), function ($query) use ($request) {
                    return $query->whereIn('category_id', $request->input('categories'));
                })
                ->when($request->filled('offer_type'), function ($query2) use ($request) {
                    return $query2->whereIn('offer_model', $request->input('offer_type'));
                })
                ->when($request->filled('countries'), function ($query3) use ($request) {
                    $query3->whereHas('countries', function ($qry) use ($request) {
                        $qry->whereIn('countries.id', $request->input('countries'));
                    });
                })
                ->when($request->filled('device'), function ($query4) use ($request) {
                    $query4->whereHas('devices', function ($qry) use ($request) {
                        $qry->whereIn('devices.name', $request->input('device'));
                    });
                })
                //If we add private offer then we should use these code to show to student if private offer approve.
                // ->orWhere(function($query) use ($user_id) {
                //     $query->where('offer_permission', 'private')
                //         ->whereHas('OfferAccess', function($qry) use ($user_id) {
                //             $qry->where('user_id', $user_id);
                //         });
                // })
                ->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('name', function (Offer $offer) {
                    $name = '<a title="' . $offer->name . '" style="text-decoration:none" href="' . route('student.offer.show', $offer->id) . '">' . $offer->name . '</a>';



                    return $name;
                })
                ->editColumn('thumbnail', function (Offer $offer) {
                    if ($offer->thumbnail != null) {
                        $url = url('/storage/offers/' . $offer->thumbnail);
                        return "<img src='{$url}'>";
                    } else {
                        return "<img src='data:image/jpeg;base64,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' style='width: 100px; height: 40px'>";
                    }
                })

                ->editColumn('status', function (Offer $offer) {

                    if ($offer->offer_permission == 'public') {
                        $status = '<span class="badge bg-success-subtle text-success text-uppercase">Approved</span>';
                    } elseif ($offer->offer_permission == 'private') {
                        $status = '<span class="badge bg-success-subtle text-success text-uppercase">Approved</span>';
                    } elseif ($offer->offer_permission == 'request') {
                        $checkstatus2 = OfferRequest::select('status')->where('offer_id', $offer->id)->where('user_id', Auth::id())->pluck('status')->toArray();

                        //$status = $checkstatus;
                        if (!empty($checkstatus2)  == 0) {
                            $status = '<span class="badge bg-dark" style="color:white">Available</span>';
                        } else {
                            foreach ($checkstatus2 as $checkstatus) {
                                if ($checkstatus == 0) {
                                    $status = '<span class="badge bg-warning-subtle text-warning text-uppercase">Pending</span>';
                                } elseif ($checkstatus == 1) {
                                    $status = '<span class="badge bg-success-subtle text-success text-uppercase">Approved</span>';
                                } elseif ($checkstatus == 2) {
                                    $status = '<span class="badge bg-danger-subtle text-danger text-uppercase">Rejected</span>';
                                } elseif ($checkstatus == 3) {
                                    $status = '<span class="badge bg-primary-subtle text-primary">Blocked</span>';
                                }
                            }
                        }
                    }
                    return  $status;
                })

                ->editColumn('payout', function (Offer $offer) {
                     $offerStudents= OfferStudent::whereOffer_id($offer->id)->whereStudent_id(Auth::id())->first();
                     //dd($offerStudents);
                    if($offerStudents) 
                    {
                        if ($offerStudents->pay_model == 'Hybrid') {
                            return $offerStudents->default_payout . ' ' . $offerStudents->currency . ' + ' . $offerStudents->percent_payout . '%';
                        } elseif ($offerStudents->pay_model == 'RevShare') {
                            return $offerStudents->percent_payout . '%';
                        } elseif ($offerStudents->pay_model == 'Dynamic') {
                            return 'Dynamic';
                        } else {
                            return $offerStudents->default_payout . ' ' . $offerStudents->currency;
                        }
                    }
                    else
                    {
                        if ($offer->offer_model == 'Hybrid') {
                            return $offer->default_payout . ' ' . $offer->currency . ' + ' . $offer->percent_payout . '%';
                        } elseif ($offer->offer_model == 'RevShare') {
                            return $offer->percent_payout . '%';
                        } elseif ($offer->offer_model == 'Dynamic') {
                            return 'Dynamic';
                        } else {
                            return $offer->default_payout . ' ' . $offer->currency;
                        }
                    }
                })
                ->editColumn('countries', function (Offer $offer) {
                    $tr = '';
                    $num_tags = count($offer->countries);
                    if ($num_tags < 1) {
                        $tr = '<i class="flag-icon flag-icon-ww" data-toggle="tooltip" data-placement="top" title="World Wide"></i> WW';
                    }

                    if ($num_tags > 5) {
                        foreach ($offer->countries as $country) {
                            $tr .= $country->name . ', ';
                        }
                        $tr = '<span data-toggle="tooltip" data-placement="top" title="' . $tr . '">' . $num_tags . ' Countries</span>';
                    } else {

                        foreach ($offer->countries as $country) {
                            $flag = Str::lower($country->code);
                            $tr .= '<i class="flag-icon flag-icon-' . $flag . '" data-toggle="tooltip" data-placement="top" title="' . $country->name . '"></i>  ';
                        }
                    }

                    return $tr;
                })
                ->editColumn('category', function (Offer $offer) {
                    if ($offer->category_id != null) {
                        return $offer->category->name;
                    }
                })

                ->addColumn('device', function (Offer $offer) {
                    if ($offer->devices->count() == 0) {
                        $icon = ' <i class="bx bx-desktop" style="color:rgb(0, 0, 0)"></i>';
                        $icon .= ' <i class="bx bx-tab" style="color:rgb(0, 0, 0)"></i>';
                        $icon .= ' <i class="bx bx-mobile" style="color:rgb(0, 0, 0)"></i>';
                    } else {
                        foreach ($offer->devices as $device)
                            if ($device->name == 'Desktop') {
                                $icon = ' <i class="bx bx-desktop" style="color:rgb(0, 0, 0)"></i>';
                            } elseif ($device->name == 'Tablet') {
                                $icon = ' <i class="bx bx-tab" style="color:rgb(0, 0, 0)"></i>';
                            } elseif ($device->name == 'Mobile') {
                                $icon = ' <i class="bx bx-mobile" style="color:rgb(0, 0, 0)"></i>';
                            }
                    }
                    return $icon;
                })

                ->rawColumns(['status', 'name', 'thumbnail', 'payout', 'countries', 'category', 'device'])
                ->make(true);
        }
        return view('student.offer.index');
        //return $data;
    }

    public function my(Request $request)
    {
        if ($request->ajax()) {
            $user_id = Auth::id();
            $data = Offer::where('status', 1)
                ->where('offer_permission', 'public')
                ->where('name', 'like', '%' . $request->name . '%')
                ->when($request->filled('categories'), function ($query) use ($request) {
                    return $query->whereIn('category_id', $request->input('categories'));
                })
                ->when($request->filled('offer_type'), function ($query2) use ($request) {
                    return $query2->whereIn('offer_model', $request->input('offer_type'));
                })
                ->when($request->filled('countries'), function ($query3) use ($request) {
                    $query3->whereHas('countries', function ($qry) use ($request) {
                        $qry->whereIn('countries.id', $request->input('countries'));
                    });
                })
                ->when($request->filled('device'), function ($query4) use ($request) {
                    $query4->whereHas('devices', function ($qry) use ($request) {
                        $qry->whereIn('devices.name', $request->input('device'));
                    });
                })
                ->orWhere(function ($query) use ($user_id) {
                    $query->where('offer_permission', 'request')
                        ->whereHas('OfferRequest', function ($qry1) use ($user_id) {
                            $qry1->where([['user_id', '=', $user_id], ['status', '=', 1],]);
                        });
                })
                //If we add private offer then we should use these code to show to student if private offer approve.
                // ->orWhere(function($query) use ($user_id) {
                //     $query->where('offer_permission', 'private')
                //         ->whereHas('OfferAccess', function($qry) use ($user_id) {
                //             $qry->where('user_id', $user_id);
                //         });
                // })
                ->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('name', function (Offer $offer) {
                    $name = '<a title="' . $offer->name . '" style="text-decoration:none" href="' . route('student.offer.show', $offer->id) . '">' . $offer->name . '</a>';

                    return $name;
                })
                ->editColumn('thumbnail', function (Offer $offer) {
                    if ($offer->thumbnail != null) {
                        $url = url('/storage/offers/' . $offer->thumbnail);
                        return "<img src='{$url}'>";
                    } else {
                        return "<img src='data:image/jpeg;base64,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' style='width: 100px; height: 40px'>";
                    }
                })
                ->editColumn('payout', function (Offer $offer) {
                     $offerStudents= OfferStudent::whereOffer_id($offer->id)->whereStudent_id(Auth::id())->first();
                     //dd($offerStudents);
                    if($offerStudents) 
                    {
                        if ($offerStudents->pay_model == 'Hybrid') {
                            return $offerStudents->default_payout . ' ' . $offerStudents->currency . ' + ' . $offerStudents->percent_payout . '%';
                        } elseif ($offerStudents->pay_model == 'RevShare') {
                            return $offerStudents->percent_payout . '%';
                        } elseif ($offerStudents->pay_model == 'Dynamic') {
                            return 'Dynamic';
                        } else {
                            return $offerStudents->default_payout . ' ' . $offerStudents->currency;
                        }
                    }
                    else
                    {
                        if ($offer->offer_model == 'Hybrid') {
                            return $offer->default_payout . ' ' . $offer->currency . ' + ' . $offer->percent_payout . '%';
                        } elseif ($offer->offer_model == 'RevShare') {
                            return $offer->percent_payout . '%';
                        } elseif ($offer->offer_model == 'Dynamic') {
                            return 'Dynamic';
                        } else {
                            return $offer->default_payout . ' ' . $offer->currency;
                        }
                    }
                })

                ->editColumn('countries', function (Offer $offer) {
                    $tr = '';
                    $num_tags = count($offer->countries);
                    if ($num_tags < 1) {
                        $tr = '<i class="flag-icon flag-icon-ww" data-toggle="tooltip" data-placement="top" title="World Wide"></i> World Wide';
                    }

                    if ($num_tags > 5) {
                        foreach ($offer->countries as $country) {
                            $tr .= $country->name . ', ';
                        }
                        $tr = '<span data-toggle="tooltip" data-placement="top" title="' . $tr . '">' . $num_tags . ' Countries</span>';
                    } else {

                        foreach ($offer->countries as $country) {
                            $flag = Str::lower($country->code);
                            $tr .= '<i class="flag-icon flag-icon-' . $flag . '" data-toggle="tooltip" data-placement="top" title="' . $country->name . '"></i>  ';
                        }
                    }

                    return $tr;
                })
                ->editColumn('category', function (Offer $offer) {
                    if ($offer->category_id != null) {
                        return $offer->category->name;
                    }
                })
                ->addColumn('device', function (Offer $offer) {
                    if ($offer->devices->count() == 0) {
                        $icon = ' <i class="bx bx-desktop" style="color:rgb(0, 0, 0)"></i>';
                        $icon .= ' <i class="bx bx-tab" style="color:rgb(0, 0, 0)"></i>';
                        $icon .= ' <i class="bx bx-mobile" style="color:rgb(0, 0, 0)"></i>';
                    } else {
                        foreach ($offer->devices as $device)
                            if ($device->name == 'Desktop') {
                                $icon = ' <i class="bx bx-desktop" style="color:rgb(0, 0, 0)"></i>';
                            } elseif ($device->name == 'Tablet') {
                                $icon = ' <i class="bx bx-tab" style="color:rgb(0, 0, 0)"></i>';
                            } elseif ($device->name == 'Mobile') {
                                $icon = ' <i class="bx bx-mobile" style="color:rgb(0, 0, 0)"></i>';
                            }
                    }
                    return $icon;
                })

                ->rawColumns(['name', 'thumbnail', 'payout', 'countries', 'category', 'device'])
                ->make(true);
        }
        return view('student.offer.my');
        //return $data;
    }

    public function show($id)
    {
        $offer = Offer::findorFail($id);

        $offerStudents= OfferStudent::whereOffer_id($offer->id)->whereStudent_id(Auth::id())->get();
        //dd($offerStudents);
        
        $checkstatus = OfferRequest::whereUser_id(Auth::id())->whereOffer_id($offer->id)->first();

        if ($checkstatus == null) {
            if ($offer->offer_permission == 'public') {
                $status = 'Approved';
            } elseif ($offer->offer_permission == 'request') {
                $status = 'Available';
            }
        } else {
            if ($checkstatus->status == 0) {
                $status = 'Pending';
            } elseif ($checkstatus->status == 1) {
                $status = 'Approved';
            } elseif ($checkstatus->status == 2) {
                $status = 'Rejected';
            }
        }

        $postbacks = Postback::where('offer_id', $offer->id)->where('student_id', auth()->id())->simplePaginate(5);

        return view('student.offer.show', compact('offer', 'status', 'postbacks','offerStudents'));
    }

    public function apply($id)
    {
        $offerRequest = new OfferRequest();
        $offerRequest->offer_id = $id;
        $offerRequest->user_id = Auth::id();
        $offerRequest->save();

        Toastr::success('We will notify you soon', 'Request reeived');

        return redirect()->back();
    }
}
