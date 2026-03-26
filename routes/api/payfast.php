<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Booking\PayFastController;

// PayFast Manual Payment Routes
Route::get('/payfast/pay', [PayFastController::class, 'showPaymentForm'])->name('payfast.pay');
Route::get('/payfast/success', [PayFastController::class, 'success'])->name('payfast.success');
Route::get('/payfast/cancel', [PayFastController::class, 'cancel'])->name('payfast.cancel');
Route::post('/payfast/notify', [PayFastController::class, 'notify'])->name('payfast.notify');


//rental payments
Route::post('/payfast/itn', [PayfastItnController::class, 'handleNotify'])->name('api.payfast.itn');


// protected $except = [
//     '/payfast/notify',
//     // ... any other routes you have here
// ];

