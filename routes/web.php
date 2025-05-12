<?php

use App\Http\Controllers\ProfileController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\Admin\DashboardController;
Route::get('/', function () {
    return view('home.index');
})->name('home');

// Room Routes - Public access
Route::get('/rooms/available', [RoomController::class, 'available'])->name('rooms.available');

Route::middleware([AdminMiddleware::class, 'auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
      Route::get('/reservations', [DashboardController::class, 'reservations'])->name('reservations');
    Route::resource('rooms', RoomController::class);
});

Route::middleware('auth')->group(function () {
    Route::get('/bookings/{booking}/print', [BookingController::class, 'print'])->name('bookings.print');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



// Payment Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/payments/create/{booking}', [App\Http\Controllers\PaymentController::class, 'create'])->name('payments.create');
    Route::post('/payments/{booking}', [App\Http\Controllers\PaymentController::class, 'store'])->name('payments.store');
    Route::get('/payments/receipt/{payment}', [App\Http\Controllers\PaymentController::class, 'receipt'])->name('payments.receipt');
});

// Booking Routes
Route::middleware(['auth'])->group(function () {
    Route::resource('bookings', BookingController::class);
});

require __DIR__.'/auth.php';
