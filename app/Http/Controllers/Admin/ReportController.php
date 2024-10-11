<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Click;
use App\Models\Conversion;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class ReportController extends Controller
{
    public function performance(Request $request)
    {
        // Handle date range
        if ($request->has('daterange')) {
            $daterange = explode('-', $request->get('daterange'));
            $from = date('Y-m-d', strtotime(trim($daterange[0])));
            $to = date('Y-m-d', strtotime(trim($daterange[1])));
        } else {
            $from = date('Y-m-01');
            $to = date('Y-m-t');
        }
    
        // Set up data array
        $data = $request->has('data') ? $request->get('data') : [
            'student_id' => 1,
            'student' => 1,
            'offer_id' => 1,
            'offer' => 1,
        ];
    
        // Set up statistics array
        $statistics = $request->has('statistics') ? $request->get('statistics') : [
            'clicks' => 1,
            'conversions' => 1,
            'revenue' => 1,
            'payout' => 1,
            'profit' => 1,
        ];
    
        // Student and Offer filters
        $students = $request->students;
        $offers = $request->offers;
    
        $headers = [];
        $fields = [];
        $groupby = [];
    
        // Build fields and groupby based on input data
        if (!empty($data)) {
            if (isset($data['student_id'])) {
                array_push($fields, 'users1.id as student_id');
                array_push($headers, 'Student ID');
                array_push($groupby, 'users1.id');
            }
            if (isset($data['student'])) {
                array_push($fields, 'users1.name as student');
                array_push($headers, 'Student');
                array_push($groupby, 'users1.name');
            }
            if (isset($data['advertiser_id'])) {
                array_push($fields, 'users2.id as advertiser_id');
                array_push($headers, 'Advertiser ID');
                array_push($groupby, 'users2.id');
            }
            if (isset($data['advertiser'])) {
                array_push($fields, 'users2.name as advertiser');
                array_push($headers, 'Advertiser');
                array_push($groupby, 'users2.name');
            }
            if (isset($data['offer_id'])) {
                array_push($fields, 'clicks.offer_id');
                array_push($headers, 'Offer ID');
                array_push($groupby, 'clicks.offer_id');
            }
            if (isset($data['offer'])) {
                array_push($fields, 'clicks.offer_name');
                array_push($headers, 'Offer');
                array_push($groupby, 'clicks.offer_name');
            }
            if (isset($data['country'])) {
                array_push($fields, 'clicks.country');
                array_push($headers, 'Country');
                array_push($groupby, 'clicks.country');
            }
            if (isset($data['device'])) {
                array_push($fields, 'clicks.device_type');
                array_push($headers, 'Device');
                array_push($groupby, 'clicks.device_type');
            }
            if (isset($data['os'])) {
                array_push($fields, 'clicks.os_name');
                array_push($headers, 'Operating System');
                array_push($groupby, 'clicks.os_name');
            }
            if (isset($data['browser'])) {
                array_push($fields, 'clicks.browser_name');
                array_push($headers, 'Browser');
                array_push($groupby, 'clicks.browser_name');
            }
            // Add sub IDs to fields and groupby
            foreach (range(1, 5) as $i) {
                if (isset($data["subid$i"])) {
                    array_push($fields, "clicks.stu_sub$i");
                    array_push($headers, "Sub ID $i");
                    array_push($groupby, "clicks.stu_sub$i");
                }
            }
            if (isset($data['paytm_no'])) {
                array_push($fields, 'clicks.paytm_no');
                array_push($headers, 'Paytm No');
            }
        } else {
            return back()->withErrors(['error' => "You didn't select anything"]);
        }
    
        // Build query
        $query = "SELECT " . implode(', ', $fields) . " ";
    
        // Add statistics to the query
        if (!empty($statistics)) {
            if (isset($statistics['clicks'])) {
                $query .= ", COUNT(clicks.id) as Clicks ";
                array_push($headers, 'Clicks');
            }
            if (isset($statistics['conversions'])) {
                $query .= ", SUM(IF(conversions.status IN ('approved', 'pending'), 1, 0)) as Conversions";
                array_push($headers, 'Conversions');
            }
            if (isset($statistics['currency'])) {
                $query .= ", conversions.currency as Currency ";
                array_push($headers, 'Currency');
            }
            if (isset($statistics['payout'])) {
                $query .= ", FORMAT(SUM(IF(conversions.status = 'approved', conversions.payout, 0)), 2) as Payout ";
                array_push($headers, 'Payout');
            }
            if (isset($statistics['revenue'])) {
                $query .= ", FORMAT(SUM(IF(conversions.status = 'approved', conversions.revenue, 0)), 2) as Revenue ";
                array_push($headers, 'Revenue');
            }
            if (isset($statistics['profit'])) {
                $query .= ", FORMAT(SUM(IF(conversions.status = 'approved', conversions.revenue, 0)) - SUM(IF(conversions.status = 'approved', conversions.payout, 0)), 2) as Profit ";
                array_push($headers, 'Profit');
            }
        }
    
        // Handle calculations
        $calculations = $request->get('calculations');
        if (!empty($calculations)) {
            $clicks = Click::count();
            if (isset($calculations['cr'])) {
                $query .= ", FORMAT(COUNT(conversions.id) / $clicks * 100, 2) as CR ";
                array_push($headers, 'CR');
            }
            if (isset($calculations['cpc'])) {
                $query .= ", FORMAT(SUM(IF(conversions.status = 'approved', conversions.payout, 0)) / $clicks, 2) as CPC ";
                array_push($headers, 'CPC');
            }
            if (isset($calculations['rpc'])) {
                $query .= ", FORMAT(SUM(IF(conversions.status = 'approved', conversions.revenue, 0)) / $clicks, 2) as RPC ";
                array_push($headers, 'RPC');
            }
        }
    
        // Build the FROM clause
        // Build the FROM clause
$query .= " FROM clicks 
            JOIN users as users1 ON users1.id = clicks.student_id 
            JOIN users as users2 ON users2.id = clicks.advertiser_id 
            LEFT JOIN conversions ON clicks.transaction_id = conversions.click_transaction_id 
            WHERE (date(clicks.created_at) BETWEEN '$from' AND '$to')";

// Add filters for students and offers
if (!empty($students)) {
    $query .= " AND clicks.student_id IN (" . implode(',', $students) . ")";
}
if (!empty($offers)) {
    $query .= " AND clicks.offer_id IN (" . implode(',', $offers) . ")";
}

// Handle time intervals
$interval = $request->get('interval');
if (!empty($interval)) {
    if (isset($interval['year'])) {
        array_push($groupby, "YEAR(clicks.created_at)");
    }
    if (isset($interval['month'])) {
        array_push($groupby, "MONTH(clicks.created_at)");
    }
    if (isset($interval['week'])) {
        array_push($groupby, "WEEK(clicks.created_at)");
    }
    if (isset($interval['day'])) {
        array_push($groupby, "DAY(clicks.created_at)");
    }
    if (isset($interval['hour'])) {
        array_push($groupby, "HOUR(clicks.created_at)");
    }
}

// Add the conversions.currency to the group by
if (!empty($groupby)) {
    $groupby[] = 'conversions.currency'; // Add this line
    $query .= ' GROUP BY ' . implode(',', $groupby);
}

// Execute the query
DB::enableQueryLog();
$records = DB::select($query);

// Handle report download
if ($request->has('download') && $request->get('download') === 'true') {
    $csvFileName = 'conversion_report.csv';
    $csvFilepath = public_path('downloads/' . $csvFileName);
    $handle = fopen($csvFilepath, 'w');

    // Write CSV header
    fputcsv($handle, $headers);

    // Write report data
    foreach ($records as $record) {
        fputcsv($handle, (array)$record);
    }

    fclose($handle);
    return response()->download($csvFilepath, $csvFileName)->deleteFileAfterSend();
}

// Log the query for debugging
$query_log = DB::getQueryLog();
$sql = end($query_log)['query'];

return view('admin.report.performance', compact('headers', 'records', 'sql', 'from', 'to', 'interval', 'students'));
    }
    



    public function conversion(Request $request)
    {

        /*
        * date range
        * default: current month
        */
        if ($request->has('daterange')) {
            $daterange = explode('-', $request->get('daterange'));
            $from = date('Y-m-d', strtotime(trim($daterange[0])));
            $to = date('Y-m-d', strtotime(trim($daterange[1])));
        } else {
            $from = date('Y-m-01');
            $to = date('Y-m-t');
        }
        /*
         * data array.
         * available fields: student_id, student, advertiser_id, advertiser, offer_id, offer, country, device_type, os_name, browser_name, stu_sub, stu_sub2, stu_sub3, stu_sub4, stu_sub5, goal, source
         */
        if ($request->has('data')) {
            $data = $request->get('data');
        } else {
            $data = [
                'student_id' => 1,
                'student' => 1,
                'offer_id' => 1,
                'offer' => 1,
                'goal' => 1,
                'paytm_no' => 1,
            ];
        }

        /*
         * statistics array.
         * available fields: session_ip, conversion_ip, transaction_id, currency, payout, datetime
         */
        if ($request->has('statistics')) {
            $statistics = $request->get('statistics');
        } else {
            $statistics = [
                'session_ip' => 1,
                'conversion_ip' => 1,
                'transaction_id' => 1,
                'currency' => 1,
                'revenue' => 1,
                'payout' => 1,
                'profit' => 1,
                'datetime'=>1,
            ];
        }


        /*
         * headers array.
         */
        $headers = [];

        if (!empty($data)) {
            $fields = [];
            $groupby = [];

            if (isset($data['student_id'])) {
                array_push($fields, 'users1.id as student_id');
                array_push($headers, 'Student ID');
                //if(!in_array('clicks.user_id', $groupby)) {
                //  array_push($groupby, 'click_trackers.user_id');
                // }
            }
            if (isset($data['student'])) {
                array_push($fields, 'users1.name as student');
                array_push($headers, 'Student');
                // array_push($groupby, 'users.name');
                //array_push($groupby, 'click_trackers.user_id');
            }

            if (isset($data['advertiser_id'])) {
                array_push($fields, 'users2.id as advertiser_id');
                array_push($headers, 'Advertiser ID');
                //if(!in_array('clicks.adv_id', $groupby)) {
                //array_push($groupby, 'click_trackers.adv_id');
                //}
            }
            if (isset($data['advertiser'])) {
                array_push($fields, 'users2.name as advertiser');
                array_push($headers, 'Advertiser');
                // array_push($groupby, 'users.name');
                //if(!in_array('click_trackers.adv_id', $groupby)) {
                //array_push($groupby, 'click_trackers.adv_id');
                //}
            }

            if (isset($data['offer_id'])) {
                array_push($fields, 'clicks.offer_id');
                array_push($headers, 'Offer ID');
                //array_push($groupby, 'click_trackers.offer_id');
            }
            if (isset($data['offer'])) {
                array_push($fields, 'clicks.offer_name');
                array_push($headers, 'Offer');
                //array_push($groupby, 'click_trackers.offer_name');
            }

            if (isset($data['country'])) {
                array_push($fields, 'clicks.country');
                array_push($headers, 'Country');
                //array_push($groupby, 'click_trackers.country');
            }
            if (isset($data['device'])) {
                array_push($fields, 'clicks.device_type');
                array_push($headers, 'Device');
            }
            if (isset($data['os'])) {
                array_push($fields, 'clicks.os_name');
                array_push($headers, 'Operating System');
            }
            if (isset($data['browser'])) {
                array_push($fields, 'clicks.browser_name');
                array_push($headers, 'Browser');
            }
            if (isset($data['subid1'])) {
                array_push($fields, 'clicks.stu_sub');
                array_push($headers, 'Sub ID 1');
                //array_push($groupby, 'click_trackers.stu_sub');
            }
            if (isset($data['subid2'])) {
                array_push($fields, 'clicks.stu_sub2');
                array_push($headers, 'Sub ID 2');
                //array_push($groupby, 'click_trackers.stu_sub2');
            }
            if (isset($data['subid3'])) {
                array_push($fields, 'clicks.stu_sub3');
                array_push($headers, 'Sub ID 3');
                //array_push($groupby, 'click_trackers.stu_sub3');
            }
            if (isset($data['subid4'])) {
                array_push($fields, 'clicks.stu_sub4');
                array_push($headers, 'Sub ID 4');
                //array_push($groupby, 'click_trackers.stu_sub4');
            }
            if (isset($data['subid5'])) {
                array_push($fields, 'clicks.stu_sub5');
                array_push($headers, 'Sub ID 5');
                //array_push($groupby, 'click_trackers.stu_sub5');
            }
            if (isset($data['goal'])) {
                array_push($fields, 'conversions.name');
                array_push($headers, 'Goal Name');
            }
            if (isset($data['paytm_no'])) {
                array_push($fields, 'clicks.paytm_no');
                array_push($headers, 'Paytm No');
            }
        } else {
            return back()->withErrors(['error' => "You didn't select anything"]);
        }
        $query = "SELECT " . implode(', ', $fields) . " ";

        if (!empty($statistics)) {
            if (isset($statistics['session_ip'])) {
                $query .= ", clicks.ip_address as Session";
                array_push($headers, 'Session IP');
            }
            if (isset($statistics['conversion_ip'])) {
                $query .= ", conversions.conversion_ip as Conversion";
                array_push($headers, 'Conversion IP');
            }
            if (isset($statistics['transaction_id'])) {
                $query .= ", clicks.transaction_id as transaction";
                array_push($headers, 'Transaction ID');
            }
            if (isset($statistics['currency'])) {
                $query .= ", conversions.currency as Currency ";
                array_push($headers, 'Currency');
            }
            if (isset($statistics['payout'])) {
                $query .= ", conversions.payout as Payout ";
                array_push($headers, 'Payout');
            }
            if (isset($statistics['revenue'])) {
                $query .= ", conversions.revenue as Revenue ";
                array_push($headers, 'Revenue');
            }
            if (isset($statistics['profit'])) {
                $query .= ", conversions.revenue - conversions.payout as Profit ";
                array_push($headers, 'Profit');
            }
            if (isset($statistics['datetime'])) {
                $query .= ", conversions.created_at as DateTime ";
                array_push($headers, 'DateTime');
            }
        }

        $calculations = $request->get('calculations');
        if (!empty($calculations)) {
            $clicks = Click::count();
            if (isset($calculations['cr'])) {
                if ($clicks != 0) {
                    $query .= ", SUM(IF(conversions.status = 1, clicks.id, 0 )) / $clicks * 100  as CR ";
                    array_push($headers, 'CR');
                } else {
                    $query .= ", 0 as CR";
                    array_push($headers, 'CR');
                }
            }

            if (isset($calculations['cpc'])) {
                $clicks = Click::count();
                if ($clicks != 0) {
                    $query .= ", SUM(IF(conversions.status = 'approved', conversions.payout, 0)) / $clicks as CPC ";
                } else {
                    $query .= ", 0 as CPC";
                }
                array_push($headers, 'CPC');
            }

            if (isset($calculations['rpc'])) {
                $clicks = Click::count();
                if ($clicks != 0) {
                    $query .= ", SUM(IF(conversions.status = 'approved', conversions.revenue, 0)) / $clicks as RPC ";
                } else {
                    $query .= ", 0 as RPC";
                }
                array_push($headers, 'RPC');
            }
        }

        // if (in_array('clicks.advertiser_id', $fields) || in_array('users.name as advertiser', $fields)) {
        //     $query .= " FROM clicks JOIN users ON clicks.advertiser_id = users.id LEFT JOIN conversions ON clicks.transaction_id = conversions.click_transaction_id ";
        // } else {
        //     $query .= " FROM clicks JOIN users ON clicks.student_id = users.id LEFT JOIN conversions ON clicks.transaction_id = conversions.click_transaction_id ";
        // }

        $query .= " FROM clicks JOIN users as users1 ON users1.id =clicks.student_id JOIN users as users2 ON users2.id =clicks.advertiser_id LEFT JOIN conversions ON clicks.transaction_id = conversions.click_transaction_id ";
        $query .= " WHERE conversions.status IN('approved', 'pending') AND date(conversions.created_at) BETWEEN '$from' AND '$to' ORDER BY conversions.id DESC";


        // Time interval
        $interval = $request->get('interval');
        if (!empty($interval)) {

            if (isset($interval['year'])) {
                array_push($groupby, "YEAR(conversions.created_at)");
            }
            if (isset($interval['month'])) {
                array_push($groupby, "MONTH(conversions.created_at)");
            }
            if (isset($interval['week'])) {
                array_push($groupby, "WEEK(conversions.created_at)");
            }
            if (isset($interval['day'])) {
                array_push($groupby, "DAY(conversions.created_at)");
            }
            if (isset($interval['hour'])) {
                array_push($groupby, "HOUR(conversions.created_at)");
            }
        } else {
            $interval = [];
        }
        // array_unshift($groupby,"DAY('clicks.created_at')");
        if (!empty($groupby)) {
            $query .= 'GROUP BY ' . implode(',', $groupby);
        }
        DB::enableQueryLog();
        $records = DB::select($query);
        $perPage = 10; // Number of records to display per page
        //$records = $query->paginate($perPage);
        // to download report 
        if ($request->has('download') && $request->get('download') === 'true') {
            // Generate and download the report
           $csvFileName = 'conversion_report.csv';
            $csvFilepath = public_path('downloads/' . $csvFileName);
        
            $handle = fopen($csvFilepath, 'w');
        
            // Write the CSV header row
            fputcsv($handle, $headers);
        
            // Write the report data
            foreach ($records as $record) {
                fputcsv($handle, (array)$record);
            }
        
            fclose($handle);
        
            // Download the CSV file
            return response()->download($csvFilepath, $csvFileName)->deleteFileAfterSend();

        }


        $query_log = DB::getQueryLog();

        $sql = end($query_log)['query'];
        return view('admin.report.conversions', compact('headers', 'records', 'sql', 'from', 'to', 'interval'));
    }



    public function conversion_log(Request $request)
    {
        $perPage = $request->get('perPage') ? $request->get('perPage') : 20;

        $conversions = Conversion::when($request->filled('students'), function ($query) use ($request) {
            return $query->whereIn('student_id', $request->input('students'));
        })
            ->when($request->filled('offers'), function ($query2) use ($request) {
                return $query2->whereIn('offer_id', $request->input('offers'));
            })
            ->where('click_transaction_id', 'like', '%' . $request->click_data . '%')
            ->orderBy('id', 'desc')->simplePaginate($perPage);
     
        // to download report 
        if ($request->has('download') && $request->get('download') === 'true') {
            // Generate and download the report
           $csvFileName = 'conversion_log.csv';
            $csvFilepath = public_path('downloads/' . $csvFileName);
        
            $handle = fopen($csvFilepath, 'w');
             $headers=['ID','Student','Offer','Advertiser','Event','Status','Conversion IP','Transaction ID','Revenue','Payout','Profit','Created At'];
            // Write the CSV header row
            fputcsv($handle, $headers);
        
            // Write the report data
            foreach ($conversions as $conversion) {
                $conversionData = [
                    $conversion->id,
                    $conversion->student->name,
                    $conversion->offer->name,
                    $conversion->advertiser->name,
                    $conversion->name,
                    $conversion->status,
                    $conversion->conversion_ip,
                    $conversion->click_transaction_id,
                    $conversion->revenue.' '.($conversion->currency),
                    $conversion->payout.' '. $conversion->currency ,
                    $conversion->revenue -$conversion->payout.' '.$conversion->currency,
                    $conversion->created_at
                ];
                  fputcsv($handle,$conversionData);
            }
            fclose($handle);
        
            // Download the CSV file
            return response()->download($csvFilepath, $csvFileName)->deleteFileAfterSend();

        }        

        return view('admin.report.conversion_log', compact('conversions'));
    }



    public function click_log(Request $request)
    {
        //return $request->all();
        $perPage = $request->get('perPage') ? $request->get('perPage') : 20;

        $clicks = Click::withCount('conversions')
            ->when($request->filled('students'), function ($query) use ($request) {
                return $query->whereIn('student_id', $request->input('students'));
            })
            ->when($request->filled('offers'), function ($query2) use ($request) {
                return $query2->whereIn('offer_id', $request->input('offers'));
            })
            ->where('transaction_id', 'like', '%' . $request->click_data . '%')
            ->orderBy('id', 'desc')->simplePaginate($perPage);
        // return $clicks;

        
        
        // to download report 
        if ($request->has('download') && $request->get('download') === 'true') {
            // Generate and download the report
           $csvFileName = 'click_log.csv';
            $csvFilepath = public_path('downloads/' . $csvFileName);
        
            $handle = fopen($csvFilepath, 'w');
            $headers=['ID','Ip Address','Transaction ID','Conversion Count','Country','Device Type','Os name','Os Version','Browser Name','Browser Version','Created At'];
        
            // Write the CSV header row
            fputcsv($handle, $headers);
        
            // Write the report data
            foreach ($clicks as $click) {
                 $clickData = [
                    $click->id,
                    $click->ip_address,
                    $click->transaction_id,
                    $click->conversions_count,
                    $click->country,
                    $click->device_type,
                    $click->os_name,
                    $click->os_version,
                    $click->browser_name,
                    $click->browser_version,
                    $click->created_at
                ];
                  fputcsv($handle,$clickData);
            }
          
            fclose($handle);
            // Download the CSV file
            return response()->download($csvFilepath, $csvFileName)->deleteFileAfterSend();

        }

        return view('admin.report.click_log', compact('clicks'));
    }

    public function conversion_update(Request $request, $id)
    {
        $conversion = Conversion::find($id);
        $conversion->status = $request->status;
        $conversion->update();

        Toastr::success('Conversion status updated successfully', 'Success');
        return 'success';
    }

    public function click_to_conversion($id)
    {
        $click = Click::find($id);
        $convert = Http::get(asset('/track?click_id=' . $click->transaction_id));
        $check = str_contains($convert->body(), 'success');

        if ($check) {

            Toastr::success('Click recored as conversions', 'Success');
            return redirect()->back();
        } else {
            Toastr::error('Click not recored as conversions', 'Error');
            return redirect()->back();
        }
    }
}
