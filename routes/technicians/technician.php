<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Maintenance\MaintenanceController;
use App\Http\Controllers\Maintenance\DashboardController;
use App\Http\Controllers\Maintenance\Auth\LoginController;
use App\Http\Controllers\Maintenance\TicketController;

//technician auth routes
Route::prefix('technician')->name('technician.')->group(function() {
    Route::middleware(['guest:technician'])->group(function() {
        // Login Routes
        Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
        Route::post('login', [LoginController::class, 'login']);
    });

    Route::middleware(['auth:technician'])->group(function(){
        Route::get('dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

        Route::post('logout', [LoginController::class, 'logout'])->name('logout');
    });
});

//technician Maintenance Routes
Route::prefix('technician')->name('technician.')->group(function () {
    Route::get('maintenance', [MaintenanceController::class, 'index'])->name('maintenance.index');
    Route::get('maintenance/report', [MaintenanceController::class, 'create'])->name('maintenance.create');
    Route::post('maintenance/report', [MaintenanceController::class, 'store'])->name('maintenance.store');
    Route::get('maintenance/{job}', [MaintenanceController::class, 'show'])->name('maintenance.show');

    //Ticket routes
    Route::resource('tickets', TicketController::class);
    Route::post('tickets/upload-image/{ticketId}', [TicketController::class, 'uploadPhoto'])->name('ticket.upload.photo');
    Route::post('tickets/mark-as-complete/{ticketId}', [TicketController::class, 'completeTicket'])->name('ticket.complete');
})->middleware(['auth:technician']);

