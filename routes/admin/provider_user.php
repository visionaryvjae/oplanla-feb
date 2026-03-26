<?php
// routes/web.php

use App\Http\Controllers\Provider\Auth\LoginController;
use App\Http\Controllers\Provider\Auth\RegisterController;
use App\Http\Controllers\Provider\DashboardController;
use App\Http\Controllers\Provider\RoomsController;
use App\Http\Controllers\Provider\RoomsBookingController;
use App\Http\Controllers\Provider\PhotoController;
use App\Http\Controllers\Booking\ProviderContactsController;
use App\Http\Controllers\Provider\PaymentController;
use App\Http\Controllers\Provider\ReportController;
use App\Http\Controllers\Provider\ProviderPasswordResetController;
use App\Http\Controllers\Booking\EnquiryResponseController;
use App\Http\Controllers\Reports\ReportController as ProviderReportController;
use App\Models\Booking\Enquiry;
use App\Http\Controllers\Provider\UtilityController;
use App\Http\Controllers\Provider\MaintenanceController;
use App\Http\Controllers\Provider\ChargeController;
use App\Http\Controllers\Provider\PropertyController;
use App\Http\Controllers\Provider\MeterController;
use App\Http\Controllers\Provider\MaintenanceUserController;
use App\Http\Controllers\Provider\TicketController;
use App\Http\Controllers\Provider\TenantController;
use App\Http\Controllers\Provider\PotentialTenantsController;
use App\Http\Controllers\Provider\BulkNotificationController;
use App\Http\Controllers\Provider\RentalPaymentController;


// Provider Routes
Route::prefix('provider')->name('provider.')->group(function () {
    // Guest routes (for users who are not logged in)
    Route::middleware(['guest:provider'])->group(function() {
        // Registration Routes
        Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
        Route::post('register', [RegisterController::class, 'register']);

        Route::get('verification', function() {
            return view('providers.auth.user_verification');
        })->name('verification');

        // Login Routes
        Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
        Route::post('login', [LoginController::class, 'login']);
            
            
        });
        
        
        Route::middleware(['auth:provider'])->group(function () {
        // ... other provider routes
        Route::get('payment-history', [PaymentController::class, 'index'])->name('payments.index');
        Route::get('performance-reports', [ReportController::class, 'index'])->name('reports.index');
    
    
        
    });
    
    
    // Provider Enquiry Routes
    Route::middleware(['auth:provider'])->group(function(){
        Route::get('/enquiries', [EnquiryResponseController::class, 'index'])->name('enquiries.index');
        
        Route::get('/enquiry/{id}', [EnquiryResponseController::class, 'show'])->name('enquiry.show');
        Route::get('/enquiry/{enquiry}/respond', [EnquiryResponseController::class, 'showResponseForm'])->name('enquiry.respond')->middleware(['auth:provider']);
        Route::post('/enquiry/{enquiry}/respond', [EnquiryResponseController::class, 'storeReply'])->name('enquiry.reply.store');
        Route::post('/enquiry/{enquiry}/potential-tenant', [EnquiryResponseController::class, 'markAsPotentialTenant'])->name('enquiry.mark.potential.tenant'); 

        Route::post('enquiry/request-document-upload/{enquiryId}', [EnquiryResponseController::class, 'requestDocuments'])->name('enquiry.request.documents.upload');
    });

    Route::prefix('potential-tenants')->name('potential-tenant.')->group(function() {
        Route::get('', [PotentialTenantsController::class, 'index'])->name('index');
        Route::get('{providerId}', [PotentialTenantsController::class, 'show'])->name('show');
        Route::get('accept/{providerId}', [PotentialTenantsController::class, 'accept'])->name('accept');
        Route::post('reject/{providerId}', [PotentialTenantsController::class, 'reject'])->name('reject');
        Route::get('documents-show', [PotentialTenantsController::class, ''])->name('doc.show');
    })->middleware(['auth:provider']);

    Route::get('documents-show', [PotentialTenantsController::class, 'showDocument'])->name('doc.show')->middleware(['auth:provider']);

    

    // Authenticated Routes
    Route::middleware(['auth:provider'])->group(function () {
        Route::post('logout', [LoginController::class, 'logout'])->name('logout');
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        // Add other provider routes here
    });
});

Route::middleware(['guest:provider'])->group(function () {
    // Request Link Form
    Route::get('provider/forgot-password', [ProviderPasswordResetController::class, 'create'])
        ->name('provider.password.request');

    // Handle Request Link
    Route::post('provider/forgot-password', [ProviderPasswordResetController::class, 'store'])
        ->name('provider.password.email');

    // Reset Password Form
    Route::get('provider/reset-password/{token}', [ProviderPasswordResetController::class, 'edit'])
        ->name('provider.password.reset');

    // Handle Reset Password
    Route::post('provider/reset-password', [ProviderPasswordResetController::class, 'update'])
        ->name('provider.password.update');
});



