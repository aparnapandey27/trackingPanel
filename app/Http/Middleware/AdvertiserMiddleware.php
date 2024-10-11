<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdvertiserMiddleware
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
        // Check if the user is logged in and has the 'advertiser' role
        if (Auth::check()) {
            $user = Auth::user();
            
            if ($user->role == 'advertiser' && ($user->status == 'active' || $user->status == 1)) {
                return $next($request);
            }
        }

        // If user is not authenticated or doesn't meet the conditions, redirect to login
        return redirect()->route('login');
    }
}
