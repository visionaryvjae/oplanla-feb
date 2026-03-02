<?php

// In routes/web.php
use App\Http\Controllers\Provider\VerificationController;

Route::prefix('provider')->group(function () {

    Route::get('/document', [VerificationController::class, 'showDocument'])->name('document.show');

    Route::get('/verification-info', function() {
        return view('providers.auth.user_verification', ['initialTab' => 'ownership']);
    })->name('partner.edit.verification');

    // Routes to show the forms
    Route::get('/verification/ownership', [VerificationController::class, 'showOwnershipForm'])->name('verification.ownership');
    Route::get('/verification/identity', [VerificationController::class, 'showIdentityForm'])->name('verification.identity');
    Route::get('/verification/address', [VerificationController::class, 'showAddressForm'])->name('verification.address');
    Route::get('/verification/business', [VerificationController::class, 'showBusinessForm'])->name('verification.business');

    // Routes to handle form submissions
    Route::post('/verification/ownership/store', [VerificationController::class, 'storeOwnership'])->name('verification.store.ownership');
    Route::post('/verification/identity/store', [VerificationController::class, 'storeIdentity'])->name('verification.store.identity');
    Route::post('/verification/address/store', [VerificationController::class, 'storeAddress'])->name('verification.store.address');
    Route::post('/verification/business/store', [VerificationController::class, 'storeBusiness'])->name('verification.store.business');

    // Routes to handle form submissions
    Route::post('/verification/ownership/{ownershipProof}', [VerificationController::class, 'updateOwnership'])->name('verification.update.ownership');
    Route::post('/verification/identity/{identifyProof}', [VerificationController::class, 'updateIdentity'])->name('verification.update.identity');
    Route::post('/verification/address/{addressProof}', [VerificationController::class, 'updateAddress'])->name('verification.update.address');
    Route::post('/verification/business/{businessDetail}', [VerificationController::class, 'updateBusiness'])->name('verification.update.business');
})->middleware('auth:provider');