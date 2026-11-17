<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Storefront (Pengunjung & Pelanggan)
|--------------------------------------------------------------------------
*/
Route::get('/', HomeController::class)->name('home');

// Setelah login/registrasi, Breeze mengarah ke route 'dashboard'.
// Owner & Staf dialihkan ke Seller Centre, Pelanggan ke halaman Akun Saya.
Route::get('/dashboard', function () {
    if (auth()->user()->isAdmin()) {
        return redirect()->route('admin.dashboard');
    }

    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Seller Centre (Owner & Staf)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:owner,staff'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', AdminDashboardController::class)->name('dashboard');

    // Khusus Owner
    Route::middleware('role:owner')->group(function () {
        Route::get('/staf', [StaffController::class, 'index'])->name('staff.index');
        Route::get('/staf/tambah', [StaffController::class, 'create'])->name('staff.create');
        Route::post('/staf', [StaffController::class, 'store'])->name('staff.store');
        Route::patch('/staf/{staff}/status', [StaffController::class, 'toggle'])->name('staff.toggle');
        Route::patch('/staf/{staff}/password', [StaffController::class, 'resetPassword'])->name('staff.password');
    });
});

require __DIR__.'/auth.php';
