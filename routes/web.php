<?php


use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BookingController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FacilityController;

// Halaman awal sementara langsung ke booking agar dapat diuji tanpa login.
Route::get('/', fn () => redirect()->route('booking.index'));

// Route login yang sudah ada tetap dipertahankan.
Route::get('/login', [LoginController::class, 'show'])->name('login');
Route::post('/login', [LoginController::class, 'store'])->name('login.store');

// Booking sementara dapat dibuka tanpa login.
Route::get('/booking', [BookingController::class, 'index'])->name('booking.index');
Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');
Route::get('/my-bookings', [BookingController::class, 'myBookings'])->name('booking.history');

// Alias dashboard sementara menuju halaman booking.
Route::get('/dashboard', [BookingController::class, 'dashboard'])
    ->name('dashboard');

Route::post('/logout', function (\Illuminate\Http\Request $request) {
    \Illuminate\Support\Facades\Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('login');
})->name('logout');

Route::get('/studios', [FacilityController::class, 'studios'])
    ->name('studios.index');

Route::get('/equipment', [FacilityController::class, 'equipment'])
    ->name('equipment.index');

Route::get('/help', [FacilityController::class, 'help'])
    ->name('help.index');
// 1. Menampilkan halaman Form Booking (Setelah klik tombol Booking di Dashboard)
Route::get('/booking', [BookingController::class, 'create'])->name('booking.create');

// 2. Mengirim data dari Form Booking ke Halaman Review
Route::post('/booking/review', [BookingController::class, 'review'])->name('booking.review');

// 3. Menyimpan data final ke Database dari Halaman Review
Route::post('/booking/store', [BookingController::class, 'store'])->name('booking.store');
