<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Imports\ConversionImport; 
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Click;
use App\Models\Conversion;
use App\Models\Offer;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Yajra\DataTables\Facades\DataTables;

class ImportConversionController extends Controller
{
    
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Conversion::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('student', function (Conversion $conversion) {
                    $studentName = $conversion->student ? $conversion->student->name : 'N/A'; // Fallback to 'N/A'
                    $studentLink = '<a title="' . $conversion->student_id . '" style="text-decoration:none" href="' . route('employee.student.show', $conversion->student_id) . '">' . $studentName . '</a>';
                    return $studentLink;
                })
                
                ->editColumn('offer', function (Conversion $conversion) {
                    $offerName = $conversion->offer ? $conversion->offer->name : 'N/A'; // Fallback to 'N/A'
                    $offerLink = '<a title="' . $conversion->offer_id . '" style="text-decoration:none" href="' . route('employee.offer.show', $conversion->offer_id) . '">' . $offerName . '</a>';
                    return $offerLink;
                })
                 
                ->addColumn('event', function (Conversion $Conversion) {
                    return $Conversion->name;
                })
                ->addColumn('status', function (Conversion $Conversion) {
                  return $Conversion->status;
                })
                ->addColumn('conversionip', function (Conversion $Conversion) {
                  return $Conversion->conversion_ip;
                })
                 ->addColumn('transactionid', function (Conversion $Conversion){
                  return $Conversion->click_transaction_id;
                })
                ->addColumn('created_at', function (Conversion $Conversion) {
                    return $Conversion->created_at;
                })

                ->rawColumns(['student','offer','event','status','conversionip','transactionid','created_at'])
                ->make(true);
        }
        return view('employee.conversion.index');
    }
    
    public function import(Request $request)
    {
        // Get the IP address of the system
        $ipAddress = $request->ip();
    
        $request->validate([
         'file' => 'required|mimes:xlsx, xls']);
        if(request()->hasFile('file')) {
            Excel::import(new ConversionImport($ipAddress), request()->file('file')->store('temp'));
        }
    return redirect()->back()->with('success', 'Conversion logs imported successfully');
    }
    
    


}
