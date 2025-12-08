<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;


class AdminController extends Controller
{
    public function dashboard()
    {
        // 1. Ambil Statistik (Angka)
        $stats = [
            'total_users' => User::count(),
            'total_sellers' => User::where('role', 'seller')->count(),
            'total_orders' => Order::count(),
            'pending_count' => User::where('role', 'seller')->where('seller_status', 'pending')->count(),
        ];

        // 2. Ambil List Pending Sellers (Data User Asli untuk Tabel)
        // Kita limit 5 saja biar dashboard tidak kepanjangan
        $pendingSellers = User::where('role', 'seller')
            ->where('seller_status', 'pending')
            ->latest()
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'pendingSellers'));
    }

    public function products(Request $request)
    {
        // 1. Query Dasar: Ambil produk beserta relasi Store dan Category
        $query = Product::with(['store', 'category']);

        // 2. Logika Pencarian (Nama Produk atau Nama Toko)
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            
            $query->where(function(Builder $q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')        // Cari nama produk
                ->orWhereHas('store', function($qStore) use ($search) {
                    $qStore->where('name', 'like', '%' . $search . '%'); // Cari nama toko
                });
            });
        }

        // 3. Ambil data (Paginate)
        $products = $query->latest()->paginate(10)->withQueryString();

        return view('admin.products.index', compact('products'));
    }

    public function destroyProduct(Product $product)
    {
        // 1. Hapus gambar dari storage jika ada
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        // 2. Hapus data dari database
        $product->delete();

        // 3. Kembali ke halaman sebelumnya dengan pesan sukses
        return redirect()->back()->with('success', 'Produk berhasil dihapus oleh Admin (Takedown).');
    }
}