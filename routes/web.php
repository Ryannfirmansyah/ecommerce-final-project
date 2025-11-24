<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SellerController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

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

// Route untuk Admin (sementara placeholder)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

// Route untuk Seller (sementara placeholder)
Route::middleware(['auth', 'seller'])->prefix('seller')->name('seller.')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

// Route untuk Buyer (sementara placeholder)
Route::middleware(['auth', 'buyer'])->prefix('buyer')->name('buyer.')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';