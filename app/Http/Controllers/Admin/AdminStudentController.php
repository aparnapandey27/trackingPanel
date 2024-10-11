<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\StudentImport;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Click;
use App\Models\Payment;
use Flasher\Laravel\Facade\Flasher;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

class AdminStudentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $students = User::select(['id', 'name', 'college', 'email', 'phone', 'address', 'status']);
            return DataTables::of($students)
                ->addColumn('actions', function($student) {
                    return view('admin.students.partials.actions', compact('student'))->render();
                })
                ->make(true);
        }

        return view('admin.students.manage', ['students' => collect()]);
    }

    public function create()
    {
        return view('admin.students.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'college' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'zipcode' => 'nullable|string|max:20',
            'status' => 'required|string|in:0,1',
        ]);

        try {
            User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'college' => $validatedData['college'],
                'phone' => $validatedData['phone'],
                'address' => $validatedData['address'],
                'zipcode' => $validatedData['zipcode'] ?? null,
                'password' => Hash::make('12345678'),
                'role' => 'student',
                'status' => $validatedData['status'],
            ]);

            return redirect()->route('admin.students.manage')->with('success', 'Student added successfully!');
        } catch (\Exception $e) {
            Log::error('Error saving student: ' . $e->getMessage(), [
                'request_data' => $request->except('password')
            ]);

            return redirect()->back()->with('error', 'There was an error adding the student. Please try again.');
        }
    }

    public function manage()
    {
        $students = User::where('role', 'student')->get()->map(function($student) {
            $statusBadges = [
                1 => '<span class="badge bg-success-subtle text-success text-uppercase">Active</span>',
                2 => '<span class="badge bg-danger-subtle text-danger text-uppercase">Rejected</span>',
                3 => '<span class="badge bg-danger-subtle text-danger text-uppercase">Closed</span>',
                0 => '<span class="badge bg-warning-subtle text-warning text-uppercase">Pending</span>',
            ];
            $student->status_badge = $statusBadges[$student->status] ?? $statusBadges[0];
            return $student;
        });

        return view('admin.students.manage', compact('students'));
    }

    public function updateStatus($id, $status)
    {
        try {
            $student = User::findOrFail($id);
            $student->status = $status;
            $student->save();

            if (request()->expectsJson()) {
                return response()->json(['success' => true]);
            }

            return redirect()->route('admin.students.manage')->with('success', 'Student status updated successfully.');
        } catch (\Exception $e) {
            Log::error('Error updating student status: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Something went wrong. Please try again.'], 500);
        }
    }

    public function confirm($id)
    {
        return $this->updateStatus($id, 1);
    }

    public function reject($id)
    {
        return $this->updateStatus($id, 0);
    }

    public function disable($id)
    {
        return $this->updateStatus($id, 0);
    }

    public function edit($id)
    {
        $student = User::findOrFail($id);
        return view('admin.students.edit', compact('student'));
    }

    public function destroy($id)
    {
        try {
            $student = User::findOrFail($id);
            $student->delete();
            return redirect()->route('admin.students.manage')->with('success', 'Student deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Error deleting student: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong. Please try again.');
        }
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:100',
            'status' => 'required|string|in:0,1',
        ]);

        try {
            $student = User::findOrFail($id);
            $student->fill($validatedData)->save();

            return redirect()->route('admin.students.manage')->with('success', 'Student updated successfully.');
        } catch (\Exception $e) {
            Log::error('Error updating student: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong. Please try again.');
        }
    }

    public function show(Request $request, $id)
{
    // Find the student (or student)
    $student = User::find($id);

    // Handle the case where the student is not found
    if (!$student) {
        return redirect()->back()->withErrors('Student not found');
    }

    // Handle the date range
    if ($request->post()) {
        $daterange = explode('-', $request->get('daterange'));
        $from = date('Y-m-d', strtotime(trim($daterange[0])));
        $to = date('Y-m-d', strtotime(trim($daterange[1])));
    } else {
        $from = \Carbon\Carbon::today()->subDays(6)->format('Y-m-d');
        $to = \Carbon\Carbon::today()->format('Y-m-d');
    }

    // Fetch reports related to the student (or student)
    $reports = Click::select(DB::raw('clicks.offer_id as Oid, clicks.offer_name as Offer, COUNT(clicks.id) as Clicks , SUM(IF(conversions.status = ("approved" or "pending"), 1, 0)) as Leads, SUM(IF(conversions.status = "approved", conversions.payout, 0)) as Payout, SUM(IF(conversions.status = "approved", conversions.revenue, 0)) as Revenue, SUM(IF(conversions.status = \'approved\', conversions.revenue, 0)) - SUM(IF(conversions.status = "approved", conversions.payout, 0)) as Profit'))
        ->leftJoin('conversions', 'clicks.transaction_id', '=', 'conversions.click_transaction_id')
        ->groupBy(DB::raw("clicks.offer_id"))
        ->where('clicks.student_id', $student->id)  // Updated to match the variable name
        ->whereBetween('clicks.created_at', [$from, $to])
        ->paginate(10);

    // Fetch payments related to the student (or student)
    $payments = Payment::where('student_id', $student->id)->orderBy('id', 'desc')->get();

    // Return the view with the student and associated data
    return view('admin.students.show', compact('student', 'reports', 'to', 'from', 'payments'));
}



    public function showSignupForm()
    {
        return view('auth.register');
    }

    public function signup(Request $request)
    {
        $validatedData = $request->validate([
            'college' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:8',
            'address' => 'nullable|string|max:255',
            'status' => 'required|in:0,1',
            'role' => 'required|string|in:student,admin',
        ]);

        try {
            $student = User::create([
                'college' => $validatedData['college'],
                'name' => $validatedData['name'],
                'phone' => $validatedData['phone'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
                'address' => $validatedData['address'] ?? null,
                'role' => $validatedData['role'],
                'status' => $validatedData['status'],
            ]);

            auth()->login($student);

            if ($student->role === 'admin') {
                return redirect()->route('admin.dashboard')->with('success', 'Registration successful!');
            } else {
                return redirect()->route('dashboard')->with('success', 'Registration successful!');
            }

        } catch (\Exception $e) {
            Log::error('Error during signup: ' . $e->getMessage());
            return redirect()->back()->with('error', 'There was an error during registration. Please try again.');
        }
    }



    public function updateManager(Request $request, $id)
    {
        try {
            $student = User::findOrFail($id);
            $student->manager_id = $request->input('manager');
            $student->save();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error('Error updating manager: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Something went wrong. Please try again.'], 500);
        }
    }

    public function payment_frequency(Request $request, $id)
    {
        $student = User::find($id);
        $student->payment_frequency = $request->payment_frequency;
        $student->update();
        Flasher::success('Payment frequency Updated', 'Success');
        return redirect()->back();
    }
    
    public function import(Request $request)
    {
        $request->validate([
         'file' => 'required|mimes:xlsx, xls']);
        if(request()->hasFile('file')) {
            Excel::import(new StudentImport, request()->file('file')->store('temp'));
        }
    return redirect()->back()->with('success', 'Import completed.');;
    }
}
