<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Middleware\RedirectIfAuthenticated;

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
        RedirectIfAuthenticated::redirectUsing(function (string ...$guards) {
            if (Auth::guard('admin')->check()) {
                return route('admin.dashboard');
            }
            
            // Default redirection for 'web' guard or others
            return route('dashboard'); // Or 'home', depending on your user routes
        });
    }
}
