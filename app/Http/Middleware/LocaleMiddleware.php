<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class LocaleMiddleware
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
        // Check session first
        if (session()->has('locale')) {
            $locale = session('locale');
        }
        // Then check cookie
        elseif ($request->cookie('locale')) {
            $locale = $request->cookie('locale');
        }
        // Default to English
        else {
            $locale = 'en';
        }
        
        // Validate locale
        if (!in_array($locale, ['en', 'fr'])) {
            $locale = 'en';
        }
        
        // Set the application locale
        App::setLocale($locale);
        
        return $next($request);
    }
}
