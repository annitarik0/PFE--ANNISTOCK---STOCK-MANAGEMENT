<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class HandleAuthErrors
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if Auth::user() is a string instead of an object
        if (Auth::check() && !is_object(Auth::user())) {
            // Log the error
            Log::error('Auth::user() returned a non-object', [
                'user' => Auth::user(),
                'type' => gettype(Auth::user())
            ]);
            
            // Force logout to clear the session
            Auth::logout();
            
            // Redirect to login page with error message
            return redirect()->route('login')
                ->with('error', 'Your session has expired. Please log in again.');
        }
        
        return $next($request);
    }
}
