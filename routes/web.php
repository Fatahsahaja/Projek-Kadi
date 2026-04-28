<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\AdminWebController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AdminKantinController;

// ========================================
// LANDING PAGE
// ========================================
Route::get('/', function () {
    return view('landing');
})->name('home');

// ========================================
// AUTH ROUTES
// ========================================
require __DIR__ . '/auth.php';

// ========================================
// DASHBOARD
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
// SHOP ROUTES
// ========================================
Route::middleware(['auth'])->group(function () {
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
    Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
    Route::get('/keranjang', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
});

// ========================================
// ORDER ROUTES
// ========================================
Route::middleware(['auth'])->group(function () {
    Route::get('/order', [OrderController::class, 'show'])->name('order.show');
    Route::post('/order', [OrderController::class, 'store'])->name('order.store');
    Route::get('/order-success', [OrderController::class, 'success'])->name('order.success');
    Route::get('/order/status/{transaction}', [OrderController::class, 'checkStatus'])->name('order.checkStatus');
});

// ========================================
// NOTIFICATION ROUTES
// ========================================
Route::middleware(['auth', 'role:admin_kantin,admin_web'])->group(function () {
    Route::get('/admin/notifications', [TransactionController::class, 'checkNotifications'])->name('admin.notifications');
});
// ========================================
// ADMIN KADI ROUTES
// ========================================
Route::middleware(['auth', 'role:admin_web'])->prefix('admin/kadi')->name('admin.kadi.')->group(function () {
    Route::get('/dashboard', [AdminWebController::class, 'dashboard'])->name('dashboard');

    // Manajemen Warung
    Route::get('/shops', [AdminWebController::class, 'shops'])->name('shops');
    Route::get('/shops/create', [AdminWebController::class, 'createShop'])->name('shops.create');
    Route::post('/shops', [AdminWebController::class, 'storeShop'])->name('shops.store');
    Route::get('/shops/{shop}/edit', [AdminWebController::class, 'editShop'])->name('shops.edit');
    Route::patch('/shops/{shop}', [AdminWebController::class, 'updateShop'])->name('shops.update');
    Route::delete('/shops/{shop}', [AdminWebController::class, 'deleteShop'])->name('shops.delete');

    // Transaksi
    Route::get('/transactions', [AdminWebController::class, 'transactions'])->name('transactions');

    // Export
    Route::get('/export/csv', [AdminWebController::class, 'exportCsv'])->name('export.csv');
});

// ========================================
// PRODUCT ROUTES (Admin Kantin)
// ========================================
Route::middleware(['auth', 'role:admin_kantin'])->group(function () {
    Route::get('/admin/shop/products', [ProductController::class, 'index'])->name('admin.shop.products');
    Route::post('/admin/shop/products', [ProductController::class, 'store'])->name('admin.shop.products.store');
    Route::patch('/admin/shop/products/{product}', [ProductController::class, 'update'])->name('admin.shop.products.update');
    Route::delete('/admin/shop/products/{product}', [ProductController::class, 'destroy'])->name('admin.shop.products.destroy');
    Route::patch('/admin/shop/products/{product}/toggle', [ProductController::class, 'toggleAvailable'])->name('admin.shop.products.toggle');
});
Route::middleware(['auth', 'role:customer'])->group(function () {
    Route::get('/riwayat', [CustomerController::class, 'riwayat'])->name('customer.riwayat');
});

// ========================================
// KASIR MANUAL
// ========================================
Route::middleware(['auth', 'role:admin_kantin'])->group(function () {
    Route::post('/admin/shop/kasir', [AdminKantinController::class, 'kasirStore'])->name('admin.shop.kasir.store');
});
// ========================================
// TRANSACTION ROUTES
// ========================================
Route::middleware(['auth'])->group(function () {
    // QR Routes
    Route::get('/transactions/confirm/{token}', [TransactionController::class, 'confirmByQR'])->name('transactions.confirmByQR');
    Route::post('/transactions/{transaction}/process-confirm', [TransactionController::class, 'processConfirm'])
        ->name('transactions.processConfirm')
        ->middleware('role:admin_kantin,admin_web');

    // General Transaction Routes
    Route::get('/transactions/{transaction}', [TransactionController::class, 'show'])->name('transactions.show');
    Route::patch('/transactions/{transaction}/status', [TransactionController::class, 'updateStatus'])
        ->name('transactions.update-status')
        ->middleware('role:admin_kantin,admin_web');
    Route::patch('/transactions/{transaction}/cancel', [TransactionController::class, 'cancel'])->name('transactions.cancel');
});
