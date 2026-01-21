<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\TransactionController;

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

// ========================================
// TRANSACTION ROUTES
// ========================================
Route::middleware(['auth'])->prefix('transactions')->name('transactions.')->group(function () {

    // Lihat detail transaksi (semua role yang login bisa akses, tapi ada manual check di controller)
    Route::get('/{transaction}', [TransactionController::class, 'show'])->name('show');

    // Update status pesanan (hanya admin_kantin dan admin_web)
    Route::patch('/{transaction}/status', [TransactionController::class, 'updateStatus'])
        ->name('update-status')
        ->middleware('role:admin_kantin,admin_web');

    // Cancel pesanan (customer dan admin_kantin bisa akses, ada manual check di controller)
    Route::patch('/{transaction}/cancel', [TransactionController::class, 'cancel'])->name('cancel');

// ========================================
// VERIFICATION ROUTES
// ========================================
Route::get('/verify/{userId}', [VerificationController::class, 'notice'])->name('verification.notice');
Route::post('/verify/{userId}/phone', [VerificationController::class, 'verifyPhone'])->name('verification.verify-phone');
Route::get('/verify/{userId}/email/{code}', [VerificationController::class, 'verifyEmail'])->name('verification.verify-email');
Route::post('/verify/{userId}/resend-phone', [VerificationController::class, 'resendPhone'])->name('verification.resend-phone');
Route::post('/verify/{userId}/resend-email', [VerificationController::class, 'resendEmail'])->name('verification.resend-email');
});
