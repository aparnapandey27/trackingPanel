<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Offer;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class OfferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Offer::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('name', function (Offer $offer) {
                    $name = '<a title="' . $offer->offer_name . '" style="text-decoration:none" href="' . route('employee.offer.show', $offer->id) . '">' . $offer->name . '</a>';
                    if ($offer->devices->count() == 0) {
                        $icon = ' <i class="fas fa-desktop" style="color:rgb(0, 0, 0)"></i>';
                        $icon .= ' <i class="fas fa-tablet-alt" style="color:rgb(0, 0, 0)"></i>';
                        $icon .= ' <i class="fas fa-mobile-alt" style="color:rgb(0, 0, 0)"></i>';
                    } else {
                        foreach ($offer->devices as $device)
                            if ($device->name == 'Desktop') {
                                $icon = ' <i class="fas fa-desktop" style="color:rgb(0, 0, 0)"></i>';
                            } elseif ($device->name == 'Tablet') {
                                $icon = ' <i class="fas fa-tablet-alt" style="color:rgb(0, 0, 0)"></i>';
                            } elseif ($device->name == 'Mobile') {
                                $icon = ' <i class="fas fa-mobile-alt" style="color:rgb(0, 0, 0)"></i>';
                            }
                    }
                    return $name . '<br>' . $icon;
                })
                ->editColumn('thumbnail', function (Offer $offer) {
                    if ($offer->thumbnail != null) {
                        $url = url('/storage/offers/' . $offer->thumbnail);
                        return "<img src='{$url}'>";
                    } else {
                        return "<img src='https://upload.wikimedia.org/wikipedia/commons/thumb/a/ac/No_image_available.svg/450px-No_image_available.svg.png style='width: 100px; height: 60px'>";
                    }
                })
                ->editColumn('status', function (Offer $offer) {
                    if ($offer->status == 1) {
                        $btn = '<span class="badge bg-success-subtle text-success text-uppercase">Active</span>';
                    } elseif ($offer->status == 2) {
                        $btn = '<span class="badge bg-danger-subtle text-danger text-uppercase">Closed</span>';
                    } elseif ($offer->status == 3) {
                        $btn = '<span class="badge bg-danger-subtle text-danger text-uppercase">Expired</span>';
                    } else {
                        $btn = '<span class="badge bg-warning-subtle text-warning text-uppercase">Pending</span>';
                    }

                    return $btn;
                })

                
                ->addColumn('category', function (Offer $offer) {
                    if ($offer->category_id != null) {
                        return $offer->category->name;
                    } else {
                        return;
                    }
                })

                ->editColumn('payout', function (Offer $offer) {

                    if ($offer->offer_model == 'Hybrid') {
                        return $offer->default_payout . ' ' . $offer->currency . ' + ' . $offer->percent_payout . '%';
                    } elseif ($offer->offer_model == 'RevShare') {
                        return $offer->percent_payout . '%';
                    } elseif ($offer->offer_model == 'Dynamic') {
                        return 'Dynamic';
                    } else {
                        return $offer->default_payout . ' ' . $offer->currency;
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

                ->addColumn('checkbox', '<input type="checkbox" name="offer_checkbox[]" class="checkbox c-checkbox offer_checkbox" value="{{$id}}" />')
                ->rawColumns(['checkbox', 'action', 'status', 'name', 'thumbnail', 'payout', 'countries', 'category'])
                ->make(true);
        }
        return view('employee.offer.index');
    }

    
    
    public function show($id)
    {
        $manager_id=Auth::id();
        $offer = Offer::findorFail($id);
        return view('employee.offer.show', compact('offer','manager_id'));
    }

  
}
