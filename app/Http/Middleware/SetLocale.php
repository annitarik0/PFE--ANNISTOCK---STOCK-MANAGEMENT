<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;

class SetLocale
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
        // Check if the user has selected a language (stored in session)
        if (Session::has('locale')) {
            $locale = Session::get('locale');
        }
        // Check if there's a locale cookie
        else if ($request->cookie('locale')) {
            $locale = $request->cookie('locale');
        }
        // Default to English
        else {
            $locale = 'en';
        }

        // Validate the locale
        if (!in_array($locale, ['en', 'fr'])) {
            $locale = 'en';
        }

        // Set the application locale
        App::setLocale($locale);

        // Set the locale in the config
        Config::set('app.locale', $locale);

        // Ensure the session has the current locale
        if (Session::get('locale') !== $locale) {
            Session::put('locale', $locale);
        }

        // Log the current locale for debugging
        \Log::info('Current locale in middleware', [
            'locale' => $locale,
            'app_locale' => App::getLocale(),
            'config_locale' => Config::get('app.locale'),
            'session_locale' => Session::get('locale'),
            'cookie_locale' => $request->cookie('locale')
        ]);

        return $next($request);
    }
}
