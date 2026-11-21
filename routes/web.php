<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DoctorProfileController;

Route::get('/', fn () => redirect()->route('login'));

Route::middleware(['auth', 'active'])->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // --- Step 5: Patients (uncomment after PatientController is created) ---
    // Route::resource('patients', PatientController::class);
    // Route::get('patients/{patient}/history', [PatientController::class, 'history'])->name('patients.history');
});

/*
|--------------------------------------------------------------------------
| Doctor + Admin
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'active', 'role:doctor,admin'])->group(function () {
    // Routes shared by doctors and admins go here (medicines, prescriptions…)
});

/*
|--------------------------------------------------------------------------
| Doctor only
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'active', 'role:doctor'])->group(function () {
    Route::get('/doctor-profile', [DoctorProfileController::class, 'edit'])->name('doctor-profile.edit');
    Route::put('/doctor-profile', [DoctorProfileController::class, 'update'])->name('doctor-profile.update');
});

/*
|--------------------------------------------------------------------------
| Admin only
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'active', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::resource('users', UserController::class)->except(['show', 'destroy']);

    Route::patch('users/{user}/toggle-active', [UserController::class, 'toggleActive'])->name('users.toggle-active');

    // --- Step 6: Medicines (uncomment after MedicineController is created) ---
    // Route::resource('medicines', MedicineController::class)->except(['show']);
    // Route::post('medicines/import', [MedicineImportController::class, 'store'])->name('medicines.import');

    
});

require __DIR__.'/auth.php';