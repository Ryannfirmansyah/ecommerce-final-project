<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Review;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // List semua orders buyer
    public function index()
    {
        $orders = auth()->user()->orders()
            ->with('orderItems.product')
            ->latest()
            ->paginate(10);

        return view('buyer.orders.index', compact('orders'));
    }

    // Detail order
    public function show(Order $order)
    {
        // Pastikan order milik user ini
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $order->load('orderItems.product.store');

        return view('buyer.orders.show', compact('order'));
    }

    // Form add review
    public function reviewForm(Order $order, $productId)
    {
        // Pastikan order milik user ini
        if ($order->user_id !== auth()->id()) {
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
        $existingReview = Review::where('user_id', auth()->id())
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
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        // Pastikan order sudah completed
        if ($order->status !== 'completed') {
            return redirect()->back()->with('error', 'Anda hanya bisa review setelah order selesai!');
        }

        // Cek apakah sudah pernah review
        $existingReview = Review::where('user_id', auth()->id())
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
            'user_id' => auth()->id(),
            'product_id' => $productId,
            'order_id' => $order->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()->route('buyer.orders.show', $order)->with('success', 'Review berhasil ditambahkan!');
    }
}