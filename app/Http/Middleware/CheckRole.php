<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // Check if user is authenticated
        if (!$request->user()) {
            return redirect()->route('login');
        }

        // If no specific roles are required, proceed
        if (empty($roles)) {
            return $next($request);
        }

        // If user is admin, always proceed (admin has all permissions)
        if ($request->user()->role === 'admin') {
            return $next($request);
        }

        // Check if user has one of the required roles
        if (in_array($request->user()->role, $roles)) {
            return $next($request);
        }

        // Redirect with error message if user doesn't have required role
        return redirect()->route('dashboard')
            ->with('error', 'You do not have permission to access this page.');
    }
}
