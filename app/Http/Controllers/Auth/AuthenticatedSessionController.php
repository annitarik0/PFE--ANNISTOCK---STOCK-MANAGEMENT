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

            // Check if user exists
            $user = \App\Models\User::where('email', $request->email)->first();
            if (!$user) {
                \Log::error('User not found', ['email' => $request->email]);
                return back()->withErrors([
                    'email' => 'The provided email does not exist in our records.',
                ])->withInput($request->only('email', 'remember'));
            }

            // Attempt authentication
            $request->authenticate();

            $request->session()->regenerate();

            // Log successful authentication
            \Log::info('Login successful', ['email' => $request->email, 'user_id' => $user->id]);

            // Use the HOME constant from RouteServiceProvider
            return redirect('/dashboard');
        } catch (\Exception $e) {
            // Log the error
            \Log::error('Login failed', [
                'email' => $request->email,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            // Check if user exists but password is wrong
            $user = \App\Models\User::where('email', $request->email)->first();
            if ($user) {
                return back()->withErrors([
                    'password' => 'The provided password is incorrect.',
                ])->withInput($request->only('email', 'remember'));
            }

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


