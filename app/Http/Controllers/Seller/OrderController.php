<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $store = Auth::user()->store;
        if (!$store) {
            return redirect()->route('seller.store.create')->with('error', 'Buat toko terlebih dahulu!');
        }

        $query = Order::forStore($store->id);

        if ($request->has('status') && $request->status != '') {
            $query->whereHas('orderItems', function($q) use ($request) {
                $q->where('status', $request->status);
            });
        }

        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search;
            $query->where('order_number', 'like', '%' . $searchTerm . '%')
                  ->orWhereHas('user', function($q) use ($searchTerm) {
                      $q->where('name', 'like', '%' . $searchTerm . '%');
                  });
        }
        
        $statusClasses = [
            'pending' => 'bg-yellow-50 text-yellow-700 border-yellow-100',
            'processing' => 'bg-blue-50 text-blue-700 border-blue-100',
            'completed' => 'bg-green-50 text-green-700 border-green-100',
            'cancelled' => 'bg-red-50 text-red-700 border-red-100',
        ];
        
        $orders = $query->latest()->paginate(10)->withQueryString();

        return view('seller.orders.index', compact('orders', 'statusClasses'));
    }
    
    public function show(Order $order)
    {
        $store = Auth::user()->store;
    
        $hasItem = $order->orderItems()->whereHas('product', fn($q) => $q->where('store_id', $store->id))->exists();
        
        if (!$hasItem) abort(403);
    
        $order->load(['user', 'orderItems' => function ($query) use ($store) {
            $query->whereHas('product', fn($q) => $q->where('store_id', $store->id))->with('product');
        }]);

        $currentStatus = $order->orderItems->first()->status ?? 'pending';
    
        return view('seller.orders.show', compact('order', 'currentStatus'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $store = Auth::user()->store;

        $request->validate([
            'status' => ['required', 'in:pending,processing,completed,cancelled'],
        ]);

        $hasItem = $order->orderItems()
            ->whereHas('product', function($q) use ($store) {
                $q->where('store_id', $store->id);
            })
            ->exists();

        if (!$hasItem) {
            abort(403, 'Unauthorized action.');
        }

        $order->orderItems()
            ->whereHas('product', function($query) use ($store) {
                $query->where('store_id', $store->id);
            })
            ->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui!');
    }
}