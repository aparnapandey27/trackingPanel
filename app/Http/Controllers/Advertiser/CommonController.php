<?php

namespace App\Http\Controllers\Advertiser;

use App\Http\Controllers\Controller;
use App\Models\Browser;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Country;
use App\Models\Offer;
use App\Models\Category;
use App\Models\Device;

class CommonController extends Controller
{
    /**
     * Get All Active Student
     */
    public function getStudents(Request $request)
    {
        $search = $request->search;
        //$role_id = $request->user_type == 'advertiser' ? '3' : '2';

        if ($search == '') {
            $students = User::student()->active()
                ->select('id', 'name')
                ->get();
        } else {
            $students = User::student()->active()
                ->select('id', 'name')
                ->where('name', 'LIKE', '%' . $search . '%')
                ->orwhere('id', 'LIKE', '%' . $search . '%')
                ->get();
        }

        $response = array();
        foreach ($students as $student) {
            $response[] = array(
                'id' => $student->id,
                'text' => "[$student->id]" . ' ' . $student->name
            );
        }

        echo json_encode($response);
        exit;
    }


    /**
     * Get All Active Offers
     */
    public function getOffers(Request $request)
    {
        $search = $request->search;

        if ($search == '') {
            $offers = Offer::active()
                ->select('id', 'name')
                ->get();
        } else {
            $offers = Offer::active()
                ->select('id', 'name')
                ->where('name', 'LIKE', '%' . $search . '%')
                ->orwhere('id', 'LIKE', '%' . $search . '%')
                ->get();
        }

        $response = array();
        foreach ($offers as $offer) {
            $response[] = array(
                'id' => $offer->id,
                'text' =>  "[$offer->id]" . ' ' . $offer->name
            );
        }

        echo json_encode($response);
        exit;
    }



    /**
     * Get All Categories
     */
    public function getCategories(Request $request)
    {
        $search = $request->search;

        if ($search == '') {
            $categories = Category::select('id', 'name')->get();
        } else {
            $categories = Category::select('id', 'name')
                ->where('name', 'LIKE', '%' . $search . '%')
                ->get();
        }

        $response = array();
        foreach ($categories as $category) {
            $response[] = array(
                'id' => $category->id,
                'text' => $category->name
            );
        }

        echo json_encode($response);
        exit;
    }



    /**
     * Get All Country
     */
    public function getCountries(Request $request)
    {
        $search = $request->search;

        if ($search == '') {
            $countries = Country::select('id', 'name', 'code')->get();
        } else {
            $countries = Country::select('id', 'name', 'code')
                ->where('name', 'LIKE', '%' . $search . '%')
                ->orwhere('code', 'LIKE', '%' . $search . '%')
                ->get();
        }

        $response = array();
        foreach ($countries as $country) {
            $response[] = array(
                'id' => $country->id,
                'text' => "[$country->code]" . ' ' . $country->name
            );
        }

        echo json_encode($response);
        exit;
    }

    public function getDevices(Request $request)
    {
        $search = $request->search;

        if ($search == '') {
            $devices = Device::select('id', 'name')->get();
        } else {
            $devices = Device::select('id', 'name')
                ->where('name', 'LIKE', '%' . $search . '%')
                ->get();
        }

        $response = array();
        foreach ($devices as $devices) {
            $response[] = array(
                'id' => $devices->id,
                'text' => $devices->name
            );
        }

        echo json_encode($response);
        exit;
    }

    public function getBrowsers(Request $request)
    {
        $search = $request->search;

        if ($search == '') {
            $browsers = Browser::select('id', 'name')->get();
        } else {
            $browsers = Browser::select('id', 'name')
                ->where('name', 'LIKE', '%' . $search . '%')
                ->get();
        }

        $response = array();
        foreach ($browsers as $browser) {
            $response[] = array(
                'id' => $browser->id,
                'text' => $browser->name
            );
        }

        echo json_encode($response);
        exit;
    }
}
