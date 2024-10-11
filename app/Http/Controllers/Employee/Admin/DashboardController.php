<?php

namespace App\Http\Controllers\Employee\Admin;

use App\Http\Controllers\Controller;
use App\Models\Click;
use App\Models\Conversion;
use App\Models\Offer;
use App\Models\OfferRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {

        $featured_offers = Offer::where('is_featured', 1)->get();

        $pending = [];
        $pending['student'] = User::student()->where('status', 0)->count();
        $pending['advertiser'] = User::advertiser()->where('status', 0)->count();
        $pending['offer'] = Offer::where('status', 0)->count();
        $pending['offer_application'] = OfferRequest::where('status', 0)->count();

        $total= [];
        $total['student'] = User::student()->count();
        $total['offer'] = Offer::count();
        


        if ($request->has('daterange')) {
            $daterange = explode('-', $request->get('daterange'));
            $from = date('Y-m-d', strtotime(trim($daterange[0]))); //"2021-10-28"
            $to = date('Y-m-d', strtotime(trim($daterange[1]))); //"2021-11-03"
        } else {
            $from = \Carbon\Carbon::today()->subDays(6)->format('Y-m-d');;
            $to = \Carbon\Carbon::today()->format('Y-m-d');
        }

        /*
        * here we tried to make two spearte query and merge them
        * it's working fine but date range is not serilized
        * need to more work here
        */
        $today = \Carbon\Carbon::today();
        $todayClicks = Click::whereDate('created_at', '=', $today)->count();

        // Count today's conversions
        $todayConversions = Conversion::whereDate('created_at', '=', $today)
            ->where('status', 'approved')
            ->count();


        $clicks = Click::select(DB::raw('date(created_at) as date , COUNT(id) as clicks, "0" as leads, 0.00 as revenue, 0.00 as payout, 0.00 as profit
        ,SUM(IF(device_type = "Mobile", 1, 0)) as mobile,
        SUM(IF(device_type = "Desktop", 1, 0)) as desktop,
        SUM(IF(device_type = "Tablet", 1, 0)) as tablet,
        SUM(IF(device_type = "iPhone", 1, 0)) as iPhone'))
            ->orderBy("created_at")
            ->groupBy(DB::raw("date(created_at)"))
            ->whereDate('created_at', '>=', $from)
            ->whereDate('created_at', '<=', $to)
            ->get()->toArray();

            
        $leads = Conversion::select(DB::raw('date(created_at) as date , 0 as clicks, SUM(IF(status = ("approved" or "pending"), 1, 0)) as leads,
        SUM(IF(status = "approved", payout, 0)) as payout,
            SUM(IF(status = "approved", revenue, 0)) as revenue,
            SUM(IF(status = "approved", revenue, 0)) - SUM(IF(status = "approved", payout, 0)) as profit'))
            ->orderBy("created_at")
            ->groupBy(DB::raw("date(created_at)"))
            ->whereDate('created_at', '>=', $from)
            ->whereDate('created_at', '<=', $to)
            ->get()->toArray();


        $data = $this->merge_reports($clicks, $leads);        

       
        //Quick Stats Start//
        $quick_stats = [];
        $quick_stats['clicks'] = array_sum(array_column($data, 'clicks'));
        $quick_stats['conversions'] = array_sum(array_column($data, 'leads'));
        $quick_stats['payouts'] = array_sum(array_column($data, 'payout'));
        $quick_stats['revenues'] = array_sum(array_column($data, 'revenue'));
        $quick_stats['profits'] = array_sum(array_column($data, 'profit'));
        $quick_stats['mobile'] = array_sum(array_column($data, 'mobile'));
        $quick_stats['desktop'] = array_sum(array_column($data, 'desktop'));
        $quick_stats['tablet'] = array_sum(array_column($data, 'tablet'));
        $quick_stats['iPhone'] = array_sum(array_column($data, 'iPhone'));        
            
        


        if ($quick_stats['clicks'] != 0) {
            $quick_stats['ppcs'] = ($quick_stats['profits'] / $quick_stats['clicks']);
        } else {
            $quick_stats['ppcs'] = 0;
        }
        if ($quick_stats['clicks'] != 0) {
            $quick_stats['crs'] = ($quick_stats['conversions'] / $quick_stats['clicks'] * 100);
        } else {
            $quick_stats['crs'] = 0;
        }
        //Quick Stats End//

        //Highchart Start//
        $chart['click'] = array_column($data, 'clicks');
        $chart['lead'] = array_column($data, 'leads');
        $chart['payout'] = array_column($data, 'payout');
        $chart['revenue'] = array_column($data, 'revenue');
        $chart['profit'] = array_column($data, 'profit');
        $chart['date'] = array_keys($data);

        $chart['click'] =  json_encode($chart['click'], JSON_NUMERIC_CHECK);
        $chart['lead'] =  json_encode($chart['lead'], JSON_NUMERIC_CHECK);
        $chart['payout'] =  json_encode($chart['payout'], JSON_NUMERIC_CHECK);
        $chart['revenue'] =  json_encode($chart['revenue'], JSON_NUMERIC_CHECK);
        $chart['profit'] =  json_encode($chart['profit'], JSON_NUMERIC_CHECK);
        $chart['date'] =  json_encode($chart['date'], JSON_NUMERIC_CHECK);


        $top_students = Conversion::select(DB::raw('users.id as aid, users.name as aname, SUM(IF(conversions.status = "approved", conversions.payout, 0)) as payout, SUM(IF(conversions.status = "approved", conversions.revenue, 0)) as revenue, SUM(IF(conversions.status = "approved", conversions.revenue, 0)) - SUM(IF(conversions.status = "approved", conversions.payout, 0)) as profit'))
            ->JOIN('users', 'conversions.student_id', '=', 'users.id')
            ->groupBy(DB::raw("conversions.student_id"))
            ->whereDate('conversions.created_at', '>=', $from)
            ->whereDate('conversions.created_at', '<=', $to)
            ->limit(5)->get();

        $top_advertisers = Conversion::select(DB::raw('users.id as aid, users.name as aname, SUM(IF(conversions.status = "approved", conversions.payout, 0)) as payout, SUM(IF(conversions.status = "approved", conversions.revenue, 0)) as revenue, SUM(IF(conversions.status = "approved", conversions.revenue, 0)) - SUM(IF(conversions.status = "approved", conversions.payout, 0)) as profit'))
            ->JOIN('users', 'conversions.advertiser_id', '=', 'users.id')
            ->groupBy(DB::raw("conversions.advertiser_id"))
            ->whereDate('conversions.created_at', '>=', $from)
            ->whereDate('conversions.created_at', '<=', $to)
            ->limit(5)->get();

        $top_offers = Conversion::select(DB::raw('offer_id as oid, offers.name as offer, SUM(IF(conversions.status = "approved", conversions.payout, 0)) as payout, SUM(IF(conversions.status = "approved", conversions.revenue, 0)) as revenue, SUM(IF(conversions.status = "approved", conversions.revenue, 0)) - SUM(IF(conversions.status = "approved", conversions.payout, 0)) as profit'))
            ->JOIN('offers', 'conversions.offer_id', '=', 'offers.id')
            ->groupBy(DB::raw("offer_id"))
            ->whereDate('conversions.created_at', '>=', $from)
            ->whereDate('conversions.created_at', '<=', $to)
            ->limit(5)->get();

        $top_countries = Conversion::select(DB::raw('country as Country, SUM(IF(status = "approved", payout, 0)) as Payout, SUM(IF(status = "approved", revenue, 0)) as Revenue, SUM(IF(status = "approved", revenue, 0)) - SUM(IF(status = "approved", payout, 0)) as Profit, CAST(SUM(IF(status = "approved", 1, 0)) / COUNT(*) * 100 AS UNSIGNED) as ConversionPercentage'))
            ->groupBy(DB::raw("country"))
            ->whereDate('created_at', '>=', $from)
            ->whereDate('created_at', '<=', $to)
            ->limit(5)->get();

        return view('admin.dashboard.index', compact('quick_stats', 'pending', 'chart', 'to', 'from', /*'sql',*/ 'featured_offers', 'top_students', 'top_advertisers', 'top_offers', 'top_countries', 'total','todayClicks','todayConversions'));
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
                "payout" => 0,
                "revenue" => 0,
                "profit" => 0,
                "mobile" => $value["mobile"],
                "desktop" => $value["desktop"],
                "tablet" => $value["tablet"],
                "iPhone" => $value["iPhone"]              
            );
        };
        
        foreach ($arrayTwo as $key => $value) {
            $value = (array) $value;
            $key_id = $value["date"];

            if (isset($object[$key_id])) {
                $object[$key_id] = array_merge($object[$key_id], array(
                    "leads" => $value["leads"],
                    "payout" => $value["payout"],
                    "revenue" => $value["revenue"],
                    "profit" => $value["profit"],                    
                ));
            } else {
                $object[$key_id] = array(
                    "clicks" => 0,
                    "leads" => $value["leads"],
                    "payout" => $value["payout"],
                    "revenue" => $value["revenue"],
                    "profit" => $value["profit"],
                    "mobile" =>  0,
                    "desktop" =>0,
                    "tablet" => 0,
                    "iPhone" => 0
                );
            }
        };

        return $object;
    }
}
