<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // Determine the redirect route based on user role and status
        if (Auth::check() && Auth::user()->status == 1) {
            switch (Auth::user()->role) {
                case 'admin':
                    $redirectTo = route('admin.dashboard');
                    break;
                case 'student':
                    $redirectTo = route('student.dashboard');
                    break;
                case 'advertiser':                
                    $redirectTo = route('advertiser.dashboard');
                    break;
                case 'employee':
                    $redirectTo = route('employee.dashboard');
                    break;
                default:
                    $redirectTo = route('login');
                    break;
            }
        } else {
            // Redirect to login if the user is not active
            $redirectTo = route('login');
        }

        return redirect()->intended($redirectTo);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
