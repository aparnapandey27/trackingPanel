<?php

namespace App\Http\Controllers\Advertiser;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Country;
use App\Models\Offer;
use App\Models\User;
use App\Models\Device;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use App\Models\Browser;
use Flasher\Laravel\Facade\Flasher;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

class OfferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $offers = Offer::where('advertiser_id', auth()->user()->id)->orderBy('id', 'desc')->paginate(10);
        return view('advertiser.offer.index', compact('offers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $devices = Device::all();
        $browsers = Browser::all();
        $countries = Country::all();
        return view('advertiser.offer.create', compact('categories','countries','devices','browsers'));
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
            'description' => 'string',
            'preview_url' => 'required',
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
        $offer->default_revenue = $request->revenue != null ? $request->revenue : 0;
        $offer->default_payout = $request->payout != null ? $request->payout : 0;
        $offer->percent_revenue = $request->percent_revenue != null ? $request->percent_revenue : 0;
        $offer->percent_payout = $request->percent_payout != null ? $request->percent_payout : 0;
        $offer->currency = $request->currency;
        $offer->same_ip_conversion = $request->same_ip_conversion;
        $offer->conversion_approval = $request->conversion_approval;
        $offer->min_conversion_time = $this->min_conversion_time($request->min_conversion_time, $request->min_conversion_time_type);
        $offer->max_conversion_time = $this->max_conversion_time($request->max_conversion_time, $request->max_conversion_type);
        $offer->offer_model = $request->offer_model;
        // $offer->offer_permission = $request->offer_permission;
        $offer->status = 0;
        $offer->advertiser_id = auth()->user()->id;
        $offer->category_id = $request->category_id;
        $offer->expire_at = $request->expire_at;
        $offer->thumbnail = $thumbnail;
        $offer->save();

        $offer->countries()->attach($request->countries);
        $offer->devices()->attach($request->devices);
        $offer->browsers()->attach($request->browsers);

        Toastr::success('Offer creation Successful', 'Created');

        return redirect()->route('advertiser.offer.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $offer = Offer::findorfail($id);

        return view('advertiser.offer.show', compact('offer'));
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
        $categories = Category::all();


        return view('advertiser.offer.edit', compact('offer', 'categories'));
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
            'description' => 'string',
            'preview_url' => 'url',
            'tracking_url' => 'url|required',
            'conversion_flow' => 'string|max:120',
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
        $offer->percent_revenue = $request->percent_revenue != null ? $request->percent_revenue : 0;
        $offer->currency = $request->currency;
        $offer->same_ip_conversion = $request->same_ip_conversion;
        $offer->conversion_approval = $request->conversion_approval;
        $offer->min_conversion_time = $this->min_conversion_time($request->min_conversion_time, $request->min_conversion_time_type);
        $offer->max_conversion_time = $this->max_conversion_time($request->max_conversion_time, $request->max_conversion_type);
        $offer->offer_model = $request->offer_model;
        $offer->offer_permission = $request->offer_permission;
        $offer->status = 0;
        $offer->category_id = $request->category_id;
        $offer->expire_at = $request->expire_at;
        $offer->thumbnail = $thumbnail;
        $offer->update();

        $offer->countries()->sync($request->countries);
        //$offer->states()->syncWithPivotValues($request->states, ['country_id' => 101]);
        $offer->devices()->sync($request->devices);
        $offer->browsers()->sync($request->browsers);

        Flasher::success('Offer Update Successful', 'Updated');

        return redirect()->route('advertiser.offer.show', $offer->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
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
