<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // List incoming orders untuk toko seller
    public function index()
    {
        $store = auth()->user()->store;

        if (!$store) {
            return redirect()->route('seller.store.create')->with('error', 'Buat toko terlebih dahulu!');
        }

        // Ambil orders yang punya produk dari toko ini
        $orders = Order::whereHas('orderItems.product', function($query) use ($store) {
            $query->where('store_id', $store->id);
        })
        ->with(['user', 'orderItems.product'])
        ->latest()
        ->paginate(10);

        return view('seller.orders.index', compact('orders'));
    }

    // Detail order
    public function show(Order $order)
    {
        $store = auth()->user()->store;

        // Cek apakah order ini ada produk dari toko seller
        $hasStoreProduct = $order->orderItems()->whereHas('product', function($query) use ($store) {
            $query->where('store_id', $store->id);
        })->exists();

        if (!$hasStoreProduct) {
            abort(403, 'Unauthorized action.');
        }

        $order->load(['user', 'orderItems.product']);

        return view('seller.orders.show', compact('order'));
    }

    // Update status order
    public function updateStatus(Request $request, Order $order)
    {
        $store = auth()->user()->store;

        // Cek apakah order ini ada produk dari toko seller
        $hasStoreProduct = $order->orderItems()->whereHas('product', function($query) use ($store) {
            $query->where('store_id', $store->id);
        })->exists();

        if (!$hasStoreProduct) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'status' => ['required', 'in:pending,processing,completed,cancelled'],
        ]);

        $order->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Status order berhasil diupdate!');
    }
}