<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class AdminEmployeeController extends Controller
{
    public function index()
    {
        return view('admin.employees.index');
    }

    public function create()
    {
        return view('admin.employees.create');
    }

    public function store(Request $request)
    {

        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'phone' => 'required|string|max:20',
                'address' => 'required|string|max:255',
                'zipcode' => 'sometimes|nullable|string|max:20',
                'status' => 'required|string|in:0,1',
            ]);
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'zipcode' => $request->zipcode,
                'password' => Hash::make('12345678'),
                'role' => 'employee',
                'status' => $request->status,
            ]);

            return redirect()->route('admin.employees.manage');
        } catch (\Exception $e) {
            Log::error('Error saving employee: ' . $e->getMessage());

            return redirect()->back()->with('error', 'There was an error adding the employee. Please try again.');
        }
    }

    public function manage()
{
    $employees = User::where('role', 'employee')->get();

    // Adding status badge HTML
    foreach ($employees as $employee) {
        if ($employee->status == 1) {
            $employee->status_badge = '<span class="badge bg-success-subtle text-success text-uppercase">Active</span>';
        } elseif ($employee->status == 2) {
            $employee->status_badge = '<span class="badge bg-danger-subtle text-danger text-uppercase">Rejected</span>';
        } elseif ($employee->status == 3) {
            $employee->status_badge = '<span class="badge bg-danger-subtle text-danger text-uppercase">Closed</span>';
        } else {
            $employee->status_badge = '<span class="badge bg-warning-subtle text-warning text-uppercase">Pending</span>';
        }
    }

    return view('admin.employees.manage', compact('employees'));
}

    public function confirm($id)
{
    try {
        $employee = User::findOrFail($id);
        $employee->status = 1;
        $employee->save();

        return response()->json(['success' => true]);
    } catch (\Exception $e) {
        Log::error('Error confirming employee: ' . $e->getMessage());
        return response()->json(['success' => false, 'message' => 'Something went wrong. Please try again.'], 500);
    }
}

    public function disable($id)
{
    try {
        $employee = User::findOrFail($id);
        $employee->status = 0;
        $employee->save();

        return redirect()->route('employees.index');
    } catch (\Exception $e) {
        Log::error('Error disabling employee ID ' . $id . ': ' . $e->getMessage());
        return redirect()->back()->with('error', 'Something went wrong. Please try again.');
    }
}

    public function reject($id)
{
    try {
        $employee = User::findOrFail($id);
        $employee->status = 0;
        $employee->save();

        return response()->json(['success' => true]);
    } catch (\Exception $e) {
        Log::error('Error rejecting employee ID ' . $id . ': ' . $e->getMessage());
        return response()->json(['success' => false, 'message' => 'Something went wrong. Please try again.'], 500);
    }
}

    public function edit($id)
    {
        $employee = User::findOrFail($id);
        return view('admin.employees.edit', compact('employee'));
    }

    public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $id,
        'phone' => 'required|string|max:20',
        'address' => 'required|string|max:100',
        'status' => 'required|string|in:0,1',
    ]);

    $employee = User::findOrFail($id);
    $employee->name = $request->name;
    $employee->email = $request->email;
    $employee->phone = $request->phone;
    $employee->address = $request->address;
    $employee->status = $request->status;
    $employee->save();

    return redirect()->route('admin.employees.manage');
}

public function destroy($id)
{
    try {
        $employee = User::findOrFail($id);
        $employee->delete();
        // Session::flash('success', 'employee deleted successfully.');
        return redirect()->route('admin.employees.manage');
    } catch (\Exception $e) {
        Log::error('Error deleting employee: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Something went wrong. Please try again.');
    }
}

}
