<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;


class AdvertiserController extends Controller
{
    public function index()
    {
        return view('advertisers.index');
    }

    public function create()
    {
        return view('advertisers.create');
    }

    public function store(Request $request)
    {

        try {
            // dd($request->all()); 
            $request->validate([
                'name' => 'required|string|max:255',
                'full_name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'phone' => 'required|string|max:10',
                'address' => 'required|string|max:255', 
                'zipcode' => 'sometimes|nullable|string|max:20',
                'country' => 'required|string|max:255', 
                'status' => 'required|string',                    
            ]);
               
            User::create([
                'company_name' => $request->name,
                'name' => $request->full_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'zipcode' => $request->zipcode,
                'country' => $request->country,
                'password' => Hash::make('12345678'), 
                'role' => 'advertiser',
                'status' => $request->status,
            ]);

            return redirect()->route('advertisers.manage')->with('success', 'advertiser added successfully!');
        } catch (\Exception $e) {
            Log::error('Error saving advertiser: ' . $e->getMessage());
            
            return redirect()->back()->with('error', 'There was an error adding the advertiser. Please try again.');
        }
    }

    public function manage()
    {
        $advertisers = User::where('role', 'advertiser')->get(); 
        return view('advertisers.manage', compact('advertisers'));
    }

    public function confirm($id)
{
    try {
        $advertiser = User::findOrFail($id);
        $advertiser->status = '1';
        $advertiser->save();

        return response()->json(['success' => true]);
    } catch (\Exception $e) {
        Log::error('Error confirming advertiser: ' . $e->getMessage());
        return response()->json(['success' => false, 'message' => 'Something went wrong. Please try again.'], 500);
    }
    }

    public function reject($id)
    {
        try {
            $advertiser = User::findOrFail($id);
            $advertiser->status = '0';
            $advertiser->save();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            \Log::error('Error rejecting advertiser ID ' . $id . ': ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Something went wrong. Please try again.'], 500);
        }
    }

    public function disable($id)
    {
        try {
            $advertiser = User::findOrFail($id);
            $advertiser->status = '0'; 
            $advertiser->save();

            return redirect()->route('advertisers.index')->with('success', 'advertiser disabled successfully.');
        } catch (\Exception $e) {
            Log::error('Error disabling advertiser ID ' . $id . ': ' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong. Please try again.');
        }
    }

    public function edit($id)
        {
            $advertiser = User::findOrFail($id);
            return view('advertisers.edit', compact('advertiser'));
        }

    public function destroy($id)
    {
        try {
            $advertiser = User::findOrFail($id);
            $advertiser->delete();
            // Session::flash('success', 'advertiser deleted successfully.');
            return redirect()->route('advertisers.index');
        } catch (\Exception $e) {
            Log::error('Error deleting advertiser: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong. Please try again.');
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'company_name' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:100',
            'status' => 'required|string|in:active,inactive,pending',
        ]);

        $advertiser = User::findOrFail($id);
        $advertiser->company_name = $request->company_name; 
        $advertiser->name = $request->name;
        $advertiser->email = $request->email;
        $advertiser->phone = $request->phone;
        $advertiser->address = $request->address;
        $advertiser->status = $request->status;
        $advertiser->save();

        return redirect()->route('advertisers.manage')->with('success', 'Advertiser updated successfully.');
    }

    public function show($id)
    {
        $advertiser = User::findOrFail($id);

        return view('advertisers.show', compact('advertiser'));
    }


    public function showRegistrationForm()
    {
        return view('auth.advertiserRegister'); 
    }

    /**
     * Handle the registration request for advertisers.
     */
    public function register(Request $request)
    {
        $request->validate([
            'company' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'email' => 'required|string|email|max:255|unique:users',
            'address' => 'nullable|string|max:255',
            'password' => 'required|string|min:8|confirmed',
            'status' => 'required|in:pending,active',
        ]);

        $advertiser = User::create([
            'company' => $request->company,
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'password' => Hash::make($request->password),
            'status' => $request->status,
        ]);

        // Log in the user automatically after registration
        auth()->login($advertiser);

        // Redirect to dashboard after successful registration
        return redirect()->route('dashboard');
    }

    public function login(Request $request)
    {
        // Validate the request
        $credentials = $request->only('email', 'password');

        // Attempt to log the user in
        if (auth()->guard('advertiser')->attempt($credentials)) {
            // Authentication passed
            return redirect()->intended('/admin');
        }

        // Authentication failed
        return redirect()->back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }
}
