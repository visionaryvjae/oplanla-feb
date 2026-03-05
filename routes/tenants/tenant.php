<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Client\MaintenanceController;
use App\Http\Controllers\Client\UtilityController;
use App\Http\Controllers\Client\DocumentsController;

//Tenant Maintenance Routes
Route::middleware(['auth', 'role:tenant'])->group(function () {
    Route::get('/tenant/maintenance', [MaintenanceController::class, 'index'])->name('tenant.maintenance.index');
    Route::get('/tenant/maintenance/report', [MaintenanceController::class, 'create'])->name('tenant.maintenance.create');
    Route::post('/tenant/maintenance/report', [MaintenanceController::class, 'store'])->name('tenant.maintenance.store');
    Route::get('/tenant/maintenance/{job}', [MaintenanceController::class, 'show'])->name('tenant.maintenance.show');
});

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