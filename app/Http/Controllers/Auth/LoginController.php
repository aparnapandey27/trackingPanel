<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Handle a successful login attempt.
     *
     * @param Request $request
     * @param $user
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function authenticated(Request $request, $user)
    {
        $user->timestamps = false;
        $user->update([
            'last_login_at' => Carbon::now()->toDateTimeString(),
            'last_login_ip' => $request->ip(),
        ]);

        // Redirect based on user role and status
        if ($user->status == 0) {
            Auth::logout();
            return redirect()->route('login')->with('error', 'Your account is being reviewed');
        } elseif ($user->status == 2) {
            Auth::logout();
            return redirect()->route('login')->with('error', 'Your account has been closed');
        }

        // Set the redirection based on user role
        $this->redirectTo = match ($user->role) {
            'admin' => route('admin.dashboard'),
            'student' => route('students.dashboard'),
            'advertiser' => route('advertisers.dashboard'),
            'employee' => route('employees.dashboard'),
            default => route('login'),
        };

        return redirect()->intended($this->redirectTo);
    }
}
