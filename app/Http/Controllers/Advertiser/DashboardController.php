<?php

namespace App\Http\Controllers\Advertiser;

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
        // $date = \Carbon\Carbon::today()->subDays(6);
        // $featured_offers = Offer::whereIs_featured('1')->get();

        // $chart = Click::select(DB::raw('date(clicks.created_at) as date , COUNT(clicks.id) as clicks , SUM(IF(conversions.status = (1 or 1), 1, 0)) as leads, SUM(IF(conversions.status = 1, conversions.payout, 0)) as costs'))
        //     ->LEFTJOIN('conversions', 'clicks.transaction_id', '=', 'conversions.click_transaction_id')
        //     ->orderBy("clicks.created_at")
        //     ->groupBy(DB::raw("date(clicks.created_at)"))
        //     ->where('clicks.advertiser_id', auth()->user()->id)
        //     ->where('clicks.created_at', '>=', $date)
        //     ->get()->toArray();
        // //Quick Stats Start//
        // $quick_stats = [];
        // $quick_stats['clicks'] = array_sum(array_column($chart, 'clicks'));
        // $quick_stats['conversions'] = array_sum(array_column($chart, 'leads'));
        // $quick_stats['costs'] = array_sum(array_column($chart, 'costs'));
        // if ($quick_stats['clicks'] != 0) {
        //     $quick_stats['cpcs'] = ($quick_stats['costs'] / $quick_stats['clicks']);
        // } else {
        //     $quick_stats['cpcs'] = 0;
        // }


        // //Quick Stats End//
        // //$chart = [];
        // $chart['click'] = array_column($chart, 'clicks');
        // $chart['lead'] = array_column($chart, 'leads');
        // $chart['cost'] = array_column($chart, 'costs');
        // $chart['date'] = array_column($chart, 'date');

        // $chart['click'] =  json_encode($chart['click'], JSON_NUMERIC_CHECK);
        // $chart['lead'] =  json_encode($chart['lead'], JSON_NUMERIC_CHECK);
        // $chart['cost'] =  json_encode($chart['cost'], JSON_NUMERIC_CHECK);
        // $chart['date'] =  json_encode($chart['date'], JSON_NUMERIC_CHECK);

        if ($request->has('daterange')) {
            $daterange = explode('-', $request->get('daterange'));
            $from = date('Y-m-d', strtotime(trim($daterange[0]))); //"2021-10-28"
            $to = date('Y-m-d', strtotime(trim($daterange[1]))); //"2021-11-03"
        } else {
            $from = \Carbon\Carbon::today()->subDays(6); //date('Y-m-01');
            $to = \Carbon\Carbon::today(); //date('Y-m-t');
        }
        $today = Carbon::today();
        $totalClickToday = Click::whereDate('created_at', $today)->count();

        $today = Carbon::today();
        $totalConversionToday = Conversion::whereDate('created_at', $today)->count();
        /*
        * dashboard stats and chart data
        */
        $clicks = Click::select(DB::raw('date(created_at) as date , COUNT(id) as clicks, "0" as leads, 0.00 as earnings'))
            ->orderBy(DB::raw("date(created_at)"))
            ->groupBy(DB::raw("date(created_at)"))
            ->where('advertiser_id', auth()->user()->id)
            ->whereDate('created_at', '>=', $from)
            ->whereDate('created_at', '<=', $to)
            ->get()->toArray();

        $leads = Conversion::select(DB::raw('date(created_at) as date , 0 as clicks, SUM(IF(status = "approved", 1, 0)) as leads,
        SUM(IF(status = "approved", revenue, 0)) as earnings'))
            ->orderBy(DB::raw("date(created_at)"))
            ->groupBy(DB::raw("date(created_at)"))
            ->where('advertiser_id', auth()->user()->id)
            ->whereDate('created_at', '>=', $from)
            ->whereDate('created_at', '<=', $to)
            ->get()->toArray();


        $chart = $this->merge_reports($clicks, $leads);

        $quick_stats = [];
        $quick_stats['clicks'] = array_sum(array_column($chart, 'clicks'));
        $quick_stats['conversions'] = array_sum(array_column($chart, 'leads'));
        $quick_stats['costs'] = array_sum(array_column($chart, 'earnings'));
        if ($quick_stats['clicks'] != 0) {
            $quick_stats['cpcs'] = ($quick_stats['costs'] / $quick_stats['clicks']);
        } else {
            $quick_stats['cpcs'] = 0;
        }


        $highchart['click'] = array_column($chart, 'clicks');
        $highchart['lead'] = array_column($chart, 'leads');
        $highchart['cost'] = array_column($chart, 'costs');
        $highchart['date'] = array_keys($chart);

        $chart['click'] =  json_encode($highchart['click'], JSON_NUMERIC_CHECK);
        $chart['lead'] =  json_encode($highchart['lead'], JSON_NUMERIC_CHECK);
        $chart['cost'] =  json_encode($highchart['cost'], JSON_NUMERIC_CHECK);
        $chart['date'] =  json_encode($highchart['date'], JSON_NUMERIC_CHECK);

        // dd($quick_stats);
        
        return view('advertiser.dashboard.index', compact('quick_stats', 'chart',  'totalClickToday','totalConversionToday'));
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
