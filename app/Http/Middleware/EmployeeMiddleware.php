<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeeMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Check if the user is authenticated
        if (Auth::check()) {
            $user = Auth::user();

            // Ensure the user is an employee and their status is active
            if ($user->role == 'employee' && ($user->status == 'active' || $user->status == 1)) {
                return $next($request);
            }
        }

        // Redirect to login if not authenticated or user doesn't have the required role/status
        return redirect()->route('login');
    }
}
