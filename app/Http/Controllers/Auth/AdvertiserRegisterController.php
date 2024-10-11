<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class AdvertiserRegisterController extends Controller
{
    // Show the registration form
    public function showRegistrationForm()
    {
        return view('auth.advertiserRegister');
    }

    // Handle the registration logic
    public function register(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'company' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|string|email|max:255|unique:users',
            'address' => 'nullable|string|max:255',
            'password' => 'required|string|confirmed|min:8',
            'status' => 'required|string|in:0,1',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Create the advertiser
        $user = User::create([
            'company' => $request->input('company'),
            'name' => $request->input('name'),
            'phone' => $request->input('phone'),
            'email' => $request->input('email'),
            'address' => $request->input('address'),
            'password' => Hash::make($request->input('password')),
            'status' => $request->input('status'),
            'role' => 'advertiser', // Assuming role-based system
        ]);

        // Optionally, you might want to log the user in
        // Auth::login($user);

        return redirect()->route('login')->with('success', 'Registration successful. Please login.');

    }
}
