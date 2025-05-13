<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LocaleController extends Controller
{
    /**
     * Change the application language.
     *
     * @param  string  $locale
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changeLocale($locale)
    {
        // Validate locale
        if (!in_array($locale, ['en', 'fr'])) {
            $locale = 'en';
        }
        
        // Set locale in session
        session(['locale' => $locale]);
        
        // Set cookie
        $cookie = cookie('locale', $locale, 60 * 24 * 30);
        
        // Log the change
        \Log::info('Language changed', [
            'locale' => $locale,
            'session_id' => session()->getId()
        ]);
        
        // Redirect back with cookie
        return back()->withCookie($cookie);
    }
}
