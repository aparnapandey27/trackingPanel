<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Country;
use App\Models\Offer;
use Illuminate\Http\Request;

class CommonController extends Controller
{
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
}
