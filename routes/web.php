<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;

// Admin Controllers
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;

// Seller Controllers
use App\Http\Controllers\Seller\SellerDashboardController;
use App\Http\Controllers\Seller\ProductController as SellerProductController;
use App\Http\Controllers\Seller\StoreController;
use App\Http\Controllers\Seller\OrderController as SellerOrderController;

// Buyer Controllers
use App\Http\Controllers\Buyer\BuyerDashboardController;
use App\Http\Controllers\Buyer\CartController;
use App\Http\Controllers\Buyer\CheckoutController;
use App\Http\Controllers\Buyer\OrderController as BuyerOrderController;
use App\Http\Controllers\Buyer\WishlistController;
use App\Http\Controllers\SellerController;

/*
|--------------------------------------------------------------------------
| Web Routes (NexusPlace)
|--------------------------------------------------------------------------
*/

// --- 1. PUBLIC ROUTES (Bisa diakses siapa saja) ---
Route::get('/', [ProductController::class, 'index'])->name('home');
Route::get('/home', [ProductController::class, 'index'])->name('home');
Route::get('/shop', [ProductController::class, 'shop'])->name('shop');
Route::get('/products/{product:slug}', [ProductController::class, 'show'])->name('products.show');

// --- 2. AUTHENTICATION (Breeze) ---
require __DIR__.'/auth.php';

// --- 3. AUTHENTICATED ROUTES ---
Route::middleware('auth')->group(function () {

    // Route Dashboard Umum (Redirector Pintar)
    Route::get('/dashboard', function () {
        $role = Auth::user()->role;
        if ($role) return redirect()->route($role . '.dashboard');
        return redirect()->route('home');
    })->name('dashboard');

    // Profile Settings
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ==========================================
    // ROLE: ADMIN
    // ==========================================
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

        // User Management
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

        // Seller Verification
        Route::get('/sellers', [UserController::class, 'sellers'])->name('sellers');
        Route::get('/sellers/{query}', [UserController::class, 'sellers'])->name('sellers');
        Route::post('/sellers/{user}/approve', [UserController::class, 'approveSeller'])->name('sellers.approve');
        Route::post('/sellers/{user}/reject', [UserController::class, 'rejectSeller'])->name('sellers.reject');

        // Data Management
        Route::resource('categories', AdminCategoryController::class);

        // Product Moderation (Browse)
        Route::get('/products', [AdminController::class, 'products'])->name('products.index');
        Route::delete('/products/{product}', [AdminController::class, 'destroyProduct'])->name('products.destroy');
    });

    // ==========================================
    // ROLE: SELLER
    // ==========================================
    Route::middleware(['role:seller'])->prefix('seller')->name('seller.')->group(function () {
        Route::get('/pending', [SellerController::class, 'pending'])->name('pending');
        // Fitur Hapus Akun (jika give up/rejected)
        Route::delete('/account/delete', [SellerController::class, 'deleteAccount'])->name('delete-account');


        // 2. Route KHUSUS Seller yang sudah APPROVED
        // Kita bungkus lagi dengan middleware baru 'seller.approved'
        Route::middleware(['seller.approved'])->group(function() {

            Route::get('/dashboard', [SellerDashboardController::class, 'index'])->name('dashboard');

            // Store Settings
            Route::get('/store', [StoreController::class, 'edit'])->name('store.edit');
            Route::put('/store', [StoreController::class, 'update'])->name('store.update');
            Route::get('/store/create', [StoreController::class, 'create'])->name('store.create');
            Route::post('/store', [StoreController::class, 'store'])->name('store.store');

            // Products & Orders
            Route::resource('products', SellerProductController::class);
            Route::get('/orders', [SellerOrderController::class, 'index'])->name('orders.index');
            Route::get('/orders/{order}', [SellerOrderController::class, 'show'])->name('orders.show');
            Route::put('/orders/{order}/status', [SellerOrderController::class, 'updateStatus'])->name('orders.update-status');
        });
    });

    // ==========================================
    // ROLE: BUYER
    // ==========================================
    Route::middleware(['role:buyer'])->prefix('buyer')->name('buyer.')->group(function () {
        // Cart System
        Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
        Route::post('/cart/add/{product}', [CartController::class, 'store'])->name('cart.store');
        Route::put('/cart/{cart}', [CartController::class, 'update'])->name('cart.update');
        Route::delete('/cart/{cart}', [CartController::class, 'destroy'])->name('cart.destroy');
        Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');

        // Orders
        Route::get('/orders', [BuyerOrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{order}', [BuyerOrderController::class, 'show'])->name('orders.show');

        // Review System
        Route::get('/orders/{order}/review/{product}', [BuyerOrderController::class, 'reviewForm'])->name('orders.review-form');
        Route::post('/orders/{order}/review/{product}', [BuyerOrderController::class, 'submitReview'])->name('orders.submit-review');

        // Wishlist
        Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
        Route::post('/wishlist/toggle/{product}', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
        Route::delete('/wishlist/{wishlist}', [WishlistController::class, 'destroy'])->name('wishlist.destroy');
    });
});