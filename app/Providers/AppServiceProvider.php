<?php

namespace App\Providers;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Add whereNotLike macro to the query builder
        Builder::macro('whereNotLike', function($column, $value) {
            return $this->whereRaw("$column NOT LIKE ?", [$value]);
        });
    }
}
