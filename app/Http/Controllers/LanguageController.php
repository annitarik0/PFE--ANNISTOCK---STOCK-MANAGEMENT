<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;

class LanguageController extends Controller
{
    /**
     * Change the application language.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $locale
     * @return \Illuminate\Http\RedirectResponse
     */
    public function switchLang(Request $request, $locale)
    {
        // Check if the locale is valid (only allow 'en' or 'fr')
        if (!in_array($locale, ['en', 'fr'])) {
            $locale = 'en'; // Default to English if invalid
        }

        // Set the application locale directly
        App::setLocale($locale);

        // Set the locale in the config
        Config::set('app.locale', $locale);

        // Store the selected language in the session
        Session::put('locale', $locale);

        // Force the session to be saved immediately
        Session::save();

        // Set a cookie as a backup
        $cookie = cookie('locale', $locale, 60*24*30); // 30 days

        // Log the language change for debugging
        \Log::info('Language changed', [
            'locale' => $locale,
            'app_locale' => App::getLocale(),
            'config_locale' => Config::get('app.locale'),
            'session_locale' => Session::get('locale')
        ]);

        // Redirect back to the previous page
        return redirect()->back()->withCookie($cookie);
    }
}
