<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // List semua produk seller
    public function index()
    {
        $store = auth()->user()->store;

        if (!$store) {
            return redirect()->route('seller.store.create')->with('error', 'Buat toko terlebih dahulu!');
        }

        $products = $store->products()->with('category')->latest()->paginate(10);

        return view('seller.products.index', compact('products'));
    }

    // Form create product
    public function create()
    {
        $store = auth()->user()->store;

        if (!$store) {
            return redirect()->route('seller.store.create')->with('error', 'Buat toko terlebih dahulu!');
        }

        $categories = Category::orderBy('name')->get();

        return view('seller.products.create', compact('categories'));
    }

    // Simpan product baru
    public function store(Request $request)
    {
        $store = auth()->user()->store;

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ]);

        $data = [
            'store_id' => $store->id,
            'category_id' => $request->category_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name) . '-' . Str::random(6),
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
        ];

        // Upload image jika ada
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        Product::create($data);

        return redirect()->route('seller.products.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    // Form edit product
    public function edit(Product $product)
    {
        $store = auth()->user()->store;

        // Pastikan produk milik seller ini
        if ($product->store_id !== $store->id) {
            abort(403, 'Unauthorized action.');
        }

        $categories = Category::orderBy('name')->get();

        return view('seller.products.edit', compact('product', 'categories'));
    }

    // Update product
    public function update(Request $request, Product $product)
    {
        $store = auth()->user()->store;

        // Pastikan produk milik seller ini
        if ($product->store_id !== $store->id) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ]);

        $data = [
            'category_id' => $request->category_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name) . '-' . Str::random(6),
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
        ];

        // Upload image baru jika ada
        if ($request->hasFile('image')) {
            // Hapus image lama
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }

            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        return redirect()->route('seller.products.index')->with('success', 'Produk berhasil diupdate!');
    }

    // Delete product
    public function destroy(Product $product)
    {
        $store = auth()->user()->store;

        // Pastikan produk milik seller ini
        if ($product->store_id !== $store->id) {
            abort(403, 'Unauthorized action.');
        }

        // Hapus image jika ada
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('seller.products.index')->with('success', 'Produk berhasil dihapus!');
    }
}