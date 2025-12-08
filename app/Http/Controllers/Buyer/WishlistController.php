<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    // Tampilkan halaman Wishlist
    public function index()
    {
        $wishlists = Wishlist::where('user_id', Auth::id())
            ->with('product.category') // Eager load
            ->latest()
            ->paginate(12);

        return view('buyer.wishlist.index', compact('wishlists'));
    }

    // Toggle (Like/Unlike) - Bisa dipakai di tombol love di product card
    public function toggle(Product $product)
    {
        $user = Auth::user();

        if (!$user->role == 'buyer') {
            return redirect()->back()->with('warning', 'Log in as a buyer to add this item to your wishlist.');
        }

        $exists = Wishlist::where('user_id', $user->id)
            ->where('product_id', $product->id)
            ->first();

        if ($exists) {
            $exists->delete();
            $message = 'Removed from wishlist.';
            $type = 'info';
        } else {
            Wishlist::create([
                'user_id' => $user->id,
                'product_id' => $product->id
            ]);
            $message = 'Added to wishlist!';
            $type = 'success';
        }

        return redirect()->back()->with($type, $message);
    }

    // Hapus dari halaman wishlist
    public function destroy(Wishlist $wishlist)
    {
        if ($wishlist->user_id !== Auth::id()) {
            abort(403);
        }
        $wishlist->delete();
        return redirect()->back()->with('success', 'Item removed from wishlist.');
    }
}