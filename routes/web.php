<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;

// ========================================
// LANDING PAGE
// ========================================
Route::get('/', function () {
    return view('landing');
})->name('home');

// ========================================
// AUTH ROUTES (dari Breeze/Fortify)
// ========================================
require __DIR__ . '/auth.php';

// ========================================
// DASHBOARD (Auto redirect berdasarkan role)
// ========================================
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

// ========================================
// CUSTOMER ROUTES
// ========================================
Route::middleware(['auth', 'role:customer'])->prefix('customer')->name('customer.')->group(function () {
    Route::get('/menu', [CustomerController::class, 'menu'])->name('menu');
});

// ========================================
// ORDER ROUTES (semua user yang login)
// ========================================
Route::middleware(['auth'])->group(function () {
    // Halaman Konfirmasi Order
    Route::get('/order', [OrderController::class, 'show'])->name('order.show');

    // Proses Order (simpan ke database)
    Route::post('/order', [OrderController::class, 'store'])->name('order.store');

    // Halaman Sukses
    Route::get('/order-success', [OrderController::class, 'success'])->name('order.success');
});
