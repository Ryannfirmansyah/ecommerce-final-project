<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SellerDashboardController extends Controller 
{
    public function index()
    {
        $store = Auth::user()->store; // Asumsi user sudah punya relasi ke store

        // 1. Hitung Revenue (Hanya dari produk toko ini yang statusnya 'completed')
        $revenue = OrderItem::whereHas('product', function ($q) use ($store) {
                $q->where('store_id', $store->id);
            })
            ->where('status', 'completed')
            ->sum(DB::raw('price * quantity'));

        // 2. Hitung Pesanan Pending (Yang butuh dikirim segera)
        $pendingOrders = OrderItem::whereHas('product', function ($q) use ($store) {
                $q->where('store_id', $store->id);
            })
            ->where('status', 'pending')
            ->distinct('order_id') // Hitung per Order ID, bukan per item
            ->count();

        // 3. Hitung Total Order Sukses
        $totalOrders = OrderItem::whereHas('product', function ($q) use ($store) {
                $q->where('store_id', $store->id);
            })
            ->where('status', 'completed')
            ->distinct('order_id')
            ->count();

        // 4. Total Produk
        $totalProducts = Product::where('store_id', $store->id)->count();

        $stats = [
            'revenue' => $revenue,
            'pending_orders' => $pendingOrders,
            'total_orders' => $totalOrders,
            'total_products' => $totalProducts
        ];

        $recentOrders = Order::with('user')
            // Filter Order yang mengandung produk toko
            ->whereHas('orderItems.product', function ($q) use ($store) {
                $q->where('store_id', $store->id);
            })
            // Eager Load 'orderItems' TAPI HANYA item milik toko ini
            // Ini kuncinya agar kita bisa hitung subtotal toko
            ->with(['orderItems' => function($query) use ($store) {
                $query->whereHas('product', function($q) use ($store) {
                    $q->where('store_id', $store->id);
                });
            }])
            ->latest()
            ->take(5)
            ->get();
        
        // Menentukan status order berdasarkan item toko ini
        foreach ($recentOrders as $order) {
            $order->status = $order->orderItems->first()->status ?? 'pending';
        }

        return view('seller.dashboard', compact('stats', 'recentOrders', 'store'));
    }
}