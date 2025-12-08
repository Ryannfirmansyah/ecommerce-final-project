@if (false)
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Product
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

            <div class="flex justify-between items-center mb-8">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Edit Product</h2>
                    <p class="text-sm text-gray-500">Update your product details and gallery.</p>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('seller.products.index') }}"
                    class="px-5 py-2.5 bg-white border border-gray-300 rounded-xl text-sm font-semibold text-gray-700 hover:bg-gray-50 transition shadow-sm">
                        Cancel
                    </a>
                    </div>
            </div>

            <form method="POST" action="{{ route('seller.products.update', $product) }}" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                @csrf
                @method('PUT')

                <div class="lg:col-span-2 space-y-8">

                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
                        <h3 class="text-lg font-bold text-gray-900 mb-6 border-b border-gray-100 pb-4">General Information</h3>

                        <div class="space-y-6">
                            <div>
                                <x-input-label for="name" :value="__('Product Name')" class="text-gray-600 font-medium mb-1" />
                                <x-text-input id="name" class="block w-full rounded-xl border-gray-300 focus:border-black focus:ring-black transition"
                                            type="text" name="name" :value="old('name', $product->name)" required placeholder="e.g. Modern Leather Sofa" />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="description" :value="__('Description')" class="text-gray-600 font-medium mb-1" />
                                <textarea id="description" name="description" rows="6"
                                        class="block w-full p-3 rounded-xl border-gray-300 focus:border-black focus:ring-black transition shadow-sm"
                                        required placeholder="Write a description...">{{ old('description', $product->description) }}</textarea>
                                <x-input-error :messages="$errors->get('description')" class="mt-2" />
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
                        <h3 class="text-lg font-bold text-gray-900 mb-6 border-b border-gray-100 pb-4">Pricing & Inventory</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="price" :value="__('Base Price (Rp)')" class="text-gray-600 font-medium mb-1" />
                                <div class="relative">
                                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 font-semibold">Rp</span>
                                    <x-text-input id="price" class="block w-full pl-10 rounded-xl border-gray-300 focus:border-black focus:ring-black transition"
                                                type="number" name="price" :value="old('price', $product->price)" min="0" step="1000" required />
                                </div>
                                <x-input-error :messages="$errors->get('price')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="stock" :value="__('Stock Quantity')" class="text-gray-600 font-medium mb-1" />
                                <x-text-input id="stock" class="block w-full rounded-xl border-gray-300 focus:border-black focus:ring-black transition"
                                            type="number" name="stock" :value="old('stock', $product->stock)" min="0" required />
                                <x-input-error :messages="$errors->get('stock')" class="mt-2" />
                            </div>

                            <div class="md:col-span-2">
                                <x-input-label for="category_id" :value="__('Category')" class="text-gray-600 font-medium mb-1" />
                                <select id="category_id" name="category_id"
                                        class="block p-3 w-full rounded-xl border-gray-300 focus:border-black focus:ring-black transition shadow-sm py-2.5">
                                    <option value="">Select a Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-1 space-y-8">

                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-6 border-b border-gray-100 pb-4">Product Image</h3>

                        <div class="space-y-4">
                            <div class="aspect-square w-full bg-gray-50 rounded-2xl border-2 border-dashed border-gray-200 flex items-center justify-center overflow-hidden relative group">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="Current Image" class="w-full h-full object-cover">
                                    <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition flex items-center justify-center">
                                        <p class="text-white font-medium text-sm">Current Image</p>
                                    </div>
                                @else
                                    <div class="text-center p-4">
                                        <svg class="mx-auto h-12 w-12 text-gray-300" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <p class="mt-1 text-sm text-gray-400">No image uploaded</p>
                                    </div>
                                @endif
                            </div>

                            <div>
                                <x-input-label for="image" :value="__('Replace Image')" class="text-gray-600 font-medium mb-1" />
                                <input id="image" type="file" name="image" accept="image/*"
                                    class="block w-full text-sm text-gray-500
                                    file:mr-4 file:py-2.5 file:px-4
                                    file:rounded-xl file:border-0
                                    file:text-sm file:font-semibold
                                    file:bg-black file:text-white
                                    hover:file:bg-gray-800
                                    cursor-pointer bg-gray-50 rounded-xl" />
                                <p class="mt-2 text-xs text-gray-400">Recommended: 800x800px. Max 2MB.</p>
                                <x-input-error :messages="$errors->get('image')" class="mt-2" />
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                        <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-4">Publish</h3>
                        <p class="text-xs text-gray-500 mb-6">Double check your information before saving changes.</p>

                        <button type="submit" class="w-full py-3 px-4 bg-neutral-900 hover:bg-black text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition transform hover:-translate-y-0.5">
                            Save Changes
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </div>

