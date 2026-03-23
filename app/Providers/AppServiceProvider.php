<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Middleware\RedirectIfAuthenticated;
use App\Models\Booking\MaintenanceJob;
use App\Models\Booking\MaintenanceTicket;
use App\Observers\MaintenanceTicketObserver;
use App\Observers\MaintenanceJobObserver;

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
        MaintenanceTicket::observe(MaintenanceTicketObserver::class);
    
        // If you have a separate Job model for the initial submission:
        MaintenanceJob::observe(MaintenanceJobObserver::class);

        RedirectIfAuthenticated::redirectUsing(function (string ...$guards) {
            if (Auth::guard('admin')->check()) {
                return route('admin.dashboard');
            }
            
            // Default redirection for 'web' guard or others
            return route('dashboard'); // Or 'home', depending on your user routes
        });
    }
}
