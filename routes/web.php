<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SellerController;
use Illuminate\Support\Facades\Route;

// Homepage - Public & Buyer
Route::get('/', [App\Http\Controllers\ProductController::class, 'index'])->name('home');
Route::get('/products/{product}', [App\Http\Controllers\ProductController::class, 'show'])->name('products.show');

// Route untuk Seller Pending
Route::middleware(['auth'])->group(function () {
    Route::get('/seller/pending', [SellerController::class, 'pending'])->name('seller.pending');
    Route::delete('/seller/delete-account', [SellerController::class, 'deleteAccount'])->name('seller.delete-account');
});

// Route Dashboard dengan redirect berdasarkan role
Route::get('/dashboard', function () {
    $user = auth()->user();

    // Admin redirect ke admin dashboard
    if ($user->isAdmin()) {
        return redirect()->route('admin.dashboard');
    }

    // Seller approved redirect ke seller dashboard
    if ($user->isApprovedSeller()) {
        return redirect()->route('seller.dashboard');
    }

    // Seller pending/rejected redirect ke pending page
    if ($user->isSeller()) {
        return redirect()->route('seller.pending');
    }

    // Buyer redirect ke buyer dashboard
    if ($user->isBuyer()) {
        return redirect()->route('buyer.dashboard');
    }

    // Fallback
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Route untuk Admin
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [App\Http\Controllers\Admin\AdminController::class, 'dashboard'])->name('dashboard');
    
    // User Management
    Route::get('/users', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}/edit', [App\Http\Controllers\Admin\UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [App\Http\Controllers\Admin\UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('users.destroy');
    
    // Seller Verification
    Route::get('/pending-sellers', [App\Http\Controllers\Admin\UserController::class, 'pendingSellers'])->name('pending-sellers');
    Route::post('/sellers/{user}/approve', [App\Http\Controllers\Admin\UserController::class, 'approveSeller'])->name('sellers.approve');
    Route::post('/sellers/{user}/reject', [App\Http\Controllers\Admin\UserController::class, 'rejectSeller'])->name('sellers.reject');
    
    // Category Management
    Route::resource('categories', App\Http\Controllers\Admin\CategoryController::class);
});

// Route untuk Seller
Route::middleware(['auth', 'seller'])->prefix('seller')->name('seller.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [App\Http\Controllers\Seller\SellerDashboardController::class, 'index'])->name('dashboard');
    
    // Store Management
    Route::get('/store/create', [App\Http\Controllers\Seller\StoreController::class, 'create'])->name('store.create');
    Route::post('/store', [App\Http\Controllers\Seller\StoreController::class, 'store'])->name('store.store');
    Route::get('/store/edit', [App\Http\Controllers\Seller\StoreController::class, 'edit'])->name('store.edit');
    Route::put('/store', [App\Http\Controllers\Seller\StoreController::class, 'update'])->name('store.update');
    
    // Product Management
    Route::resource('products', App\Http\Controllers\Seller\ProductController::class);
    
    // Order Management
    Route::get('/orders', [App\Http\Controllers\Seller\OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [App\Http\Controllers\Seller\OrderController::class, 'show'])->name('orders.show');
    Route::put('/orders/{order}/status', [App\Http\Controllers\Seller\OrderController::class, 'updateStatus'])->name('orders.update-status');
});

// Route untuk Buyer
Route::middleware(['auth', 'buyer'])->prefix('buyer')->name('buyer.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [App\Http\Controllers\Buyer\BuyerDashboardController::class, 'index'])->name('dashboard');
    
    // Cart Management
    Route::get('/cart', [App\Http\Controllers\Buyer\CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/{product}', [App\Http\Controllers\Buyer\CartController::class, 'store'])->name('cart.store');
    Route::put('/cart/{cart}', [App\Http\Controllers\Buyer\CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{cart}', [App\Http\Controllers\Buyer\CartController::class, 'destroy'])->name('cart.destroy');
    
    // Checkout
    Route::get('/checkout', [App\Http\Controllers\Buyer\CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/process', [App\Http\Controllers\Buyer\CheckoutController::class, 'process'])->name('checkout.process');
    
    // Orders
    Route::get('/orders', [App\Http\Controllers\Buyer\OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [App\Http\Controllers\Buyer\OrderController::class, 'show'])->name('orders.show');
    
    // Reviews
    Route::get('/orders/{order}/review/{product}', [App\Http\Controllers\Buyer\OrderController::class, 'reviewForm'])->name('orders.review-form');
    Route::post('/orders/{order}/review/{product}', [App\Http\Controllers\Buyer\OrderController::class, 'submitReview'])->name('orders.submit-review');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';