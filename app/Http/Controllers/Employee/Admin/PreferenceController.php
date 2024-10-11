<?php

namespace App\Http\Controllers\Employee\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentOption;
use App\Models\SignupQuestion;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Yajra\DataTables\Facades\DataTables;

class PreferenceController extends Controller
{
    public function company()
    {
        return view('admin.preference.company');
    }

    public function mail()
    {
        return view('admin.preference.mail');
    }

    public function companyUpdate(Request $request)
    {
        $inputs = Arr::except($request->input(), ['_token']);
        $path = base_path('.env');
        foreach ($inputs as $key => $value) {
            if (file_exists($path)) {

                file_put_contents($path, str_replace(
                    $key . '=' . env($key),
                    $key . '=' . $value,
                    file_get_contents($path)
                ));
            }
        }

        Toastr::success('Update', 'Success');
        return redirect()->back();
        // $key = $request->app_timezone;



        //config(['app.timezone' => $request->app_timezone]);
    }

    public function additional_question()
    {
        $questions = SignupQuestion::all();
        return view('admin.preference.student_question', compact('questions'));
    }

    public function additional_question_store(Request $request)
    {
        $inputs = Arr::except($request->input(), ['_token']);
        //$inputs['for'] = 'student';
        SignupQuestion::create($inputs);
        Toastr::success('Question Added', 'Success');
        return redirect()->back();
    }

    public function additional_question_delete($id)
    {
        SignupQuestion::find($id)->delete();
        Toastr::success('Question Deleted', 'Success');
        return redirect()->back();
    }
}
