<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ShopController;

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
    // Halaman slider warung
    Route::get('/menu', [CustomerController::class, 'menu'])->name('menu');
});

// ========================================
// SHOP ROUTES (Halaman detail warung)
// ========================================
Route::middleware(['auth'])->group(function () {
    // Halaman detail menu per warung (shop-detail.blade.php)
    Route::get('/shop/{shop_id}', [ShopController::class, 'detail'])->name('shop.detail');
});

// ========================================
// PROFILE ROUTES
// ========================================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ========================================
// CART ROUTES
// ========================================
Route::middleware(['auth'])->group(function () {
    // Tambah item ke keranjang
    Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');

    // Lihat isi keranjang
    Route::get('/keranjang', [CartController::class, 'index'])->name('cart.index');

    // Hapus item dari keranjang
    Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
});

// ========================================
// ORDER ROUTES
// ========================================
Route::middleware(['auth'])->group(function () {
    // Halaman Konfirmasi Order (order-confirm.blade.php)
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
    Route::get('/{transaction}', [TransactionController::class, 'show'])->name('show');
    Route::patch('/{transaction}/status', [TransactionController::class, 'updateStatus'])
        ->name('update-status')
        ->middleware('role:admin_kantin,admin_web');
    Route::patch('/{transaction}/cancel', [TransactionController::class, 'cancel'])->name('cancel');
});
