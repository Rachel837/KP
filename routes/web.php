<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/home', function () {
    return view('starter');
})->middleware('auth')->name('home');

// Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
// Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login.process');
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/dashboard', function () {
    return view('starter');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    

});

require __DIR__.'/auth.php';
