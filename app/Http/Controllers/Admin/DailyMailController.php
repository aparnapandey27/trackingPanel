<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Conversion;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use App\Mail\DailyReportMail;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\File;

class DailyMailController extends Controller
{
    public function index(){
        $logFilePath = storage_path('logs/mail.log'); // Path to the log file
            
            $logs = File::get($logFilePath); // Read log file content
            
            // Split logs into an array by newlines for display
            $logs = explode("\n", $logs);
        return view('admin.dailyMail.index', ['logs' => $logs]);
    }
    public function sendConversionReportToStudents(Request $request)
    {
        if ($request->has('daterange')) {
            $daterange = explode('-', $request->get('daterange'));
            $from = date('Y-m-d', strtotime(trim($daterange[0])));
            $to = date('Y-m-d', strtotime(trim($daterange[1])) + 86400);
        } else {
            $from = date('Y-m-01');
            $to = date('Y-m-t');
        }
        $selectedStudents = $request->input('students', []);
        $selectedOffers = $request->input('offers', []);
        
    
        $students = User::student()
                        ->where('status', 1)
                        ->when(!empty($selectedStudents), function ($query) use ($selectedStudents) {
                            return $query->whereIn('id', $selectedStudents);
                        })
                        ->get();
        $errorStudents = [];
        
        foreach ($students as $student) {
            try {
                $conversions = $student->conversions()
                    ->with('offer')
                    ->when(!empty($selectedOffers), function ($query) use ($selectedOffers) {
                        return $query->whereIn('offer_id', $selectedOffers);
                    })
                    ->whereRaw("DATE(created_at) BETWEEN ? AND ?", [$from, $to])
                    ->get();
                if ($conversions->isEmpty()) {
                    // If no data available for an student, add it to the error list
                    Log::channel('customlog')->info('No data found for student ' . $student->name);
                    continue; // Skip sending email for this student
                }
                
                $formattedConversions = $conversions->map(function ($conversion) {
                    return [
                        'Offer Name' => $conversion->offer->name ?? '',
                        'Click Transaction ID' => $conversion->click_transaction_id,
                        'Created At' => $conversion->created_at->format('Y-m-d H:i:s'),
                    ];
                });
                

                $excelFileName = 'conversion_report_' . $student->id . '.xlsx';

                // Generate the Excel file
                Excel::store(new class($formattedConversions) implements FromCollection, WithHeadings {
                    private $data;
        
                    public function __construct($data)
                    {
                        $this->data = $data;
                    }
        
                    public function collection()
                    {
                        return $this->data;
                    }
        
                    public function headings(): array
                    {
                        return [
                            'Offer Name',
                            'Click Transaction ID',
                            'Created At',
                        ];
                    }
                }, $excelFileName);
        
                // Path to the generated Excel report
                $reportPath = storage_path('app/' . $excelFileName);

                Mail::to($student->email)
                    ->send(new DailyReportMail($reportPath));

                // Remove the file after sending the email
                unlink($reportPath);

            } catch (\Exception $e) {
                Log::error("Email sending failed for student ID: $student->id. Error: " . $e->getMessage());
            }
        }
        Toastr::success('Reports sent successfully to selected students and offers', 'Success');
        return redirect()->back();

    }
    
    
    public function clearLogs(Request $request)
    {
        try {
            $logFilePath = storage_path('logs/mail.log'); // Path to the log file
            
            if (File::exists($logFilePath)) {
                File::put($logFilePath, ''); // Clear the log file by emptying it
            }
            
            return redirect()->back()->with('success', 'Logs cleared successfully.');
        } catch (\Exception $e) {
            \Log::error('Exception occurred while clearing logs: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while clearing logs.');
        }
    }
}




