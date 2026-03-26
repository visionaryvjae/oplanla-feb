<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Client\MaintenanceController;
use App\Http\Controllers\Client\UtilityController;
use App\Http\Controllers\Client\DocumentsController;
use App\Http\Controllers\Client\BillingsController; 
use App\Http\Controllers\Client\PaymentController;
use App\Http\Controllers\Client\DashboardController;


Route::middleware(['auth', 'role:tenant'])->prefix('tenant')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('tenant.dashboard');
});


Route::middleware(['auth', 'role:tenant'])->prefix('tenant')->group(function () {
    // Billing Overview
    Route::get('/billings', [BillingsController::class, 'index'])->name('tenant.billings.index');
    
    // Payment Redirection Logic
    Route::post('/payment/checkout', [PaymentController::class, 'checkout'])->name('tenant.payment.checkout');
    
    // Specific Payment Methods
    Route::post('/payment/ozow', [PaymentController::class, 'processOzow'])->name('tenant.pay.ozow');
    Route::post('/payment/upload-pop', [PaymentController::class, 'uploadPoP'])->name('tenant.upload.pop');
});

// Tenant Reports
Route::middleware(['auth', 'role:tenant'])->prefix('tenant')->group(function () {
    Route::get('/reports/room-statement/download', [App\Http\Controllers\Client\ReportController::class, 'downloadStatement'])
        ->name('tenant.reports.statement.download');
});

//Tenant Maintenance Routes
Route::middleware(['auth', 'role:tenant'])->group(function () {
    Route::get('/tenant/maintenance', [MaintenanceController::class, 'index'])->name('tenant.maintenance.index');
    Route::get('/tenant/maintenance/report', [MaintenanceController::class, 'create'])->name('tenant.maintenance.create');
    Route::post('/tenant/maintenance/report', [MaintenanceController::class, 'store'])->name('tenant.maintenance.store');
    Route::get('/tenant/maintenance/{job}', [MaintenanceController::class, 'show'])->name('tenant.maintenance.show');
});

//TENANT ROOM SHOW
Route::name('tenant.')->prefix('tenant')->group(function() {
    Route::get('room/{id}', function(){
        return view('clients.room.show');
    })->name('room.show');
});

//Tenant Utility Routes
Route::middleware(['auth', 'role:tenant'])->prefix('tenant')->name('tenant.')->group(function () {
    Route::get('utility/report/download', [UtilityController::class, 'downloadUtilityReport'])->name('report.download');

    Route::resource('utilities', UtilityController::class);
});


//Tenant document uploads and onboarding
Route::middleware(['auth:web'])->prefix('tenant')->name('tenant.')->group(function() {
    Route::get('upload-documents', [DocumentsController::class, 'documentUpload'])->name('documents.upload');

    Route::post('verify-store', [DocumentsController::class, 'verifyStore'])->name('verify.store');
    Route::post('verify-update', [DocumentsController::class, 'verifyUpdate'])->name('verify.update');
    Route::get('document-show', [DocumentsController::class, 'showDocument'])->name('doc.show');
}); 