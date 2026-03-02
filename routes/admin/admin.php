<?php

use App\Http\Controllers\Booking\PhotoController;
use App\Http\Controllers\Booking\ProviderContactsController;
use App\Http\Controllers\Booking\ProvidersController;
use App\Http\Controllers\Booking\RoomFacilitiesController;
use App\Http\Controllers\Booking\RoomsController;
use App\Http\Controllers\Booking\RoomsBookingController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminProviderUserController;
use App\Http\Controllers\Admin\PartnerRequestController;
use App\Http\Controllers\Booking\BookingRequestController as AdminBookingRequestController;
use App\Http\Controllers\Reports\ReportController;
use App\Http\Controllers\Admin\EnquiryController;

//partner request routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('/partner-requests', PartnerRequestController::class);
    Route::get('/partner-requests/{id}/accept', [PartnerRequestController::class, 'acceptRequest'])->name('partner-requests.accept');
    Route::post('/partner-requests/{id}/reject', [PartnerRequestController::class, 'rejectRequest'])->name('partner-requests.reject');
});

//room admin routes
Route::middleware(['auth:admin'])->group(function(){
   Route::get('admin/rooms', [RoomsController::class, 'index'])->name('admin.rooms.index');
    Route::get('admin/room/{id}', [RoomsController::class, 'viewSingleAdmin'])->name('admin.rooms.single');
    Route::get('admin/rooms/create', [RoomsController::class, 'create'])->name('admin.rooms.create');
    Route::get('admin/rooms/create/{id}', [RoomsController::class, 'createSingle'])->name('admin.rooms.create.single');
    Route::post('admin/rooms/store', [RoomsController::class, 'store'])->name('admin.rooms.store');
    Route::get('admin/rooms/edit/{id}', [RoomsController::class, 'edit'])->name('admin.rooms.edit');
    Route::post('admin/rooms/update/{id}', [RoomsController::class, 'update'])->name('admin.rooms.update');
    Route::delete('admin/rooms/delete/{id}', [RoomsController::class, 'delete'])->name('admin.rooms.delete'); 
    
    //room facilities routes
    Route::get('admin/rooms/facilities/create/{id}', [RoomFacilitiesController::class, 'create'])->name('facility.create');
    Route::post('admin/rooms/facilities/store/{id}', [RoomFacilitiesController::class, 'store'])->name('facility.store');
});


// Admin Enquiry Routes
Route::prefix('admin')->name('admin.')->middleware(['auth:admin'])->group(function(){
    Route::get('/enquiries', [EnquiryController::class, 'index'])->name('enquiries.index');
    
    Route::get('/enquiry/{id}', [EnquiryController::class, 'show'])->name('enquiry.show');
    
    
    
    Route::get('/enquiry/{enquiry}/respond', [EnquiryController::class, 'showResponseForm'])->name('enquiry.respond');
    Route::post('/enquiry/{enquiry}/respond', [EnquiryController::class, 'storeReply'])->name('enquiry.reply.store');
    
    Route::post('/enquiry/{enquiry}/potential-tenant', [EnquiryController::class, 'markAsPotentialTenant'])->name('enquiry.mark.potential.tenant'); 
});



//providers
Route::middleware(['auth:admin'])->group(function(){
    Route::get('admin/providers', [ProvidersController::class, 'index'])->name('admin.providers.index');
    Route::get('admin/provider/{id}', [ProvidersController::class, 'viewSingleAdmin'])->name('providers.single');
    Route::get('admin/providers/create', [ProvidersController::class, 'create'])->name('providers.create');
    Route::post('admin/providers/store', [ProvidersController::class, 'store'])->name('admin.providers.store');
    Route::get('admin/providers/edit/{id}', [ProvidersController::class, 'edit'])->name('admin.providers.edit');
    Route::post('admin/providers/update/{id}', [ProvidersController::class, 'update'])->name('admin.providers.update');
    Route::delete('admin/providers/delete/{id}', [ProvidersController::class, 'delete'])->name('admin.providers.delete'); 
});


//image routes
Route::middleware(['auth:admin'])->group(function(){
    Route::get('admin/providers/{id}/images', [PhotoController::class, 'index'])->name('image.index');
    Route::get('admin/providers/{id}/images/create', [PhotoController::class, 'create'])->name('image.create');
    Route::post('admin/providers/{id}/images/store', [PhotoController::class, 'store'])->name('image.store');
    Route::get('admin/providers/{pid}/images/{id}', [PhotoController::class, 'show'])->name('image.show');
    Route::get('admin/providers/{pid}/images/edit/{id}', [PhotoController::class, 'edit'])->name('image.edit');
    Route::post('admin/providers/{pid}/images/update/{id}', [PhotoController::class, 'update'])->name('image.update');
    Route::delete('admin/providers/{pid}/images/delete/{id}', [PhotoController::class, 'delete'])->name('image.delete'); 
});


//contacts routes
Route::middleware(['auth:admin'])->group(function(){
    Route::get('admin/providers/{id}/contacts/create', [ProviderContactsController::class, 'create'])->name('admin.contact.create');
    Route::post('admin/providers/{id}/contacts/store', [ProviderContactsController::class, 'store'])->name('admin.contact.store');
    Route::get('admin/providers/{pid}/contact/edit/{id}', [ProviderContactsController::class, 'edit'])->name('admin.contact.edit');
    Route::post('admin/providers/{pid}/contact/update/{id}', [ProviderContactsController::class, 'update'])->name('admin.contact.update');
    Route::delete('admin/providers/{pid}/contact/delete/{id}', [ProviderContactsController::class, 'delete'])->name('admin.contact.delete'); 
});

//booking request rotues
Route::middleware(['auth:admin'])->group(function () {
    // ... other admin routes
    Route::get('booking-requests', [AdminBookingRequestController::class, 'index'])->name('admin.booking-requests.index');
    Route::get('booking-requests/{id}', [AdminBookingRequestController::class, 'show'])->name('admin.booking-request.show');
    Route::post('booking-requests/{request}/approve', [AdminBookingRequestController::class, 'approve'])->name('admin.booking-requests.approve');
    Route::post('booking-requests/{request}/reject', [AdminBookingRequestController::class, 'reject'])->name('admin.booking-requests.reject');
});


//user management routes
// NEW: Routes for managing standard users
Route::name('admin.')->prefix('admin')->middleware(['auth:admin'])->group(function() {
    Route::resource('users', AdminUserController::class);

    // NEW: Routes for managing provider users
    Route::resource('provider-users', AdminProviderUserController::class)->names([
        'index' => 'provider-users.index',
        'create' => 'provider-users.create',
        'store' => 'provider-users.store',
        'show' => 'provider-users.show',
        'edit' => 'provider-users.edit',
        'update' => 'provider-users.update',
        'destroy' => 'provider-users.destroy',
    ]);
});

// Admin notificaiton routes
Route::group(['prefix' => 'admin', 'middleware' => ['auth:admin']], function (){
    // Endpoint to fetch notification counts
    Route::get('/api/notifications/counts', [App\Http\Controllers\Admin\AdminNotificationController::class, 'getUnreadCounts'])->name('admin.notifications.counts');
    
    // Optional endpoint to mark as read on click
    // Route::post('/api/notifications/mark-read/{category}', [App\Http\Controllers\Admin\AdminNotificationController::class, 'markCategoryAsRead']);
});


// --- ADMIN ROUTES ---
Route::prefix('admin')->name('admin.')->group(function () {
    // ... your other admin routes
    
    // NEW: Admin Reporting Route
    Route::get('reports', [ReportController::class, 'adminReports'])->name('reports.index');
})->middleware(['auth:admin']);



