<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\DataTables;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $students = User::select(['id', 'name', 'college', 'email', 'phone', 'address', 'status'])
                            ->where('role', 'student'); // Filter to get only students

            return DataTables::of($students)
                ->addColumn('actions', function($student) {
                    return view('students.partials.actions', compact('student'))->render();
                })
                ->make(true);
        }

        return view('students.manage');
    }

    public function create()
    {
        return view('students.create');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'college' => 'required|string|max:255',
                'phone' => 'required|string|max:20',
                'address' => 'required|string|max:255',
                'zipcode' => 'sometimes|nullable|string|max:20',
                'country' => 'required|string|max:255', 
                'status' => 'required|string|in:active,inactive,pending',
            ]);

            $status = $request->input('status', 'pending');

            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'college' => $request->college,
                'phone' => $request->phone,
                'address' => $request->address,
                'zipcode' => $request->zipcode,
                'country' => $request->country,
                'password' => Hash::make('12345678'),
                'role' => 'student',
                'status' => $status, // Set default if not provided
            ]);

            return redirect()->route('students.manage')->with('success', 'Student added successfully!');
        } catch (\Exception $e) {
            Log::error('Error saving student: ' . $e->getMessage(), [
                'request_data' => $request->except('password')
            ]);

            return redirect()->back()->with('error', 'There was an error adding the student. Please try again.');
        }
    }

    public function manage()
    {
        $students = User::where('role', 'student')->get();
        return view('students.manage', compact('students'));
    }

    public function confirm($id)
    {
        try {
            $student = User::findOrFail($id);
            $student->status = 'active'; // Use a more descriptive status
            $student->save();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error('Error confirming student: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Something went wrong. Please try again.'], 500);
        }
    }

    public function reject($id)
    {
        try {
            $student = User::findOrFail($id);
            $student->status = 'inactive'; // Use more descriptive status
            $student->save();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error('Error rejecting student ID ' . $id . ': ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Something went wrong. Please try again.'], 500);
        }
    }

    public function disable($id)
    {
        try {
            $student = User::findOrFail($id);
            $student->status = 'inactive';
            $student->save();

            return redirect()->route('students.index')->with('success', 'Student disabled successfully.');
        } catch (\Exception $e) {
            Log::error('Error disabling student ID ' . $id . ': ' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong. Please try again.');
        }
    }

    public function edit($id)
    {
        $student = User::findOrFail($id);
        return view('students.edit', compact('student'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:100',
            'status' => 'required|string|in:active,inactive,pending',
        ]);

        $student = User::findOrFail($id);
        $student->name = $request->name;
        $student->email = $request->email;
        $student->phone = $request->phone;
        $student->address = $request->address;
        $student->status = $request->status;
        $student->save();

        return redirect()->route('students.manage')->with('success', 'Student updated successfully.');
    }

    public function destroy($id)
    {
        try {
            $student = User::findOrFail($id);
            $student->delete();
            Session::flash('success', 'Student deleted successfully.');
            return redirect()->route('students.index');
        } catch (\Exception $e) {
            Log::error('Error deleting student: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong. Please try again.');
        }
    }

    public function show($id)
    {
        $student = User::findOrFail($id);
        return view('students.show', compact('student'));
    }

    public function updateManager(Request $request, $id)
    {
        $request->validate([
            'manager_id' => 'required|exists:users,id',
        ]);

        $student = User::findOrFail($id);
        $student->manager_id = $request->manager_id;
        $student->save();

        return redirect()->route('students.manage')->with('success', 'Manager assigned successfully.');
    }

    public function showSignupForm()
    {
        return view('auth.register'); // Ensure this path is correct
    }

    public function signup(Request $request)
    {
        // Validate the request
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

        // Create the student user
        $student = User::create([
            'college' => $request->college,
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'address' => $request->address,
            'role' => 'student',
            'status' => $request->status,
        ]);

        // Optionally log the user in after registration
        auth()->login($student);

        // Redirect to the dashboard or another page
        return redirect()->route('dashboard')->with('success', 'Registration successful!');
    }

    
}

