<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\FacilityController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('dashboard'));

// Route login yang sudah ada tetap dipertahankan.
Route::get('/login', [LoginController::class, 'show'])->name('login');
Route::post('/login', [LoginController::class, 'store'])->name('login.store');

Route::middleware('auth')->group(function () {
    Route::get('/booking', [BookingController::class, 'index'])->name('booking.index');
    Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');
    Route::get('/my-bookings', [BookingController::class, 'myBookings'])->name('booking.history');
    Route::patch('/admin/bookings/{booking}/status', [BookingController::class, 'updateStatus'])
        ->name('admin.bookings.status');
    Route::get('/dashboard', [BookingController::class, 'dashboard'])->name('dashboard');

    Route::post('/logout', function (Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    })->name('logout');
});

Route::get('/studios', [FacilityController::class, 'studios'])
    ->name('studios.index');

Route::get('/equipment', [FacilityController::class, 'equipment'])
    ->name('equipment.index');

Route::get('/help', [FacilityController::class, 'help'])
    ->name('help.index');
