<?php

use App\Http\Controllers\ProfileController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoomController;





Route::get('/', function () {
    return view('home.index');
})->name('home');
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

require __DIR__.'/auth.php';
