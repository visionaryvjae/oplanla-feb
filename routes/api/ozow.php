<?php

use App\Http\Controllers\Api\OzowNotifyController;
use Illuminate\Support\Facades\Route;

// Ozow Webhook Notification Route
Route::post('/ozow/notify', [OzowNotifyController::class, 'handleNotify'])->name('api.ozow.notify');