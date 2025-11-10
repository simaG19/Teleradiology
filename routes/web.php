<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MedicalImageController;                      // uploader’s controller
use App\Http\Controllers\Admin\MedicalImageController as AdminImageController;  // admin’s controller


use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AssignmentController;
use App\Http\Controllers\Admin\FileTypeController;
use App\Http\Controllers\Admin\BatchController;
use Illuminate\Support\Facades\Route;


use App\Http\Controllers\Admin\MedicalImageController as AdminMedicalImageController;




use App\Http\Controllers\ChapaController;


Route::get('/', function(){ return view('welcome'); });




Route::post('/chapa/pay/{batch}', [ChapaController::class, 'initializeForBatch'])->name('chapa.pay');
Route::get('/chapa/callback/{id}', [ChapaController::class, 'callback'])->name('chapa.callback');
Route::get('/chapa/success/{batch}', [ChapaController::class, 'success'])->name('chapa.success');
Route::get('/chapa/cancel', [ChapaController::class, 'cancel'])->name('chapa.cancel');









Route::get('/', function () {
    return view('welcome');
})->name('home');

// In routes/web.php
Route::get('/dashboard', function () {
    if (Auth::check() && Auth::user()->hasRole('customer')) {
        return redirect()->route('uploads.create');
    }
     if (Auth::check() && Auth::user()->hasRole('admin')) {
        return redirect()->route('admin.images.index');
    }
     if (Auth::check() && Auth::user()->hasRole('hospital')) {
        return redirect()->route('hospital.dashboard');
    }
    return view('dashboard'); // or redirect elsewhere for other roles
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
// Route::middleware(['auth', 'role:hospital|customer'])->group(function () {
//     Route::get('uploads/new', [MedicalImageController::class, 'create'])->name('uploads.create');
//     Route::post('uploads', [MedicalImageController::class, 'store'])->name('uploads.store');
// });



Route::middleware(['auth', 'role:admin|super-admin'])
     ->prefix('admin')
     ->name('admin.')
     ->group(function () {
         // Show “assign to reader” form for one batch
        //  Route::get('images/{batch_no}/assign', [AssignmentController::class, 'showBatch'])
        //       ->name('images.assign');

        //  // Handle form submission to actually create assignments
        //  Route::post('images/{batch_no}/assign', [AssignmentController::class, 'storeBatch'])
        //       ->name('images.assign.store');
});





// Uploader (customer) routes
Route::middleware(['auth','role:customer'])
     ->group(function () {
         Route::get('uploads/new',   [MedicalImageController::class, 'create'])->name('uploads.create');
         Route::post('uploads',      [MedicalImageController::class, 'store'])->name('uploads.store');
         Route::get('uploads',       [MedicalImageController::class, 'index'])->name('uploads.index');
      // ★ New: show payment form for a batch
    Route::get('uploads/{batch}/pay', [MedicalImageController::class, 'showPaymentForm'])
         ->name('uploads.pay.form');


        });

// Admin routes
// Route::middleware(['auth','role:admin|super-admin'])
//      ->prefix('admin')
//      ->name('admin.')
//      ->group(function(){

//      });




// Route to show the “assign to reader” UI for a given batch

use App\Http\Controllers\Admin\HospitalController;
// Admin routes
Route::middleware(['auth', 'role:admin|super-admin'])
     ->prefix('admin')
     ->name('admin.')
     ->group(function () {

    // Medical images

         // … other admin/{images,…} routes …
    // Assignments
    Route::get('images/{batch_no}/assign', [AssignmentController::class, 'showBatch'])->name('assign.reader');
    Route::post('images/{batch_no}/assign', [AssignmentController::class, 'storeBatch'])->name('images.assign.store');

    Route::post('images/{batch_no}/assign', [AssignmentController::class, 'storeBatch'])->name('images.assign.store');
    Route::get('assignments', [AssignmentController::class, 'indexAssignedList'])->name('assignments.index');
    Route::get('assignments/{batch_no}/download', [AssignmentController::class, 'downloadBatch'])->name('assignments.download');
  Route::get('images', [AdminImageController::class, 'index'])->name('images.index');
    // User management
    Route::get('users/clients',   [AdminUserController::class, 'clients'])->name('users.clients');
    Route::get('users/readers',   [AdminUserController::class, 'readers'])->name('users.readers');
    Route::get('users/readers/create', [AdminUserController::class,'createReader'])->name('users.readers.create');
    Route::post('users/readers',  [AdminUserController::class, 'storeReader'])->name('users.readers.store');
    Route::get('users/hospitals', [AdminUserController::class, 'hospitals'])->name('users.hospitals');
    Route::get('users/hospitals/create',[AdminUserController::class,'createHospital'])->name('users.hospitals.create');
    Route::post('users/hospitals',[AdminUserController::class,'storeHospital'])->name('users.hospitals.store');

Route::get('hospitals/uploads', [HospitalController::class,'allUploads'])
     ->name('hospitals.uploads.all');
    Route::get('hospitals', [HospitalController::class, 'index'])
         ->name('hospitals.index');

    // Show create form
    Route::get('hospitals/create', [HospitalController::class, 'create'])
         ->name('hospitals.create');

    // Store newly created hospital (User + Profile)
    Route::post('hospitals', [HospitalController::class, 'store'])
         ->name('hospitals.store');

    // Show edit form — inject User by ID
    Route::get('hospitals/{user}/edit', [HospitalController::class, 'edit'])
         ->name('hospitals.edit');

    // Update hospital
    Route::put('hospitals/{user}', [HospitalController::class, 'update'])
         ->name('hospitals.update');

    // View details
    Route::get('hospitals/{user}', [HospitalController::class, 'show'])
         ->name('hospitals.show');

    // Delete hospital
    Route::delete('hospitals/{user}', [HospitalController::class, 'destroy'])
         ->name('hospitals.destroy');

    // Billing by User
    Route::get('hospitals/{user}/billing', [HospitalController::class, 'billingByUser'])
         ->name('hospitals.billing');
    // Billing page
   Route::get('hospitals/{user}/billing', [HospitalController::class, 'billingByUser'])
     ->name('hospitals.billing');


      // Custom activate/deactivate routes
        Route::put('hospitals/{hospital}/activate', [HospitalController::class, 'activate'])
            ->name('hospitals.activate');

        Route::put('hospitals/{hospital}/deactivate', [HospitalController::class, 'deactivate'])
            ->name('hospitals.deactivate');

        // Show all customer batches needing a quote
Route::get('batches', [BatchController::class, 'index'])
     ->name('batches.index');

Route::get('batches/{batch}/download', [BatchController::class,'download'])
     ->name('batches.download');

// Show form to set a price
Route::get('batches/{batch}/quote', [BatchController::class, 'editQuote'])
     ->name('batches.quote.edit');

// Handle quote submission
Route::post('batches/{batch}/quote', [BatchController::class,'updateQuote'])
     ->name('batches.quote.update');



Route::resource('file-types', FileTypeController::class, [
    'as'   => 'admin',         // so routes are named admin.file-types.*
    'names'=> [
      'index'   => 'file_types.index',
      'create'  => 'file_types.create',
      'store'   => 'file_types.store',
      'edit'    => 'file_types.edit',
      'update'  => 'file_types.update',
      'destroy' => 'file_types.destroy',
    ],
]);


});



   use App\Http\Controllers\Hospital\UploaderController;
use App\Http\Controllers\Hospital\DashboardController;

Route::middleware(['auth', 'role:hospital'])
     ->prefix('hospital')
     ->name('hospital.')
     ->group(function () {
         Route::get('dashboard', [DashboardController::class, 'dashboard'])
              ->name('dashboard');
         Route::resource('uploaders', UploaderController::class);
            // Route::resource('uploaders', UploaderController::class);

 });



 use App\Http\Controllers\Hospital\UploaderAuthController;

// Uploader auth
Route::prefix('uploader')->name('uploader.')->group(function(){
    // Show login form
    Route::get('login', [UploaderAuthController::class, 'showLoginForm'])
         ->name('login');
    // Handle login
    Route::post('login', [UploaderAuthController::class, 'login'])
         ->name('login.submit');
    // Logout
    Route::post('logout', [UploaderAuthController::class, 'logout'])
         ->name('logout');
});





use App\Http\Controllers\Hospital\UploaderDashboardController;

Route::middleware('auth:uploader')
     ->prefix('uploader')
     ->name('uploader.')
     ->group(function(){
         // Dashboard = list of uploads
         Route::get('dashboard', [UploaderDashboardController::class, 'index'])
              ->name('dashboard');

         // New upload
         Route::get('uploads/create', [UploaderDashboardController::class, 'create'])
              ->name('uploads.create');
         Route::post('uploads', [UploaderDashboardController::class, 'store'])
              ->name('uploads.store');

          // routes/web.php (inside uploader route group)
Route::get('uploads/{batch}/reports', [\App\Http\Controllers\Hospital\UploaderDashboardController::class, 'listReports'])
     ->name('uploader.uploads.reports.index');

Route::get('uploads/{batch}/reports/{report}', [\App\Http\Controllers\Hospital\UploaderDashboardController::class, 'downloadReport'])
     ->name('uploader.uploads.reports.download');


         // View single upload + report
         Route::get('uploads/{image}', [UploaderDashboardController::class, 'show'])
              ->name('uploads.show');
     });





     use App\Http\Controllers\PaymentController;

Route::get('/batches/{batch}/pay', [PaymentController::class, 'show'])->name('batches.pay'); // already showing blade
Route::post('/create-checkout-session/{batch}', [PaymentController::class, 'createCheckoutSession'])->name('checkout.create');
Route::get('/payments/success/{batch}', [PaymentController::class, 'success'])->name('payments.success');
Route::get('/payments/cancel', [PaymentController::class, 'cancel'])->name('payments.cancel');

// webhook (no CSRF)
Route::post('/stripe/webhook', [PaymentController::class, 'webhook'])->name('stripe.webhook');









Route::middleware(['auth', 'role:reader'])
     ->prefix('reader')
     ->name('reader.')
     ->group(function () {
         // List all batches
         Route::get('assignments', [\App\Http\Controllers\Reader\AssignmentController::class, 'index'])
              ->name('assignments.index');
 Route::get('assignments/{batch_no}/report', [\App\Http\Controllers\Reader\AssignmentController::class, 'createReport'])
              ->name('assignments.report.create');
         // Download ZIP
         Route::get('assignments/{batch_no}/download', [\App\Http\Controllers\Reader\AssignmentController::class, 'downloadBatch'])
              ->name('assignments.download');

         // Create report form

         Route::post('assignments/{batch_no}/report', [\App\Http\Controllers\Reader\AssignmentController::class, 'storeReport'])
              ->name('assignments.report.store');

         // ★ New “View” route ★
         Route::get('assignments/{batch_no}/view', [\App\Http\Controllers\Reader\AssignmentController::class, 'viewBatch'])
              ->name('assignments.view');
     });

require __DIR__.'/auth.php';