//room provider routes
Route::prefix('provider')->name('provider.')->group(function() {
    Route::get('rooms', [RoomsController::class, 'index'])->name('rooms.index');
    Route::get('room/{id}', [RoomsController::class, 'viewSingleProvider'])->name('rooms.single');
    Route::get('rooms/create', [RoomsController::class, 'create'])->name('rooms.create');
    Route::get('rooms/create/{id}', [RoomsController::class, 'createSingle'])->name('rooms.create.single');
    Route::post('rooms/store', [RoomsController::class, 'store'])->name('rooms.store');
    Route::get('rooms/edit/{id}', [RoomsController::class, 'edit'])->name('rooms.edit');
    Route::post('rooms/update/{id}', [RoomsController::class, 'update'])->name('rooms.update');
    Route::delete('rooms/delete/{id}', [RoomsController::class, 'delete'])->name('rooms.delete');
})->middleware(['auth:provider']);

//room facilities routes
Route::middleware(['auth:provider'])->group(function() {
    Route::get('provider/rooms/facilities/create/{id}', [RoomFacilitiesController::class, 'create'])->name('provider.facility.create');
    Route::post('provider/rooms/facilities/store/{id}', [RoomFacilitiesController::class, 'store'])->name('provider.facility.store');
});

//providers
Route::middleware(['auth:provider'])->group(function() {
    Route::get('provider/providers/edit/{id}', [ProvidersController::class, 'edit'])->name('providers.edit');
    Route::post('provider/providers/update/{id}', [ProvidersController::class, 'update'])->name('providers.update');
    Route::delete('provider/providers/delete/{id}', [ProvidersController::class, 'delete'])->name('providers.delete');    
});

Route::middleware(['auth:provider'])->name('provider.')->prefix('provider')->group(function() {
    Route::resource('tenants', TenantController::class);
});


//booking routes
Route::middleware(['auth:provider'])->group(function() {
    Route::get('provider/room_booking', [RoomsBookingController::class, 'index'])->name('room.booking.index.provider');
    Route::get('provider/room_booking/{id}', [RoomsBookingController::class, 'viewSingleProvider'])->name('provider.room.booking.show');
    // Route::get('room_booking/create', [RoomsBookingController::class, 'create'])->name('provider.room.booking.create');
    // Route::post('room_booking/store', [RoomsBookingController::class, 'store'])->name('provider.room.booking.store'); //->middleware(['auth', HandlePayment::class])
    Route::get('provider/room_booking/edit/{id}', [RoomsBookingController::class, 'edit'])->name('provider.room.booking.edit');
    Route::post('provider/room_booking/update/{id}', [RoomsBookingController::class, 'update'])->name('provider.room.booking.update');
    Route::get('provider/room_booking/delete/{id}', [RoomsBookingController::class, 'delete'])->name('provider.room.booking.delete');
    Route::post('provider/room_booking/end/{id}', [RoomsBookingController::class, 'end_booking'])->name('provider.room.booking.end');
    Route::get('provider/room_booking/cancel/{id}', [RoomsBookingController::class, 'cancel_booking'])->name('provider.room.booking.cancel');
});


//image routes
Route::middleware(['auth:provider'])->group(function() {
    Route::get('provider/{pid}/images', [PhotoController::class, 'index'])->name('provider.image.index');
    Route::get('provider/{pid}/images/create', [PhotoController::class, 'create'])->name('provider.image.create');
    Route::post('provider/{pid}/images/store', [PhotoController::class, 'store'])->name('provider.image.store');
    Route::get('provider/{pid}/images/{id}', [PhotoController::class, 'show'])->name('provider.image.show');
    Route::get('provider/{pid}/images/edit/{id}', [PhotoController::class, 'edit'])->name('provider.image.edit');
    Route::post('provider/{pid}/images/update/{id}', [PhotoController::class, 'update'])->name('provider.image.update');
    Route::delete('provider/{pid}/images/delete/{id}', [PhotoController::class, 'delete'])->name('provider.image.delete');
});


// --- PROVIDER REPORTING ROUTES ---
// Assuming you have a group for authenticated provider users
Route::prefix('provider')->name('provider.')->group(function () {
    // ... your other provider routes 

    // NEW: Provider-specific Reporting Route
    Route::get('reports', [ProviderReportController::class, 'providerReports'])->name('reports.index');
})->middleware(['auth:provider']);


//PROVIDER PAYMENTS ROUTES
Route::prefix('provider/payments')->name('provider.payments.')->group(function() {
    Route::get('/', [RentalPaymentController::class, 'index'])->name('index');
    Route::get('/payments/{id}', [RentalPaymentController::class, 'show'])->name('show');
    Route::get('/pending', [RentalPaymentController::class, 'pending'])->name('pending');
    // Provider Payment Inspection Routes 
    Route::post('/payments/{id}/verify', [RentalPaymentController::class, 'verify'])->name('verify');
    Route::get('/payments/{id}/view', [RentalPaymentController::class, 'view'])->name('view');
    Route::get('/payments/{id}/stream', [RentalPaymentController::class, 'streamPoP'])->name('stream');
})->middleware(['auth:provider']);

