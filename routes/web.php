<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\Role;
use App\Http\Controllers\JadwalController;

use App\Http\Controllers\GuestDashboardController;

Route::get('/', [GuestDashboardController::class, 'index'])->name('guest.dashboard');

Route::get('/home', function () {
    $role = auth()->user()->role->nama ?? '';
    
    if ($role === 'koor') {
        return redirect()->route('karyawan.dashboard');
    }

    if ($role === 'karyawan') {
        return redirect()->route('karyawan.dashboard');
    }

    return view('starter');
})->middleware('auth')->name('home');

Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login.process');
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/dashboard', function () {
    $role = auth()->user()->role->nama ?? '';
    

    if ($role === 'koor') {
        return redirect()->route('karyawan.dashboard');
    }

    if ($role === 'karyawan') {
        return redirect()->route('karyawan.dashboard');
    }

    return view('starter');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/tv-show', [\App\Http\Controllers\TvShowController::class, 'index'])->name('tv.show');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    // Koor routes (Exclusive to Koor)
    Route::middleware('role:koor')->prefix('koor')->group(function () {
        Route::get('/laporan-bulanan', [\App\Http\Controllers\Koor\LaporanController::class, 'bulanan'])->name('laporan.bulanan');
        Route::resource('/users', \App\Http\Controllers\Koor\UserController::class)->names('koor.users');
    });

    // Karyawan & Koor routes (Shared)
    Route::middleware('role:karyawan,koor')->prefix('karyawan')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Karyawan\DashboardController::class, 'index'])->name('karyawan.dashboard');
        Route::get('/jadwal/booked-slots', [\App\Http\Controllers\Karyawan\JadwalController::class, 'getBookedSlots'])->name('karyawan.jadwal.booked-slots');
        Route::resource('/laporan', \App\Http\Controllers\Karyawan\LaporanController::class)->names('karyawan.laporan');
        Route::resource('/jadwal', \App\Http\Controllers\Karyawan\JadwalController::class)->names('karyawan.jadwal');
    });
});


require __DIR__.'/auth.php';
