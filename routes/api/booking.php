<?php

use App\Http\Controllers\Booking\ProvidersController;
use App\Http\Controllers\Booking\ReviewController;
use App\Http\Controllers\Booking\RoomsController;
use App\Http\Controllers\Booking\RoomsBookingController;
use App\Http\Controllers\Payments\PaymentController;
use App\Http\Middleware\AuthMiddleware;
use App\Http\Controllers\Booking\BookingRequestController;
use App\Http\Controllers\Client\EnquiryController;
use Illuminate\Support\Facades\Route;

//user room routes
Route::get('room/{id}', [RoomsController::class, 'viewSingle'])->name('rooms.single');
Route::get('rooms', [RoomsController::class, 'roomsLanding'])->name('rooms.landing');
Route::get('booking/rooms', [ProvidersController::class, 'roomSearch'])->name('rooms.search');
Route::get('booking/provider/{id}', [ProvidersController::class, 'viewSingle'])->name('rooms.show');
Route::get('booking/room/{id}', [RoomsController::class, 'viewSingle'])->name('room.show');


//Rental routes
Route::get('rentals', [RoomsController::class, 'rentalsLanding'])->name('rentals.landing');
Route::get('booking/rental/{id}', [RoomsController::class, 'viewSingleRental'])->name('rental.show');


//Enquiry Routes
Route::post('booking/rental/{room_id}/send-enquiry/', [EnquiryController::class, 'sendEnquiry'])->name('rental.send.enquiry')->middleware(['auth']);


//booking landing page
Route::get('/booking', [RoomsBookingController::class, 'landing'])->name('room.booking');
Route::get('booking/providers/rooms', [RoomsController::class, 'providerFilter'])->name('provider.rooms.filter');
Route::get('booking/search', [RoomsController::class, 'RoomsFilter'])->name('rooms.filter');
Route::get('/handle-click', [RoomsController::class, 'CityFilter'])->name('handle-click');
Route::get('/handle-property-click', [RoomsController::class, 'PropertyFilter'])->name('handle-property-click');

Route::get('/handle-conference-click', [RoomsController::class, 'ConferenceFilter'])->name('handle-conference-click');

Route::get('/rooms/live-filter', [RoomsController::class, 'liveFilter'])->name('rooms.live-filter');

Route::get('/rooms/live-filter-rooms', [RoomsController::class, 'roomsLiveFilter'])->name('rooms.room-live-filter');


// Payment Gateway Routes
Route::get('/payment/initiate', [PaymentController::class, 'redirectToGateway'])->name('payment.initiate');
Route::get('/payment/success', [PaymentController::class, 'handleSuccess'])->name('payment.success');
Route::get('/payment/failure', [PaymentController::class, 'handleFailure'])->name('payment.failure');

//room booking routes
Route::get('admin/room_booking', [RoomsBookingController::class, 'index'])->name('room.booking.index');
Route::get('admin/room_booking/{id}', [RoomsBookingController::class, 'viewSingleAdmin'])->name('room.booking.show');
Route::get('/my_booking/{id}', [RoomsBookingController::class, 'viewSingle'])->name('booking.show.single');
Route::get('room_booking/create', [RoomsBookingController::class, 'create'])->name('room.booking.create');
Route::post('room_booking/store', [RoomsBookingController::class, 'store'])->name('room.booking.store'); //->middleware(['auth', HandlePayment::class])
Route::get('admin/room_booking/edit/{id}', [RoomsBookingController::class, 'edit'])->name('room.booking.edit');
Route::post('admin/room_booking/update/{id}', [RoomsBookingController::class, 'update'])->name('room.booking.update');
Route::get('admin/room_booking/delete/{id}', [RoomsBookingController::class, 'delete'])->name('room.booking.delete');
Route::post('admin/room_booking/end/{id}', [RoomsBookingController::class, 'end_booking'])->name('room.booking.end');
Route::get('admin/room_booking/cancel/{id}', [RoomsBookingController::class, 'cancel_booking'])->name('room.booking.cancel');


//review routes
Route::get('reviews/create/{pid}', [ReviewController::class, 'create'])->name('review.create');
Route::post('reviews/store', [ReviewController::class, 'store'])->name('review.store');


//Booking Request routes
Route::middleware(['auth'])->group(function () {
    // Other user routes...
    Route::get('/booking/{booking}/request-change', [BookingRequestController::class, 'create'])->name('booking.request.create');
    Route::post('/booking/{booking}/request-change', [BookingRequestController::class, 'store'])->name('booking.request.store');
    Route::post('/booking/{booking}/request-cancel', [BookingRequestController::class, 'storeCancel'])->name('booking.request.cancel');
    Route::get('/booking/{booking}/request-accept', [BookingRequestController::class, 'approve'])->name('admin.booking-requests.accept');
    Route::get('/booking/{booking}/request-reject', [BookingRequestController::class, 'reject'])->name('admin.booking-requests.reject');
});