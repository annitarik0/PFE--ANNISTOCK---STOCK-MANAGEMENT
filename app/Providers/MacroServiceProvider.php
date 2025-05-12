<?php

namespace App\Providers;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\ServiceProvider;

class MacroServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Add whereNotLike macro to the query builder
        Builder::macro('whereNotLike', function($column, $value) {
            return $this->whereRaw("$column NOT LIKE ?", [$value]);
        });
    }
}
