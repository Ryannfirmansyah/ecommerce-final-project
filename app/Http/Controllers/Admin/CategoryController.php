<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    // Tampilkan semua kategori
    public function index()
    {
        $search = request('search');
        if ($search) {
            $categories = Category::where('name', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%")
                ->orderBy('name')
                ->paginate(10);
        } else {
            $categories = Category::withCount('products')->orderBy('name')->paginate(10);
        }
        
        return view('admin.categories.index', compact('categories'));
    }

    // Form create kategori
    public function create()
    {
        return view('admin.categories.create');
    }

    // Simpan kategori baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:categories'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'jpg|jpeg|png', 'image', 'max:2048'],
        ]);

        // simpan image jika ada
        $imageUrl = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('categories', 'public');
            $imageUrl = asset('storage/' . $imagePath);
        }

        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'image' => $imageUrl,
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil ditambahkan!');
    }

    // Form edit kategori
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    // Update kategori
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:categories,name,' . $category->id],
            'description' => ['nullable', 'string'],    
            'image' => ['nullable', 'jpg|jpeg|png', 'image', 'max:2048'],
        ]);


        $imageUrl = $category->image;
        // Hapus image lama jika ada dan upload yang baru
        if ($request->hasFile('image')) {                
            if ($imageUrl) {
                $oldImagePath = str_replace(asset('storage/'), '', $category->image);
                Storage::disk('public')->delete($oldImagePath);
            }

            $imagePath = $request->file('image')->store('categories', 'public');
            $imageUrl = asset('storage/' . $imagePath);
        }

        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'image' => $imageUrl,
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil diupdate!');
    }

    // Delete kategori
    public function destroy(Category $category)
    {
        // Cek apakah kategori punya produk
        if ($category->products()->count() > 0) {
            return redirect()->back()->with('error', 'Tidak bisa menghapus kategori yang masih punya produk!');
        }

        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil dihapus!');
    }
}