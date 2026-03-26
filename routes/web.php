<?php

use App\Http\Controllers\Booking\RoomsBookingController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Client\EnquiryController;

Route::get('/', function () {
    return redirect()->route('room.booking');
});

Route::get('/dashboard', [RoomsBookingController::class, 'dashboard'])->name('dashboard');

// Client Enquiries Routes
Route::prefix('dashboard')->name('client.')->middleware(['auth'])->group(function(){
    
    Route::get('/enquiries', [EnquiryController::class, 'index'])->name('enquiries.index');
    
    Route::get('/enquiries/{id}', [EnquiryController::class, 'show'])->name('enquiry.show'); 
    
    Route::post('/enquiry/{id}/respond', [EnquiryController::class, 'storeReply'])->name('enquiry.reply.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/myprofile', [ProfileController::class, 'show'])->name('profile.show');



require __DIR__.'/auth.php';
// In routes/web.php or routes/api.php
require __DIR__.'/api/booking.php';

require __DIR__.'/admin/admin.php';

require __DIR__.'/admin/auth.php';

require __DIR__.'/admin/triggers.php';

require __DIR__.'/admin/provider_user.php';

require __DIR__.'/admin/provider_verification.php';

require __DIR__.'/api/paypal.php';

require __DIR__.'/api/payfast.php';

require __DIR__.'/api/footer.php';

require __DIR__.'/api/contact.php';

require __DIR__.'/api/ozow.php';

require __DIR__.'/tenants/tenant.php';

require __DIR__.'/technicians/technician.php';