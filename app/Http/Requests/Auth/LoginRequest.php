<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        // Log authentication attempt details
        \Log::info('Authentication attempt details', [
            'email' => $this->input('email'),
            'remember' => $this->boolean('remember')
        ]);

        // Try to authenticate with credentials
        $credentials = $this->only('email', 'password');
        \Log::info('Attempting authentication with credentials', ['email' => $credentials['email']]);

        // Check if the user exists
        $user = \App\Models\User::where('email', $this->input('email'))->first();
        if (!$user) {
            RateLimiter::hit($this->throttleKey());
            \Log::error('User not found during authentication', ['email' => $this->input('email')]);
            throw ValidationException::withMessages([
                'email' => 'The provided email does not exist in our records.',
            ]);
        }

        // Attempt authentication
        if (!Auth::attempt($credentials, $this->boolean('remember'))) {
            RateLimiter::hit($this->throttleKey());

            // Log authentication failure
            \Log::error('Authentication failed for user - password mismatch', [
                'email' => $this->input('email'),
                'user_id' => $user->id
            ]);

            throw ValidationException::withMessages([
                'password' => 'The provided password is incorrect.',
            ]);
        }

        // Log successful authentication
        \Log::info('Authentication successful', [
            'email' => $this->input('email'),
            'user_id' => Auth::id(),
            'user_role' => Auth::check() && is_object(Auth::user()) ? Auth::user()->role : 'unknown'
        ]);

        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        // Reduced from 5 to 3 attempts for better security
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 3)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        // Log potential brute force attempts
        \Log::warning('Login rate limit exceeded', [
            'email' => $this->input('email'),
            'ip' => $this->ip(),
            'user_agent' => $this->header('User-Agent'),
            'lockout_seconds' => $seconds
        ]);

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        // Include user agent hash in the throttle key for better security
        $userAgent = $this->header('User-Agent') ?? 'unknown';
        $userAgentHash = substr(md5($userAgent), 0, 8);

        return Str::transliterate(Str::lower($this->input('email')).'|'.$this->ip().'|'.$userAgentHash);
    }
}

