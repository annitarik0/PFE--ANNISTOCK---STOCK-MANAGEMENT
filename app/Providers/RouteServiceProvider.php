<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/dashboard';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        // API rate limiting - more restrictive for security
        RateLimiter::for('api', function (Request $request) {
            // More restrictive rate limiting for unauthenticated users
            if (!$request->user()) {
                return Limit::perMinute(30)->by($request->ip());
            }

            // Different rate limits based on user role
            if ($request->user()->isAdmin()) {
                return Limit::perMinute(120)->by($request->user()->id);
            }

            // Regular authenticated users
            return Limit::perMinute(60)->by($request->user()->id);
        });

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }
}
