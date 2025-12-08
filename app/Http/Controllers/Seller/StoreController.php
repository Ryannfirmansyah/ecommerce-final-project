<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class StoreController extends Controller
{
    public function create()
    {
        $user = Auth::user();

        // Jika sudah punya toko, redirect ke edit
        if ($user->store) {
            return redirect()->route('seller.store.edit');
        }

        return view('seller.store.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:stores'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ]);

        $user = Auth::user();

        // Cek apakah sudah punya toko
        if ($user->store) {
            return redirect()->route('seller.dashboard')->with('error', 'Anda sudah memiliki toko!');
        }

        $data = [
            'user_id' => $user->id,
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
        ];

        // Upload image jika ada
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('stores', 'public');
        }

        Store::create($data);

        return redirect()->route('seller.dashboard')->with('success', 'Toko berhasil dibuat!');
    }

    public function edit()
    {
        $store = Auth::user()->store;

        if (!$store) {
            return redirect()->route('seller.store.create');
        }

        return view('seller.store.edit', compact('store'));
    }

    public function update(Request $request)
    {
        $store = Auth::user()->store;

        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:stores,name,' . $store->id],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ]);

        $data = [
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
        ];

        // Upload image baru jika ada
        if ($request->hasFile('image')) {
            // Hapus image lama jika ada
            if ($store->image) {
                Storage::disk('public')->delete($store->image);
            }

            $data['image'] = $request->file('image')->store('stores', 'public');
        }

        $store->update($data);

        return redirect()->route('seller.dashboard')->with('success', 'Toko berhasil diupdate!');
    }
}