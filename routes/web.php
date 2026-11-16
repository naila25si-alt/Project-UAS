<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BookingController;
use Illuminate\Support\Facades\Route;


Route::get('/', fn () => redirect()->route('login'));

Route::get('/login', [LoginController::class, 'show'])->name('login');
Route::post('/login', [LoginController::class, 'store'])->name('login.store');

// Placeholder dulu supaya link di halaman login tidak error
Route::get('/forgot-password', fn () => 'Halaman lupa password (menyusul)')->name('password.request');
Route::get('/contact-admin', fn () => 'Halaman kontak admin (menyusul)')->name('contact.admin');
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', fn () => redirect()->route('booking.create'))->name('dashboard');

Route::get('/booking/create', [BookingController::class, 'create'])->name('booking.create');
Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');

    Route::post('/logout', function (\Illuminate\Http\Request $request) {
        \Illuminate\Support\Facades\Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    })->name('logout');
});
