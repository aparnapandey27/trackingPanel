<?php

namespace App\Http\Controllers\Employee\Admin;

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
                ->editColumn('student', function (Conversion $Conversion) {
                    $student = '<a title="' . $Conversion->student_id . '" style="text-decoration:none" href="' . route('admin.students.manage', $Conversion->student_id) . '">' . $Conversion->student->name . '</a>';

                    return $student;
                })
                 ->editColumn('offer', function (Conversion $Conversion) {
                    $offer = '<a title="' . $Conversion->offer_id . '" style="text-decoration:none" href="' . route('admin.offers.show', $Conversion->offer_id) . '">' . $Conversion->offer->name . '</a>';

                    return $offer;
                })
                 ->editColumn('advertiser', function (Conversion $Conversion) {
                    $advertiser = '<a title="' . $Conversion->advertiser_id . '" style="text-decoration:none" href="' . route('admin.advertisers.manage', $Conversion->advertiser_id) . '">' . $Conversion->advertiser->name . '</a>';

                    return $advertiser;
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