// Provider Payment Reports
Route::middleware(['auth:provider'])->prefix('provider')->group(function () {
    Route::get('/reports/payments/download', [ReportController::class, 'downloadPaymentReport'])
        ->name('provider.reports.payments.download');
});

//PROVIDER UTILITIES ROUTES
Route::prefix('provider/utilities')->name('provider.')->group(function() {
    Route::get('/import', [UtilityController::class, 'showImport'])->name('utilities.import');
    Route::post('/analyze', [UtilityController::class, 'analyze'])->name('utilities.analyze');
    Route::post('/bulk-dispatch', [UtilityController::class, 'bulkDispatch'])->name('utilities.send-invoices');
})->middleware(['auth:provider']);


//PROVIDER MAINTENANCE ROUTES
Route::prefix('provider/maintenance')->name('provider.maintenance.')->group(function() {
    //Jobs
   Route::get('jobs', [MaintenanceController::class, 'index'])->name('jobs.index');
   Route::get('jobs/{job}', [MaintenanceController::class, 'show'])->name('jobs.show');
   Route::get('jobs/{job}/create', [MaintenanceController::class, 'createTicket'])->name('create.ticket');
    // Manager assigns a staff member to a job (Creates Ticket)
    Route::post('/jobs/{job}/assign', [MaintenanceController::class, 'assignTicket'])->name('assign');
})->middleware(['auth:provider']);

//PROVIDER TICKET ROUTES
Route::prefix('provider/maintenance')->name('provider.maintenance.')->group(function() {
    //Jobs
   Route::get('tickets', [TicketController::class, 'index'])->name('tickets.index');
   Route::get('tickets/{ticket}', [TicketController::class, 'show'])->name('tickets.show');
})->middleware(['auth:provider']);


//PROVDERS CHARGES CONTROLLER ROUTES
Route::prefix('provider')->name('provider.')->group(function () {
    Route::resource('charges', ChargeController::class)
    ->except(['update']);

    Route::post('charges/update/{charge}', [ChargeController::class, 'update'])->name('charges.update');
});


//PROVDERS PROPERTIES ROUTES
Route::prefix('provider')->name('provider.')->group(function () {
    Route::resource('properties', PropertyController::class)
    ->except(['update']);

    Route::post('properties/update/{property}', [PropertyController::class, 'update'])->name('properties.update');
});

//PROVDERS METER ROUTES
Route::prefix('provider')->name('provider.')->group(function () {
    Route::resource('meters', MeterController::class)
    ->except(['update']);

    Route::post('meters/update/{meter}', [MeterController::class, 'update'])->name('meters.update');
});


//PROVIDER BULK NOTIFICATIONS
Route::prefix('provider/bulk-notifications')->name('provider.bulk.notifications.')->group(function() {
    Route::get('/', [BulkNotificationController::class, 'index'])->name('index');
    Route::post('send', [BulkNotificationController::class, 'send'])->name('send');
})->middleware(['auth:provider']);


// --- Separate routes for Maintenance Staff & Tenants ---
Route::middleware(['auth:maintenance'])->prefix('staff')->group(function () {
    Route::post('/tickets/{ticket}/complete', [MaintenanceController::class, 'completeTicket'])->name('maintenance.complete');
});

Route::middleware(['auth'])->group(function () {
    Route::post('/maintenance/request', [MaintenanceController::class, 'storeJob'])->name('maintenance.request');
});

//Maintenance user management routes
// NEW: Routes for managing technician users
Route::name('provider.')->prefix('provider')->middleware(['auth:provider'])->group(function() {
    Route::resource('maintenance-users', MaintenanceUserController::class);
    // ->names([
    //     'index' => 'provider-users.index',
    //     'create' => 'provider-users.create',
    //     'store' => 'provider-users.store',
    //     'show' => 'provider-users.show',
    //     'edit' => 'provider-users.edit',
    //     'update' => 'provider-users.update',
    //     'destroy' => 'provider-users.destroy',
    // ]);
});


//Tenant request documents upload


//contacts routes
Route::get('provider/{pid}/contacts/create', [ProviderContactsController::class, 'create'])->name('contact.create');
Route::post('provider/{pid}/contacts/store', [ProviderContactsController::class, 'store'])->name('contact.store');
Route::get('provider/{pid}/contact/edit/{id}', [ProviderContactsController::class, 'edit'])->name('contact.edit');
Route::post('provider/{pid}/contact/update/{id}', [ProviderContactsController::class, 'update'])->name('contact.update');
Route::delete('provider/{pid}/contact/delete/{id}', [ProviderContactsController::class, 'delete'])->name('contact.delete');


