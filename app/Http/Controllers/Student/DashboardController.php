<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Click;
use Carbon\Carbon;
use App\Models\Conversion;
use App\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('daterange')) {
            $daterange = explode('-', $request->get('daterange'));
            $from = date('Y-m-d', strtotime(trim($daterange[0]))); //"2021-10-28"
            $to = date('Y-m-d', strtotime(trim($daterange[1]))); //"2021-11-03"
        } else {
            $from = \Carbon\Carbon::today()->subDays(6); //date('Y-m-01');
            $to = \Carbon\Carbon::today(); //date('Y-m-t');
        }

        $date = \Carbon\Carbon::now()->format('m-Y');

        $today = Carbon::today();
        $totalClickToday = Click::whereDate('created_at', $today)->count();

        $today = Carbon::today();
        $totalConversionToday = Conversion::whereDate('created_at', $today)->count();

        /*
        * feauterd offers
        */
        $featured_offers = Offer::select('id', 'name', 'default_payout', 'percent_payout', 'offer_model', 'currency', 'thumbnail')->whereIs_featured('1')->get();

        /*
        * recently added offers
        */
        $recently_added_offers = Offer::select('id', 'name', 'default_payout', 'percent_payout', 'offer_model', 'category_id', 'currency', 'thumbnail')->orderBy('id', 'desc')->limit(5)->get();

        /*
        * recently expired offers
        */
        $recently_expired_offers = Offer::where('status', 2)->select('id', 'name', 'default_payout', 'percent_payout', 'offer_model', 'category_id', 'currency', 'thumbnail')->orderBy('updated_at', 'desc')->limit(5)->get();




        /*
        * dashboard stats and chart data
        */
        $clicks = Click::select(DB::raw('date(created_at) as date , COUNT(id) as clicks, "0" as leads, 0.00 as earnings'))
            ->orderBy(DB::raw("date(created_at)"))
            ->groupBy(DB::raw("date(created_at)"))
            ->where('student_id', auth()->user()->id)
            ->whereDate('created_at', '>=', $from)
            ->whereDate('created_at', '<=', $to)
            ->get()->toArray();

        $leads = Conversion::select(DB::raw('date(created_at) as date , 0 as clicks, SUM(IF(status = "approved", 1, 0)) as leads,
        SUM(IF(status = "approved", payout, 0)) as earnings'))
            ->orderBy(DB::raw("date(created_at)"))
            ->groupBy(DB::raw("date(created_at)"))
            ->where('student_id', auth()->user()->id)
            ->whereDate('created_at', '>=', $from)
            ->whereDate('created_at', '<=', $to)
            ->get()->toArray();


        $chart = $this->merge_reports($clicks, $leads);

        $quick_stats = [];
        $quick_stats['clicks'] = array_sum(array_column($chart, 'clicks'));
        $quick_stats['conversions'] = array_sum(array_column($chart, 'leads'));
        $quick_stats['earnings'] = array_sum(array_column($chart, 'earnings'));
        if ($quick_stats['clicks'] != 0) {
            $quick_stats['epcs'] = ($quick_stats['earnings'] / $quick_stats['clicks']);
        } else {
            $quick_stats['epcs'] = 0;
        }


        $highchart['click'] = array_column($chart, 'clicks');
        $highchart['lead'] = array_column($chart, 'leads');
        $highchart['earn'] = array_column($chart, 'earnings');
        $highchart['date'] = array_keys($chart);

        $chart['click'] =  json_encode($highchart['click'], JSON_NUMERIC_CHECK);
        $chart['lead'] =  json_encode($highchart['lead'], JSON_NUMERIC_CHECK);
        $chart['earn'] =  json_encode($highchart['earn'], JSON_NUMERIC_CHECK);
        $chart['date'] =  json_encode($highchart['date'], JSON_NUMERIC_CHECK);


        //return $chart;

        // dd($quick_stats);
        return view('student.dashboard.index', compact('quick_stats', 'chart', 'featured_offers', 'recently_added_offers', 'recently_expired_offers', 'from', 'to','totalClickToday','totalConversionToday'));
    }

    protected function merge_reports($arrayOne, $arrayTwo)
    {
        $object = array();

        foreach ($arrayOne as $key => $value) {
            $value = (array) $value;
            $key_id = $value["date"];

            $object[$key_id] = array(
                "clicks" => $value["clicks"],
                "leads" => 0,
                "earnings" => 0,
            );
        };


        foreach ($arrayTwo as $key => $value) {
            $value = (array) $value;
            $key_id = $value["date"];

            if (isset($object[$key_id])) {
                $object[$key_id] = array_merge($object[$key_id], array(
                    "leads" => $value["leads"],
                    "earnings" => $value["earnings"],
                ));
            } else {
                $object[$key_id] = array(
                    "clicks" => 0,
                    "leads" => $value["leads"],
                    "earnings" => $value["earnings"],
                );
            }
        };

        return $object;
    }
}
