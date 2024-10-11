<?php

namespace App\Http\Controllers\Employee\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Country;
use App\Models\Offer;
use App\Models\State;
use App\Models\User;
use App\Models\OfferGoal;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
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
                    $name = '<a title="' . $offer->offer_name . '" style="text-decoration:none" href="' . route('admin.offer.show', $offer->id) . '">' . $offer->name . '</a>';
                    if ($offer->devices->count() == 0) {
                        $icon = ' <i class="la la-desktop" style="color:rgb(0, 0, 0)"></i>';
                        $icon .= ' <i class="la la-tablet" style="color:rgb(0, 0, 0)"></i>';
                        $icon .= ' <i class="la la-mobile-alt" style="color:rgb(0, 0, 0)"></i>';
                    } else {
                        foreach ($offer->devices as $device)
                            if ($device->name == 'Desktop') {
                                $icon = ' <i class="la la-desktop" style="color:rgb(0, 0, 0)"></i>';
                            } elseif ($device->name == 'Tablet') {
                                $icon = ' <i class="la la-tablet" style="color:rgb(0, 0, 0)"></i>';
                            } elseif ($device->name == 'Mobile') {
                                $icon = ' <i class="la la-mobile-alt" style="color:rgb(0, 0, 0)"></i>';
                            }
                    }
                    return $name . '<br>' . $icon;
                })
                ->editColumn('thumbnail', function (Offer $offer) {
                    if ($offer->thumbnail != null) {
                        $url = url('/storage/offers/' . $offer->thumbnail);
                        return "<img src='{$url}'>";
                    } else {
                        return "<img src='data:image/jpeg;base64,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' style='width: 100px; height: 60px'>";
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

                ->addColumn('advertiser', function (Offer $offer) {
                    return $offer->advertiser->name;
                })

                ->addColumn('category', function (Offer $offer) {
                    if ($offer->category_id != null) {
                        return $offer->category->name;
                    } else {
                        return;
                    }
                })

                ->editColumn('revenue', function (Offer $offer) {
                    if ($offer->offer_model == 'Hybrid') {
                        return $offer->default_revenue . ' ' . $offer->currency . ' + ' . $offer->percent_revenue . '%';
                    } elseif ($offer->offer_model == 'RevShare') {
                        return $offer->percent_revenue . '%';
                    } elseif ($offer->offer_model == 'Dynamic') {
                        return 'Dynamic';
                    } else {
                        return $offer->default_revenue . ' ' . $offer->currency;
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

                ->addColumn('action', function (Offer $offer) {

                    $btn = '<a href="' . route('admin.offer.edit', $offer->id) . '" title="Edit" class="btn btn-info  btn-sm mb-2"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><path d="m16.474 5.408l2.118 2.117m-.756-3.982L12.109 9.27a2.118 2.118 0 0 0-.58 1.082L11 13l2.648-.53c.41-.082.786-.283 1.082-.579l5.727-5.727a1.853 1.853 0 1 0-2.621-2.621Z"/><path d="M19 15v3a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2h3"/></g></svg></a>
                            <a href="javascript:void(0)" data-toggle="tooltip" onclick="deleteOffer(' . $offer->id . ')" data-id="' . $offer->id . '" data-original-title="Delete" class="btn btn-danger  btn-sm mb-2"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"><path fill="currentColor" d="M7 21q-.825 0-1.413-.588T5 19V6H4V4h5V3h6v1h5v2h-1v13q0 .825-.588 1.413T17 21H7ZM17 6H7v13h10V6ZM9 17h2V8H9v9Zm4 0h2V8h-2v9ZM7 6v13V6Z"/></svg></a>';
                    return $btn;
                })
                ->addColumn('checkbox', '<input type="checkbox" name="offer_checkbox[]" class="checkbox c-checkbox offer_checkbox" value="{{$id}}" />')
                ->rawColumns(['checkbox', 'action', 'status', 'name', 'advertiser', 'thumbnail', 'payout', 'revenue', 'countries', 'category'])
                ->make(true);
        }
        return view('admin.offer.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $advertisers = User::where('role', 'advertiser')->where('status', 1)->get();
        $categories = Category::all();


        return view('admin.offer.create', compact('advertisers', 'categories'));
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
            'title' => 'string|required|max:120',
            'description' => 'nullable|string',
            //'preview_url' => 'url',
            //'tracking_url' => 'url|required',
            'tracking_url' => 'required',
            'conversion_flow' => 'nullable|string|max:120',
        ]);

        //Image upload with resize and save to storage
        if ($request->hasFile('thumbnail')) {
            $image = $request->file('thumbnail');
            $thumbnail = time() . '.' . $image->getClientOriginalExtension();
            if (!Storage::disk('public')->exists('offers')) {
                Storage::disk('public')->makeDirectory('offers');
            }
            $destinationPath = public_path('/storage/offers');
            $img = Image::make($image->getRealPath());
            // $img->resize(100, 60, function ($constraint) {
            //     $constraint->aspectRatio();
            // })->save($destinationPath . '/' . $thumbnail);
            $img->save($destinationPath . '/' . $thumbnail);
        } else {
            $thumbnail = null;
        }

        $offer = new Offer();
        $offer->name = $request->title;
        $offer->description = $request->description;
        $offer->preview_url = $request->preview_url;
        $offer->tracking_url = $request->tracking_url;
        $offer->conv_flow = $request->conversion_flow;
        $offer->default_revenue = $request->revenue != null ? $request->revenue : 0;
        $offer->default_payout = $request->payout != null ? $request->payout : 0;
        $offer->percent_revenue = $request->percent_revenue != null ? $request->percent_revenue : 0;
        $offer->percent_payout = $request->percent_payout != null ? $request->percent_payout : 0;
        $offer->currency = $request->currency != null ? $request->currency : config('app.currency');
        $offer->conversion_tracking = $request->conversion_tracking;
        $offer->offer_model = $request->offer_model;
        $offer->is_featured = $request->is_featured;
        $offer->same_ip_conversion = $request->same_ip_conversion;
        $offer->conversion_approval = $request->conversion_approval;
        $offer->min_conversion_time = $this->min_conversion_time($request->min_conversion_time, $request->min_conversion_time_type);
        $offer->max_conversion_time = $this->max_conversion_time($request->max_conversion_time, $request->max_conversion_type);
        $offer->offer_permission = $request->offer_permission;
        $offer->status = $request->status;
        $offer->advertiser_id = $request->advertiser_id;
        $offer->category_id = $request->category_id;
        $offer->refer_rule = $request->refer_rule;
        $offer->redirect_offer_id = $request->redirect_offer_id;
        $offer->expire_at = $request->expire_at;
        $offer->thumbnail = $thumbnail;
        $offer->save();

        $offer->countries()->attach($request->countries);
        $offer->states()->attach($request->states, ['country_id' => 101]);
        $offer->devices()->attach($request->devices);
        $offer->browsers()->attach($request->browsers);
        
        OfferGoal::create([
            'offer_id' => $offer->id,
            'goal_id' => 1,
            'pay_model' => $request->offer_model,
            'currency' => $request->currency != null ? $request->currency : config('app.currency'),
            'default_revenue' => $request->revenue != null ? $request->revenue : 0,
            'percent_revenue' => $request->percent_revenue != null ? $request->percent_revenue : 0,
            'default_payout' => $request->payout != null ? $request->payout : 0,
            'percent_payout' => $request->percent_payout != null ? $request->percent_payout : 0,
            
        ]);

        Toastr::success('Offer creation Successful', 'Created');

        return redirect()->route('admin.offer.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $offer = Offer::findorFail($id);
        return view('admin.offer.show', compact('offer'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $offer = Offer::findorfail($id);
        $advertisers = User::where('role', 'advertiser')->where('status', 1)->get();
        $categories = Category::all();


        return view('admin.offer.edit', compact('offer', 'advertisers', 'categories'));
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
            'title' => 'string|required|max:120',
            'description' => 'nullable|string',
            //'preview_url' => 'url',
            //'tracking_url' => 'url|required',
            'tracking_url' => 'required',
            'conversion_flow' => 'nullable|string|max:120',
        ]);

        $offer = Offer::find($id);
        if ($request->hasFile('thumbnail')) {
            $image = $request->file('thumbnail');
            $thumbnail = time() . '.' . $image->getClientOriginalExtension();
            if (!Storage::disk('public')->exists('offers')) {
                Storage::disk('public')->makeDirectory('offers');
            }
            //delete old post image
            if (Storage::disk('public')->exists('offers/' . $offer->thumbnail)) {
                Storage::disk('public')->delete('offers/' . $offer->thumbnail);
            }

            $destinationPath = public_path('/storage/offers');
            $img = Image::make($image->getRealPath());
            // $img->resize(100, 60, function ($constraint) {
            //     $constraint->aspectRatio();
            // })->save($destinationPath . '/' . $thumbnail);
            $img->save($destinationPath . '/' . $thumbnail);
        } else {
            $thumbnail = $offer->thumbnail;
        }


        $offer->name = $request->title;
        $offer->description = $request->description;
        $offer->preview_url = $request->preview_url;
        $offer->tracking_url = $request->tracking_url;
        $offer->conv_flow = $request->conversion_flow;
        $offer->default_revenue = $request->revenue != null ? $request->revenue : 0;
        $offer->default_payout = $request->payout != null ? $request->payout : 0;
        $offer->percent_revenue = $request->percent_revenue != null ? $request->percent_revenue : 0;
        $offer->percent_payout = $request->percent_payout != null ? $request->percent_payout : 0;
        $offer->currency = $request->currency;
        $offer->conversion_tracking = $request->conversion_tracking;
        $offer->offer_model = $request->offer_model;
        $offer->is_featured = $request->is_featured;
        $offer->same_ip_conversion = $request->same_ip_conversion;
        $offer->offer_permission = $request->offer_permission;
        $offer->conversion_approval = $request->conversion_approval;
        $offer->min_conversion_time = $this->min_conversion_time($request->min_conversion_time, $request->min_conversion_time_type);
        $offer->max_conversion_time = $this->max_conversion_time($request->max_conversion_time, $request->max_conversion_time_type);
        $offer->status = $request->status;
        $offer->advertiser_id = $request->advertiser_id;
        $offer->category_id = $request->category_id;
        $offer->refer_rule = $request->refer_rule;
        $offer->redirect_offer_id = $request->redirect_offer_id;
        $offer->expire_at = $request->expire_at;
        $offer->thumbnail = $thumbnail;
        $offer->update();

        $offer->countries()->sync($request->countries);
        //$offer->states()->syncWithPivotValues($request->states, ['country_id' => 101]);
        $offer->devices()->sync($request->devices);
        $offer->browsers()->sync($request->browsers);
        
        $goal = OfferGoal::where('offer_id', $offer->id)->first();
        
        if(!$goal){
            OfferGoal::create([
                'offer_id' => $offer->id,
                'goal_id' => 1,
                'pay_model' => $request->offer_model,
                'currency' => $request->currency != null ? $request->currency : config('app.currency'),
                'default_revenue' => $request->revenue != null ? $request->revenue : 0,
                'percent_revenue' => $request->percent_revenue != null ? $request->percent_revenue : 0,
                'default_payout' => $request->payout != null ? $request->payout : 0,
                'percent_payout' => $request->percent_payout != null ? $request->percent_payout : 0,
                
            ]);
        }
        else{
            $goal->pay_model = $request->offer_model;
            $goal->currency = $request->currency;
            $goal->default_revenue = $request->revenue != null ? $request->revenue : 0;
            $goal->percent_revenue = $request->percent_revenue != null ? $request->percent_revenue : 0;
            $goal->default_payout = $request->payout != null ? $request->payout : 0;
            $goal->percent_payout = $request->percent_payout != null ? $request->percent_payout : 0;
            
            $goal->update(); 
        }
        
    
        
        
        
        Toastr::success('Offer Update Successful', 'Updated');

        return redirect()->route('admin.offer.show', $offer->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Offer::destroy($id);
    }

    public function offer_clone($id)
    {
        $offer = Offer::findorfail($id);
        $offer->replicate();
        $offer_clone = $offer->replicate()->replicate()->fill([
            'name' =>  $offer->name . ' (copied from ' . $offer->id . ')',
            'status' => 0,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        $offer_clone->save();
        // $offer_clone->name = $offer_clone->name . ' (copied from ' . $offer_clone->id . ')';
        // $offer_clone->created_at = Carbon::now();
        // $offer_clone->updated_at = Carbon::now();
        // $offer_clone->save();

        $offer_clone->countries()->attach($offer->countries);

        $offer_clone->devices()->attach($offer->devices);
        $offer_clone->browsers()->attach($offer->browsers);

        Toastr::success('Offer Clone Successful', 'Cloned');
        return redirect()->route('admin.offer.show', $offer_clone->id);
    }

    protected function min_conversion_time($data, $time_value)
    {
        if ($time_value == 'h') {
            return $data * 60 * 60;
        } elseif ($time_value == 'm') {
            return $data * 60;
        } else {
            return $data;
        }
    }


    protected function max_conversion_time($data, $time_value)
    {
        if ($time_value == 'd') {
            return $data * 24;
        } else {
            return $data;
        }
    }
}
