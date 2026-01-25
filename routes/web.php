<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PembeliController;
use App\Http\Controllers\PenjualController;
use App\Http\Middleware\RoleMiddleware;

Route::get('/', function () {
    return view('pembeli.dashboard');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/redirect', function () {
    if (auth()->user()->role === 'penjual') {
        return redirect('/penjual/dashboard');
    }
    return redirect('/pembeli/dashboard');
})->middleware('auth');

Route::middleware(['auth', RoleMiddleware::class])->prefix('penjual')->group(function () {
    Route::get('/dashboard', function () {return view('penjual.dashboard');})->name('penjual.dashboard');
});

Route::middleware(['auth', RoleMiddleware::class])->prefix('pembeli')->group(function () {
    Route::get('/dashboard', function () {return view('pembeli.dashboard');})->name('pembeli.dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
