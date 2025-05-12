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
        try {
            // Log the login attempt
            \Log::info('Login attempt', ['email' => $request->email]);

            $request->authenticate();

            $request->session()->regenerate();

            // Log successful authentication
            \Log::info('Login successful', ['email' => $request->email]);

            // Use the HOME constant from RouteServiceProvider
            return redirect('/dashboard');
        } catch (\Exception $e) {
            // Log the error
            \Log::error('Login failed', ['email' => $request->email, 'error' => $e->getMessage()]);

            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ])->withInput($request->only('email', 'remember'));
        }
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


