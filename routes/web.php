<?php

use App\Http\Controllers\ProfileController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\BookingController;

Route::get('/', function () {
    return view('home.index');
})->name('home');

// Room Routes - Public access
Route::get('/rooms/available', [RoomController::class, 'available'])->name('rooms.available');

Route::middleware([AdminMiddleware::class, 'auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.index');
    })->name('dashboard');

    Route::resource('rooms', RoomController::class);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');
});

// Payment Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/payments/create/{booking}', [App\Http\Controllers\PaymentController::class, 'create'])->name('payments.create');
    Route::post('/payments/{booking}', [App\Http\Controllers\PaymentController::class, 'store'])->name('payments.store');
    Route::get('/payments/receipt/{payment}', [App\Http\Controllers\PaymentController::class, 'receipt'])->name('payments.receipt');
});

// Booking Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/bookings/create/{room}', [BookingController::class, 'create'])->name('bookings.create');
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/{booking}', [BookingController::class, 'show'])->name('bookings.show');
});

require __DIR__.'/auth.php';
