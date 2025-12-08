<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::where('user_id', Auth::id())
            ->with('orderItems.product')
            ->latest();

        // 2. Filter Search
        if ($request->filled('search')) {
            $orders->where('order_number', 'like', '%' . $request->search . '%');
        }

        // 3. Filter Status (Logic Multi-Vendor)
        // Kita harus menerjemahkan logika Accessor ke dalam Query SQL
        if ($request->filled('status')) {
            $status = $request->status;

            if ($status === 'completed') {
                // Logika: Order dianggap selesai jika TIDAK ADA item yang statusnya BUKAN 'completed'
                // Artinya: Semua item harus 'completed'
                $orders->whereDoesntHave('orderItems', function($q) {
                    $q->where('status', '!=', 'completed');
                });
            } 
            elseif ($status === 'cancelled') {
                // Logika: Semua item harus 'cancelled'
                $orders->whereDoesntHave('orderItems', function($q) {
                    $q->where('status', '!=', 'cancelled');
                });
            } 
            elseif ($status === 'pending') {
                // Logika: Semua item masih 'pending'
                $orders->whereDoesntHave('orderItems', function($q) {
                    $q->where('status', '!=', 'pending');
                });
            } 
            elseif ($status === 'processing') {
                // Logika Processing agak kompleks:
                // 1. Ada item yang statusnya 'processing'
                // ATAU
                // 2. Ada item 'completed' TAPI masih ada item lain yang BELUM 'completed' (Partial)
                
                $orders->where(function($query) {
                    // Kondisi A: Ada item yang statusnya processing
                    $query->whereHas('orderItems', function($q) {
                        $q->where('status', 'processing');
                    })
                    // Kondisi B: Partial Completed (Ada yang completed, tapi tidak semua)
                    ->orWhere(function($subQuery) {
                        $subQuery->whereHas('orderItems', function($q) {
                            $q->where('status', 'completed');
                        })->whereHas('orderItems', function($q) {
                            $q->where('status', '!=', 'completed'); // Masih ada sisa yang belum kelar
                        });
                    });
                });
            }
        }

        $orders = $orders->paginate(10)->withQueryString();

        return view('buyer.orders.index', compact('orders'));
    }
    // public function index(Request $request)
    // {
    //     // 1. Mulai Query (Jangan di-get dulu)
    //     // Gunakan 'with' untuk eager load orderItems agar Accessor 'status' tadi tidak berat (N+1 problem)
    //     $orders = Order::where('user_id', Auth::id())
    //         ->with('orderItems.product') // Load detail item & produknya
    //         ->latest();

    //     // 2. Filter Search (Opsional, jika ada pencarian ID Order)
    //     if ($request->has('search') && $request->search != '') {
    //         $orders->where('order_number', 'like', '%' . $request->search . '%');
    //     }

    //     // 3. Filter Status (Logic Multi-Vendor)
    //     // "Tampilkan order yang di dalamnya ada barang dengan status X"
    //     if ($request->has('status') && $request->status != '') {
    //         $status = $request->status;

    //         $orders;
    //     }

    //     // 4. Eksekusi Query dengan Pagination
    //     $orders = $orders->paginate(10)->withQueryString();

    //     return view('buyer.orders.index', compact('orders'));
    // }

    // Detail order
    public function show(Order $order)
    {
        // Pastikan order milik user ini
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $order->load(['orderItems.product.store', 'orderItems.userReview']);

        return view('buyer.orders.show', compact('order'));
    }

    // Form add review
    public function reviewForm(Order $order, $productId)
    {
        // Pastikan order milik user ini
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        // Pastikan order sudah completed
        if ($order->status !== 'completed') {
            return redirect()->back()->with('error', 'Anda hanya bisa review setelah order selesai!');
        }

        // Cek apakah produk ada di order ini
        $orderItem = $order->orderItems()->where('product_id', $productId)->first();

        if (!$orderItem) {
            abort(404);
        }

        // Cek apakah sudah pernah review
        $existingReview = Review::where('user_id', Auth::id())
            ->where('product_id', $productId)
            ->where('order_id', $order->id)
            ->first();

        if ($existingReview) {
            return redirect()->back()->with('error', 'Anda sudah memberikan review untuk produk ini!');
        }

        return view('buyer.orders.review', compact('order', 'orderItem'));
    }

    // Submit review
    public function submitReview(Request $request, Order $order, $productId)
    {
        // Pastikan order milik user ini
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        // Pastikan order sudah completed
        if ($order->status !== 'completed') {
            return redirect()->back()->with('error', 'Anda hanya bisa review setelah order selesai!');
        }

        // Cek apakah sudah pernah review
        $existingReview = Review::where('user_id', Auth::id())
            ->where('product_id', $productId)
            ->where('order_id', $order->id)
            ->first();

        if ($existingReview) {
            return redirect()->back()->with('error', 'Anda sudah memberikan review untuk produk ini!');
        }

        $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['nullable', 'string'],
        ]);

        Review::create([
            'user_id' => Auth::id(),
            'product_id' => $productId,
            'order_id' => $order->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()->route('buyer.orders.show', $order)->with('success', 'Review berhasil ditambahkan!');
    }
}