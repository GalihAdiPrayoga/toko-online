<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('pembeli.dashboard');
})->name('pembeli.dashboard');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/redirect', function () {
    if (auth()->user()->role === 'penjual') {
        return redirect('/penjual/dashboard');
    }
    return redirect('/pembeli/dashboard');
})->middleware('auth');

Route::middleware(['auth', 'role:penjual'])->prefix('penjual')->group(function () {
    Route::get('/dashboard', function () {
        return view('penjual.dashboard');
    })->name('penjual.dashboard');
});

// Public routes for pembeli
Route::prefix('pembeli')->group(function () {
    // Route publik pembeli di sini
    // Route::get('/products', [ProductController::class, 'index'])->name('pembeli.products');
});

// Auth routes for pembeli
Route::middleware(['auth', 'role:pembeli'])->prefix('pembeli')->group(function () {
    // Fitur pembeli yang memerlukan login
    // Route::get('/orders', [OrderController::class, 'index'])->name('pembeli.orders');
    // Route::post('/checkout', [CheckoutController::class, 'store'])->name('pembeli.checkout');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
