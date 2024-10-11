<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Imports\ConversionImport; 
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Click;
use App\Models\User;
use App\Models\Conversion;
use App\Models\Offer;

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
                    $studentLink = '<a title="' . $conversion->student_id . '" style="text-decoration:none" href="' . route('admin.students.manage', $conversion->student_id) . '">' . $studentName . '</a>';
                    return $studentLink;
                })
                
                ->editColumn('offer', function (Conversion $conversion) {
                    $offerName = $conversion->offer ? $conversion->offer->name : 'N/A'; // Fallback to 'N/A'
                    $offerLink = '<a title="' . $conversion->offer_id . '" style="text-decoration:none" href="' . route('admin.offers.show', $conversion->offer_id) . '">' . $offerName . '</a>';
                    return $offerLink;
                })
                
                ->editColumn('advertiser', function (Conversion $conversion) {
                    $advertiserName = $conversion->advertiser ? $conversion->advertiser->name : 'N/A'; // Fallback to 'N/A'
                    $advertiserId = $conversion->advertiser_id; // Get the advertiser_id for debugging
                    $advertiserLink = '<a title="' . $advertiserId . '" style="text-decoration:none" href="' . route('admin.advertisers.manage', $advertiserId) . '">' . $advertiserName . '</a>';
                    return $advertiserLink;
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

                ->rawColumns(['student','offer','advertiser','event','status','conversionip','transactionid','created_at'])
                ->make(true);
        }
        return view('admin.conversion.index');
    }
    
    public function import(Request $request)
    {
        // Get the IP address of the system
        $ipAddress = $request->ip();
    
        $request->validate([
         'file' => 'required|mimes:xlsx, xls']);
        if(request()->hasFile('file')) {
            Excel::import(new ConversionImport($ipAddress), request()->file('file')->store('temp'));
            
            //delete temp file after import conversion
            $filePath = request()->file('file')->getRealPath();
            File::delete($filePath);
        }
    return redirect()->back()->with('success', 'Conversion logs imported successfully');
    }
}
