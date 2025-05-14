<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        // Log the email being requested
        \Log::info('Password reset requested for email: ' . $request->email);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        try {
            $status = Password::sendResetLink(
                $request->only('email')
            );

            \Log::info('Password reset status: ' . $status);

            if ($status == Password::RESET_LINK_SENT) {
                // Redirect to the confirmation page instead of going back with a status message
                return redirect()->route('password.confirmation', ['email' => $request->email]);
            } else {
                return back()->withInput($request->only('email'))
                    ->withErrors(['email' => __($status)]);
            }
        } catch (\Exception $e) {
            \Log::error('Password reset error: ' . $e->getMessage());
            return back()->withInput($request->only('email'))
                ->withErrors(['email' => 'An error occurred while sending the password reset link. Please try again.']);
        }
    }
}
