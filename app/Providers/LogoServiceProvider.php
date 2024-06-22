<?php

namespace App\Providers;

use App\Models\Logo;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class LogoServiceProvider extends ServiceProvider
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
        View::composer('*', function ($view) {
            $logoUrl = Logo::first();
            $view->with('logoUrl', $logoUrl);
        });
    }
}
