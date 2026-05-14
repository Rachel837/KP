<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\Role;
use App\Http\Controllers\JadwalController;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/home', function () {
    $role = auth()->user()->role->nama ?? '';
    
    if ($role === 'super_admin' || $role === 'admin') {
        return redirect()->route('admin.dashboard');
    }

    if ($role === 'koor') {
        return redirect()->route('koor.dashboard');
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
    
    if ($role === 'super_admin' || $role === 'admin') {
        return redirect()->route('admin.dashboard');
    }

    if ($role === 'koor') {
        return redirect()->route('koor.dashboard');
    }

    if ($role === 'karyawan') {
        return redirect()->route('karyawan.dashboard');
    }

    return view('starter');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Admin routes
    Route::middleware('role:super_admin')->prefix('admin')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');
        Route::resource('/users', \App\Http\Controllers\Admin\UserController::class);
    });

    // Koor routes
    Route::middleware('role:koor')->prefix('koor')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Koor\DashboardController::class, 'index'])->name('koor.dashboard');
        Route::get('/laporan-bulanan', [\App\Http\Controllers\Koor\LaporanController::class, 'bulanan'])->name('laporan.bulanan');
        Route::resource('/laporan', \App\Http\Controllers\Koor\LaporanController::class);
        Route::resource('/users', \App\Http\Controllers\Koor\UserController::class)->names('koor.users');
    });

    // Karyawan routes
    Route::middleware('role:karyawan')->prefix('karyawan')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Karyawan\DashboardController::class, 'index'])->name('karyawan.dashboard');
        Route::get('/laporan-bulanan', [\App\Http\Controllers\Karyawan\LaporanController::class, 'bulanan'])->name('karyawan.laporan.bulanan');
        Route::resource('/laporan', \App\Http\Controllers\Karyawan\LaporanController::class)->names('karyawan.laporan');
    });
});


require __DIR__.'/auth.php';
