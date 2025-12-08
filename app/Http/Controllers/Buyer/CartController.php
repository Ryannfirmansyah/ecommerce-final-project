<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = Cart::with(['product.store'])
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        foreach ($cartItems as $item) {
            if ($item->product && $item->quantity > $item->product->stock) {
                $item->out_of_stock = true;
            }
        }

        $groupedCarts = $cartItems->groupBy(function ($item) {
            return $item->product->store_id;
        });

        $grandTotal = $cartItems->sum(function ($item) {
            if ($item->product && $item->product->stock >= $item->quantity) {
                return $item->product->price * $item->quantity;
            }
            return 0;
        });

        return view('buyer.cart.index', compact('groupedCarts', 'grandTotal', 'cartItems'));
    }

    public function store(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => ['required', 'integer', 'min:1', 'max:' . $product->stock],
        ]);

        $cartItem = Cart::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->first();

        $message = 'Produk berhasil ditambahkan ke keranjang!';

        if ($cartItem) {
            $newQuantity = $cartItem->quantity + $request->quantity;

            if ($newQuantity > $product->stock) {
                $newQuantity = $product->stock;
                $message = $message . " Stok diatur ke maks.";
            }

            $cartItem->update(['quantity' => $newQuantity]);
        } else {
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $product->id,
                'quantity' => $request->quantity,
            ]);
        }

        return redirect()->back()->with('success', $message);
    }

    public function update(Request $request, Cart $cart)
    {
        if ($cart->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'quantity' => ['required', 'integer', 'min:1', 'max:' . $cart->product->stock],
        ]);

        $cart->update(['quantity' => $request->quantity]);

        return redirect()->back()->with('success', 'Keranjang berhasil diupdate!');
    }

    public function destroy(Cart $cart)
    {
        if ($cart->user_id !== Auth::id()) {
            abort(403);
        }

        $cart->delete();

        return redirect()->back()->with('success', 'Produk berhasil dihapus dari keranjang!');
    }

    public function checkout(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        $allCartItems = Cart::where('user_id', $user->id)
                            ->with('product.store.user')
                            ->get();

        $processedCartIds = $allCartItems->pluck('id');

        if ($allCartItems->isEmpty()) {
            return redirect()->route('buyer.cart.index')->with('error', 'Keranjang Anda kosong!');
        }

        DB::beginTransaction();

        try {
            $validItems = $allCartItems->filter(function($item) {
                return $item->product->store &&
                    $item->product->store->user->seller_status === 'approved';
            });

            $invalidItems = $allCartItems->diff($validItems);

            if ($invalidItems->isNotEmpty()) {
                \App\Models\Cart::destroy($invalidItems->pluck('id'));
            }

            if ($validItems->isEmpty()) {
                DB::commit();
                return redirect()->route('buyer.cart.index')
                    ->with('error', 'Maaf, semua barang di keranjang tidak dapat diproses karena penjual sedang tidak aktif.');
            }

            foreach ($validItems as $item) {
                if ($item->product->stock < $item->quantity) {
                    throw new \Exception("Stok produk '{$item->product->name}' tidak mencukupi. Sisa: {$item->product->stock}");
                }
            }

            $total = $validItems->sum(function ($item) {
                return $item->quantity * $item->product->price;
            });

            $order = Order::create([
                'user_id' => $user->id,
                'order_number' => Order::generateOrderNumber(),
                'total_price' => $total,
                'shipping_address' => $request->shipping_address,
            ]);

            foreach ($validItems as $cartItem) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->product->price,
                ]);

                $cartItem->product->decrement('stock', $cartItem->quantity);
            }

            Cart::whereIn('id', $processedCartIds)->delete();

            DB::commit();

            if ($invalidItems->isNotEmpty()) {
                return redirect()->route('buyer.orders.show', $order)
                    ->with('warning', 'Pesanan berhasil dibuat! Namun, beberapa barang dihapus otomatis karena penjual sedang tidak aktif.');
            }

            return redirect()->route('buyer.orders.show', $order)
                ->with('success', 'Pesanan berhasil dibuat!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}