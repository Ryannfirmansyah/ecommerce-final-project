<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;

class SellerDashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $store = $user->store;

        // Jika seller belum punya toko, redirect ke create store
        if (!$store) {
            return redirect()->route('seller.store.create')->with('info', 'Silakan setup toko Anda terlebih dahulu.');
        }

        // Statistik untuk dashboard
        $stats = [
            'total_products' => $store->products()->count(),
            'total_orders' => Order::whereHas('orderItems.product', function($query) use ($store) {
                $query->where('store_id', $store->id);
            })->count(),
            'pending_orders' => Order::where('status', 'pending')
                ->whereHas('orderItems.product', function($query) use ($store) {
                    $query->where('store_id', $store->id);
                })->count(),
            'completed_orders' => Order::where('status', 'completed')
                ->whereHas('orderItems.product', function($query) use ($store) {
                    $query->where('store_id', $store->id);
                })->count(),
        ];

        return view('seller.dashboard', compact('store', 'stats'));
    }
}