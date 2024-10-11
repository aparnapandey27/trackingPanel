<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Country;
use App\Models\Offer;
use App\Models\State;
use App\Models\User;
use App\Models\Device;
use App\Models\OfferGoal;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use App\Models\Browser;
use Flasher\Laravel\Facade\Flasher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;
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
        try{
            if ($request->ajax()) {
                $data = Offer::where('status', '!=', 2)->latest()->get();
                    return Datatables::of($data)
                        ->addIndexColumn()
                        ->addColumn('name', function (Offer $offer) {
                            $name = '<a title="' . $offer->offer_name . '" style="text-decoration:none" href="' . route('admin.offers.show', $offer->id) . '">' . $offer->name . '</a>';
                            
                            $icon = '';
                            if ($offer->devices->count() == 0) {
                                // Default icons for all devices if none are specified
                                $icon .= '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" style="color:rgb(0, 0, 0)"><path d="M2 3h20a1 1 0 011 1v14a1 1 0 01-1 1H2a1 1 0 01-1-1V4a1 1 0 011-1zm0 0v14h20V4H2z"/></svg>'; // Desktop icon
                                $icon .= '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" style="color:rgb(0, 0, 0)"><path d="M4 1h16a1 1 0 011 1v20a1 1 0 01-1 1H4a1 1 0 01-1-1V2a1 1 0 011-1zm0 0v20h16V2H4z"/></svg>'; // Tablet icon
                                $icon .= '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" style="color:rgb(0, 0, 0)"><path d="M6 1h12a1 1 0 011 1v20a1 1 0 01-1 1H6a1 1 0 01-1-1V2a1 1 0 011-1zm0 0v20h12V2H6z"/></svg>'; // Mobile icon
                            } else {
                                foreach ($offer->devices as $device) {
                                    if ($device->name == 'Desktop') {
                                        $icon .= '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" style="color:rgb(0, 0, 0)"><path d="M2 3h20a1 1 0 011 1v14a1 1 0 01-1 1H2a1 1 0 01-1-1V4a1 1 0 011-1zm0 0v14h20V4H2z"/></svg>';
                                    } elseif ($device->name == 'Tablet') {
                                        $icon .= '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" style="color:rgb(0, 0, 0)"><path d="M4 1h16a1 1 0 011 1v20a1 1 0 01-1 1H4a1 1 0 01-1-1V2a1 1 0 011-1zm0 0v20h16V2H4z"/></svg>';
                                    } elseif ($device->name == 'Mobile') {
                                        $icon .= '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" style="color:rgb(0, 0, 0)"><path d="M6 1h12a1 1 0 011 1v20a1 1 0 01-1 1H6a1 1 0 01-1-1V2a1 1 0 011-1zm0 0v20h12V2H6z"/></svg>';
                                    }
                                }
                            }

                            return $name . $icon; 
                        })
    

                    ->editColumn('thumbnail', function (Offer $offer) {
                        if ($offer->thumbnail != null) {
                            $url = url('/storage/offers/' . $offer->thumbnail);
                            return "<img src='{$url}' style='width: 100px; height: 60px'>";
                        } else {
                            return "<img src='https://salonlfc.com/wp-content/uploads/2018/01/image-not-found-1-scaled.png' style='width: 100px; height: 60px'>";
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
    
                        $btn = '<a href="' . route('admin.offers.edit', $offer->id) . '" title="Edit" class="btn btn-info  btn-sm mb-2"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><path d="m16.474 5.408l2.118 2.117m-.756-3.982L12.109 9.27a2.118 2.118 0 0 0-.58 1.082L11 13l2.648-.53c.41-.082.786-.283 1.082-.579l5.727-5.727a1.853 1.853 0 1 0-2.621-2.621Z"/><path d="M19 15v3a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2h3"/></g></svg></a>
                                <a href="javascript:void(0)" data-toggle="tooltip" onclick="banOffer(' . $offer->id . ', 2)" data-id="' . $offer->id . '" title="Partially delete the offer" class="btn btn-warning  btn-sm mb-2"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24">
                                    <path fill="currentColor" d="M5.3 6.3c-3.8 3.8-3.8 9.9 0 13.7 3.8 3.8 9.9 3.8 13.7 0 3.8-3.8 3.8-9.9 0-13.7-3.8-3.8-9.9-3.8-13.7 0zm11.3 11.3c-2.8 2.8-7.3 2.8-10.1 0-2.8-2.8-2.8-7.3 0-10.1 2.8-2.8 7.3-2.8 10.1 0 2.8 2.8 2.8 7.3 0 10.1zm-8.5-8.5l8.5 8.5-1.4 1.4-8.5-8.5 1.4-1.4zm8.5 8.5l-8.5-8.5 1.4-1.4 8.5 8.5-1.4 1.4z"></path>
                                </svg></a>
                                <a href="javascript:void(0)" data-toggle="tooltip" onclick="deleteOffer(' . $offer->id . ')" data-id="' . $offer->id . '" data-original-title="Delete" class="btn btn-danger  btn-sm mb-2"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"><path fill="currentColor" d="M7 21q-.825 0-1.413-.588T5 19V6H4V4h5V3h6v1h5v2h-1v13q0 .825-.588 1.413T17 21H7ZM17 6H7v13h10V6ZM9 17h2V8H9v9Zm4 0h2V8h-2v9ZM7 6v13V6Z"/></svg></a>';
                        return $btn;
                    })
                    ->addColumn('checkbox', '<input type="checkbox" name="offer_checkbox[]" class="checkbox c-checkbox offer_checkbox" value="{{$id}}" />')
                    ->rawColumns(['checkbox', 'action', 'status', 'name', 'advertiser', 'thumbnail', 'payout', 'revenue', 'countries', 'category'])
                    ->make(true);
            }
            return view('admin.offers.index');
        } catch (\Exception $e) {
            // Log the exception or handle it accordingly
            return response()->json(['error' => $e->getMessage()], 500);
        }
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
        $devices = Device::all();
        $browsers = Browser::all();
        $countries = Country::all();
        return view('admin.offers.create', compact('advertisers', 'categories','countries','devices','browsers'));
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
            'title' => 'required|max:120',
            'description' => 'nullable|string',
            //'preview_url' => 'url',
            //'tracking_url' => 'url|required',
            'package' => 'nullable|string',
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
            $img = Image::read($image->getRealPath());
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
        $offer->package_name = $request->package;
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
        $offer->note = $request->note;
        $offer->thumbnail = $thumbnail;
        $offer->save();

        $offer->countries()->attach($request->countries);
        $offer->states()->attach($request->states, ['country_id' => 101]);
        $offer->devices()->attach($request->devices);
        $offer->browsers()->attach($request->browsers);
        
        OfferGoal::create([
            'offer_id' => $offer->id,
            'goal_id' => 1,
            'offer_model' => $request->offer_model,
            'currency' => $request->currency != null ? $request->currency : config('app.currency'),
            'default_revenue' => $request->revenue != null ? $request->revenue : 0,
            'percent_revenue' => $request->percent_revenue != null ? $request->percent_revenue : 0,
            'default_payout' => $request->payout != null ? $request->payout : 0,
            'percent_payout' => $request->percent_payout != null ? $request->percent_payout : 0,
            
        ]);

        Toastr::success('Offer creation Successful', 'Created');

        return redirect()->route('admin.offers.index');
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
        return view('admin.offers.show', compact('offer'));
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
        $countries = Country::all();
        $devices = Device::all();
        $browsers = Browser::all();


        return view('admin.offers.edit', compact('offer', 'advertisers', 'categories','countries','devices','browsers'));
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
        // dd($request->file('thumbnail'));

        $offer = Offer::find($id);
        if ($request->hasFile('thumbnail')) {
            $image = $request->file('thumbnail');
            dd($image);
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
            $img->resize(100, 60, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath . '/' . $thumbnail);
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
        $offer->note = $request->note;
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

        return redirect()->route('admin.offers.index');
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
        return redirect()->route('admin.offers.show', $offer_clone->id);
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
    
    public function fetchOffer(){
        return view('admin.offers.fetch');
    }
    
    public function status(Request $request, $id)
    {
        $offer = Offer::find($id);
        $offer->status = $request->status;
        $offer->update();
    }
}
