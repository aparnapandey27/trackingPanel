<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Click;
use App\Models\Conversion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function performance(Request $request)
{
    // Logged user ID
    $user_id = Auth::id();

    // Date range: Default to current month
    if ($request->has('daterange')) {
        $daterange = explode('-', $request->get('daterange'));
        $from = date('Y-m-d', strtotime(trim($daterange[0])));
        $to = date('Y-m-d', strtotime(trim($daterange[1])));
    } else {
        $from = date('Y-m-01');
        $to = date('Y-m-t');
    }

    // Data array for selected fields
    $data = $request->has('data') ? $request->get('data') : [
        'student_id' => 1,
        'student' => 1,
        'offer_id' => 1,
        'offer' => 1,
    ];

    // Statistics array for selected statistics
    $statistics = $request->has('statistics') ? $request->get('statistics') : [
        'clicks' => 1,
        'conversions' => 1,
        'payout' => 1,
    ];

    $headers = [];
    $fields = [];
    $groupby = [];

    // Constructing fields and group by
    if (isset($data['student_id'])) {
        $fields[] = 'clicks.student_id';
        $headers[] = 'Student ID';
        $groupby[] = 'clicks.student_id';
    }
    if (isset($data['student'])) {
        $fields[] = 'users.name as student';
        $headers[] = 'Student';
        $groupby[] = 'users.name';
    }
    if (isset($data['offer_id'])) {
        $fields[] = 'clicks.offer_id';
        $headers[] = 'Offer ID';
        $groupby[] = 'clicks.offer_id';
    }
    if (isset($data['offer'])) {
        $fields[] = 'clicks.offer_name';
        $headers[] = 'Offer';
        $groupby[] = 'clicks.offer_name';
    }

    // Adding statistics to the fields and headers
    if (!empty($statistics)) {
        if (isset($statistics['clicks'])) {
            $fields[] = "COUNT(clicks.id) as Clicks";
            $headers[] = 'Clicks';
        }
        if (isset($statistics['conversions'])) {
            $fields[] = "SUM(IF(conversions.status IN ('approved', 'pending'), 1, 0)) as Conversions";
            $headers[] = 'Conversions';
        }
        if (isset($statistics['currency'])) {
            $fields[] = 'conversions.currency as Currency';
            $groupby[] = 'conversions.currency';
            $headers[] = 'Currency';
        }
        if (isset($statistics['payout'])) {
            $fields[] = "FORMAT(SUM(IF(conversions.status = 'approved', conversions.payout, 0)), 2) as Payout";
            $headers[] = 'Payout';
        }
    }

    // Constructing the query
    $query = "SELECT " . implode(', ', $fields) . " 
              FROM clicks 
              JOIN users ON clicks.student_id = users.id 
              LEFT JOIN conversions ON clicks.transaction_id = conversions.click_transaction_id 
              WHERE clicks.manager_id = '$user_id' 
              AND date(clicks.created_at) BETWEEN '$from' AND '$to' ";

    // Adding GROUP BY clause
    if (!empty($groupby)) {
        $query .= 'GROUP BY ' . implode(',', $groupby);
    }

    // Execute the query
    DB::enableQueryLog();
    $records = DB::select($query);
    
    // Check if download request is made
    if ($request->has('download') && $request->get('download') === 'true') {
        // Generate and download the report
        $csvFileName = 'performance_report.csv';
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

    return view('employee.report.performance', compact('headers', 'records', 'sql', 'from', 'to'));
}





    public function conversion(Request $request)
    {
        /*
        *logged user id
        */
        $user_id = Auth::id();

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
                'payout' => 1,
                'datetime',
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
                array_push($fields, 'clicks.student_id');
                array_push($headers, 'Student ID');
                //if(!in_array('clicks.user_id', $groupby)) {
                //  array_push($groupby, 'click_trackers.user_id');
                // }
            }
            if (isset($data['student'])) {
                array_push($fields, 'users.name as student');
                array_push($headers, 'Student');
                // array_push($groupby, 'users.name');
                //array_push($groupby, 'click_trackers.user_id');
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

            if (isset($data['advertiser_id'])) {
                array_push($fields, 'clicks.advertiser_id');
                array_push($headers, 'Advertiser ID');
                //if(!in_array('clicks.adv_id', $groupby)) {
                //array_push($groupby, 'click_trackers.adv_id');
                //}
            }
            if (isset($data['advertiser'])) {
                array_push($fields, 'users.name as advertiser');
                array_push($headers, 'Advertiser');
                // array_push($groupby, 'users.name');
                //if(!in_array('click_trackers.adv_id', $groupby)) {
                //array_push($groupby, 'click_trackers.adv_id');
                //}
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
            if (isset($statistics['datetime'])) {
                $query .= ", conversions.updated_at as DateTime ";
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

        if (in_array('clicks.advertiser_id', $fields) || in_array('users.name as advertiser', $fields)) {
            $query .= " FROM clicks JOIN users ON clicks.advertiser_id = users.id LEFT JOIN conversions ON clicks.transaction_id = conversions.click_transaction_id ";
        } else {
            $query .= " FROM clicks JOIN users ON clicks.student_id = users.id LEFT JOIN conversions ON clicks.transaction_id = conversions.click_transaction_id ";
        }

        $query .= " WHERE clicks.manager_id = '$user_id'  AND conversions.status = ('approved' or 'pending') AND date(conversions.created_at) BETWEEN '$from' AND '$to' ";


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
        return view('employee.report.conversions', compact('headers', 'records', 'sql', 'from', 'to', 'interval'));
    }
}
