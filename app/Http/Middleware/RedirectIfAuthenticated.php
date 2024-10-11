<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  ...$guards
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {

        if (Auth::guard($guard)->check() && Auth::user()->role == 'admin' && Auth::user()) {
            return redirect()->route('admin.dashboard');

        } elseif (Auth::guard($guard)->check() && Auth::user()->role == 'student' && Auth::user()) {
            return redirect()->route('student.dashboard');

        } elseif (Auth::guard($guard)->check() && Auth::user()->role == 'advertiser' && Auth::user()) {
            return redirect()->route('advertiser.dashboard');

        } elseif (Auth::guard($guard)->check() && Auth::user()->role == 'employee' && Auth::user()) {
            return redirect()->route('employee.dashboard');
            
        } else {
            return $next($request);
        }
    }
}
