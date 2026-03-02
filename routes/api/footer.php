<?php

use App\Http\Controllers\Booking\RoomsBookingController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/top-destinations', function () {
    return view('Booking.footer-components.top-destinations');
})->name('footer.top-destinations');

Route::get('/accommodation-types', function () {
    return view('Booking.footer-components.accommodation-types');
})->name('footer.accommodation-types');

Route::get('/help', function () {
    return view('Booking.footer-components.help-page');
})->name('footer.help');

Route::get('/faq', function () {
    return view('Booking.footer-components.FAQ');
})->name('footer.faq');

Route::get('/how-to-book', function () {
    return view('Booking.footer-components.how-to-book');
})->name('footer.how-to-book');

Route::get('/list-property', function () {
    return view('Booking.footer-components.list-property');
})->name('footer.list-property');

Route::get('partners', function () {
    return view('Booking.footer-components.partner-hub');
})->name('footer.partner-hub');

Route::get('/why-host-with-us', function () {
    return view('Booking.footer-components.why-oplanla');
})->name('footer.why-host-with-us');


Route::get('/about-us', function() {
    return view('Booking.footer-components.about-us');
})->name('footer.about-us');

Route::get('/terms-and-conditions', function() {
   return view('Booking.footer-components.term-conditions');
})->name('footer.terms');

Route::get('privacy-policy', function() {
    return view('Booking.footer-components.privacy-policy');
})->name('footer.privacy');