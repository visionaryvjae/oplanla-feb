<?php

use App\Http\Controllers\Payments\PayPalController;
use Illuminate\Support\Facades\Route;


Route::get('paypal/payment', [PayPalController::class, 'create'])->name('paypal.create');
Route::get('paypal/success', [PayPalController::class, 'success'])->name('paypal.success');
Route::get('paypal/cancel', [PayPalController::class, 'cancel'])->name('paypal.cancel');