</x-app-layout>
@else
<x-app-layout>
    <header class="bg-white border-b border-gray-200 px-4 py-3 sm:px-6 lg:px-8 md:py-4 shadow-sm">
        <div class="flex items-center justify-between">
            <div>
                <div class="flex flex-wrap items-center gap-2 text-xs sm:text-sm text-gray-500 mb-1 sm:mb-2">
                    <a href="{{ route('seller.dashboard') }}" class="hover:text-black">Dashboard</a>
                    <span>›</span>
                    <a href="{{ route('seller.products.index') }}" class="hover:text-black">Products</a>
                    <span>›</span>
                    <span class="text-black font-semibold">Edit</span>
                </div>
                <h2 class="font-bold text-xl sm:text-2xl text-black">Edit Product</h2>
            </div>

            <a href="{{ route('seller.products.index') }}" class="flex items-center justify-center bg-black text-white hover:bg-gray-800 transition-colors shadow-lg w-10 h-10 rounded-full sm:w-auto sm:h-auto sm:rounded-2xl sm:px-6 sm:py-3 sm:gap-2">
                <svg class="w-5 h-5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                <span class="hidden sm:inline font-semibold">Cancel</span>
            </a>

        </div>
    </header>

    <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8 bg-gray-50">

        <div class="max-w-6xl mx-auto">
            <form method="POST" action="{{ route('seller.products.update', $product) }}" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8">
                @csrf
                @method('PUT')

                <div class="lg:col-span-2 space-y-6 lg:space-y-8">

                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 sm:p-8">
                        <h3 class="text-lg font-bold text-gray-900 mb-6 border-b border-gray-100 pb-4">General Information</h3>

                        <div class="space-y-5 sm:space-y-6">
                            <div>
                                <x-input-label for="name" :value="__('Product Name')" class="text-gray-600 font-medium mb-1" />
                                <x-text-input id="name" class="block w-full rounded-xl border-gray-300 focus:border-black focus:ring-black transition text-sm sm:text-base p-2.5 sm:p-3"
                                              type="text" name="name" :value="old('name', $product->name)" required placeholder="e.g. Modern Leather Sofa" />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="description" :value="__('Description')" class="text-gray-600 font-medium mb-1" />
                                <textarea id="description" name="description" rows="6"
                                          class="block w-full p-3 rounded-xl border-gray-300 focus:border-black focus:ring-black transition shadow-sm text-sm sm:text-base"
                                          required placeholder="Write a description...">{{ old('description', $product->description) }}</textarea>
                                <x-input-error :messages="$errors->get('description')" class="mt-2" />
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 sm:p-8">
                        <h3 class="text-lg font-bold text-gray-900 mb-6 border-b border-gray-100 pb-4">Pricing & Inventory</h3>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 sm:gap-6">
                            <div>
                                <x-input-label for="price" :value="__('Base Price (Rp)')" class="text-gray-600 font-medium mb-1" />
                                <div class="relative">
                                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 font-semibold">Rp</span>
                                    <x-text-input id="price" class="block w-full pl-10 rounded-xl border-gray-300 focus:border-black focus:ring-black transition text-sm sm:text-base py-2.5 pr-2.5 pl-5 sm:p-3 sm:pl-12"
                                                  type="number" name="price" :value="old('price', $product->price)" min="0" step="1000" required />
                                </div>
                                <x-input-error :messages="$errors->get('price')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="stock" :value="__('Stock Quantity')" class="text-gray-600 font-medium mb-1" />
                                <x-text-input id="stock" class="block w-full rounded-xl border-gray-300 focus:border-black focus:ring-black transition text-sm sm:text-base p-2.5 sm:p-3"
                                              type="number" name="stock" :value="old('stock', $product->stock)" min="0" required />
                                <x-input-error :messages="$errors->get('stock')" class="mt-2" />
                            </div>

                            <div class="sm:col-span-2">
                                <x-input-label for="category_id" :value="__('Category')" class="text-gray-600 font-medium mb-1" />
                                <div class="relative">
                                    <select id="category_id" name="category_id"
                                            class="block w-full rounded-xl border-gray-300 focus:border-black focus:ring-black transition shadow-sm p-2.5 sm:p-3 appearance-none text-sm sm:text-base cursor-pointer">
                                        <option value="">Select a Category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-1 space-y-6 lg:space-y-8">

                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 sm:p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-6 border-b border-gray-100 pb-4">Product Image</h3>

                        <div class="space-y-4">
                            <div class="aspect-square w-full bg-gray-50 rounded-2xl border-2 border-dashed border-gray-200 flex items-center justify-center overflow-hidden relative group">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="Current Image" class="w-full h-full object-cover">
                                    <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition flex items-center justify-center">
                                        <p class="text-white font-medium text-sm">Current Image</p>
                                    </div>
                                @else
                                    <div class="text-center p-4">
                                        <svg class="mx-auto h-12 w-12 text-gray-300" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <p class="mt-1 text-sm text-gray-400">No image uploaded</p>
                                    </div>
                                @endif
                            </div>

                            <div>
                                <x-input-label for="image" :value="__('Replace Image')" class="text-gray-600 font-medium mb-1" />
                                <input id="image" type="file" name="image" accept="image/*"
                                    class="block w-full text-sm text-gray-500
                                    file:mr-4 file:py-2.5 file:px-4
                                    file:rounded-xl file:border-0
                                    file:text-xs sm:file:text-sm file:font-semibold
                                    file:bg-black file:text-white
                                    hover:file:bg-gray-800
                                    cursor-pointer bg-gray-50 rounded-xl" />
                                <p class="mt-2 text-xs text-gray-400">Recommended: 800x800px. Max 2MB.</p>
                                <x-input-error :messages="$errors->get('image')" class="mt-2" />
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 sm:p-6 sticky top-4">
                        <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-4">Publish</h3>
                        <p class="text-xs text-gray-500 mb-6">Double check your information before saving changes.</p>

                        <button type="submit" class="w-full py-3 px-4 bg-neutral-900 hover:bg-black text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition transform hover:-translate-y-0.5">
                            Save Changes
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </main>

</x-app-layout>
@endif