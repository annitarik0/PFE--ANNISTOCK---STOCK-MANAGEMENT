<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please log in to access this page.');
        }

        if (!is_object(Auth::user())) {
            // Log the error
            \Log::error('Auth::user() returned a non-object in IsAdmin middleware', [
                'user' => Auth::user(),
                'type' => gettype(Auth::user())
            ]);

            // Force logout to clear the session
            Auth::logout();

            // Redirect to login page with error message
            return redirect()->route('login')
                ->with('error', 'Your session has expired. Please log in again.');
        }

        if (Auth::user()->role === 'admin') {
            return $next($request);
        }

        return redirect()->route('dashboard')->with('error', 'You do not have permission to access this page.');
    }
}
