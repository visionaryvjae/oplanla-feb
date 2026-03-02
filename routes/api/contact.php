<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Booking\ContactController;

// Shows the contact form page
Route::get('/contact', [ContactController::class, 'create'])->name('contact.create');

// Handles the form submission
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
