<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MedicalImageController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AssignmentController;

use App\Http\Controllers\Admin\MedicalImageController as AdminMedicalImageController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::middleware(['auth', 'role:hospital|customer'])->group(function () {
    Route::get('uploads/new', [MedicalImageController::class, 'create'])->name('uploads.create');
    Route::post('uploads', [MedicalImageController::class, 'store'])->name('uploads.store');
});



Route::middleware(['auth', 'role:admin|super-admin'])
     ->prefix('admin')
     ->name('admin.')
     ->group(function () {
         // Show “assign to reader” form for one batch
         Route::get('images/{batch_no}/assign', [AssignmentController::class, 'showBatch'])
              ->name('images.assign');

         // Handle form submission to actually create assignments
         Route::post('images/{batch_no}/assign', [AssignmentController::class, 'storeBatch'])
              ->name('images.assign.store');
});





// Route to show the “assign to reader” UI for a given batch
Route::middleware(['auth', 'role:admin|super-admin'])
     ->prefix('admin')
     ->name('admin.')
     ->group(function () {
         // Existing batch index
         Route::get('images', [\App\Http\Controllers\Admin\MedicalImageController::class, 'index'])
              ->name('images.index');

         // New route for assigning a batch to a reader
         Route::get('images/{batch_no}/assign', [AssignmentController::class, 'showBatch'])
              ->name('assign.reader');
         Route::get('assignments', [AssignmentController::class, 'indexAssignedList'])
              ->name('assignments.index');
         Route::get('assignments/{batch_no}/download', [AssignmentController::class, 'downloadBatch'])
              ->name('assignments.download');

         // Clients list
         Route::get('users/clients', [AdminUserController::class, 'clients'])
              ->name('users.clients');

         // Hospitals list
         Route::get('users/hospitals', [AdminUserController::class, 'hospitals'])
              ->name('users.hospitals');

         // Readers list
         Route::get('users/readers', [AdminUserController::class, 'readers'])
              ->name('users.readers');

        //  Route::get('/images/assign', [AssignmentController::class, 'showBatch'])->name('images.assign');
// Show create‐reader form
Route::get('users/readers/create', [AdminUserController::class, 'createReader'])
     ->name('users.readers.create');

// Handle form submission
Route::post('users/readers', [AdminUserController::class, 'storeReader'])
     ->name('users.readers.store');


     });
// routes/web.php or routes/admin.php (depending on your setup)




// Reader routes
Route::middleware(['auth', 'role:reader'])
     ->prefix('reader')
     ->name('reader.')
     ->group(function () {
         // List all batches assigned to this reader
         Route::get('assignments', [\App\Http\Controllers\Reader\AssignmentController::class, 'index'])
              ->name('assignments.index');

         // Download original ZIP for a batch
         Route::get('assignments/{batch_no}/download', [\App\Http\Controllers\Reader\AssignmentController::class, 'downloadBatch'])
              ->name('assignments.download');

         // Show form to create report for a batch
         Route::get('assignments/{batch_no}/report', [\App\Http\Controllers\Reader\AssignmentController::class, 'createReport'])
              ->name('assignments.report.create');

         // Handle report submission
         Route::post('assignments/{batch_no}/report', [\App\Http\Controllers\Reader\AssignmentController::class, 'storeReport'])
              ->name('assignments.report.store');
     });
require __DIR__.'/auth.php';
