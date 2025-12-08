@if (false)
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Add New Product
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('seller.products.store') }}" enctype="multipart/form-data">
                        @csrf

                        <!-- Product Name -->
                        <div>
                            <x-input-label for="name" :value="__('Product Name')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- Category -->
                        <div class="mt-4">
                            <x-input-label for="category_id" :value="__('Category')" />
                            <select id="category_id" name="category_id" class="block p-3 mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                        </div>

                        <!-- Description -->
                        <div class="mt-4">
                            <x-input-label for="description" :value="__('Description')" />
                            <textarea id="description" name="description" rows="4" class="block p-3  mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>{{ old('description') }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <!-- Price -->
                        <div class="mt-4">
                            <x-input-label for="price" :value="__('Price (Rp)')" />
                            <x-text-input id="price" class="block mt-1 w-full" type="number" name="price" :value="old('price')" min="0" step="1000" required />
                            <x-input-error :messages="$errors->get('price')" class="mt-2" />
                        </div>

                        <!-- Stock -->
                        <div class="mt-4">
                            <x-input-label for="stock" :value="__('Stock')" />
                            <x-text-input id="stock" class="block mt-1 w-full" type="number" name="stock" :value="old('stock')" min="0" required />
                            <x-input-error :messages="$errors->get('stock')" class="mt-2" />
                        </div>

                        <!-- Product Image -->
                        <div class="mt-4">
                            <x-input-label for="image" :value="__('Product Image')" />
                            <input id="image" type="file" name="image" accept="image/*" class="block mt-1 w-full text-sm text-gray-500
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-md file:border-0
                                file:text-sm file:font-semibold
                                file:bg-indigo-50 file:text-indigo-700
                                hover:file:bg-indigo-100" />
                            <p class="mt-1 text-xs text-gray-500">Max 2MB (JPG, PNG)</p>
                            <x-input-error :messages="$errors->get('image')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-6 space-x-3">
                            <a href="{{ route('seller.products.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400">
                                Cancel
                            </a>
                            <x-primary-button>
                                Create Product
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
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
                    <span class="text-black font-semibold">Add</span>
                </div>
                <h2 class="font-bold text-xl sm:text-2xl text-black">Add New Product</h2>
            </div>
            <a href="{{ route('seller.products.index') }}" class="flex items-center justify-center bg-black text-white hover:bg-gray-800 transition-colors shadow-lg w-10 h-10 rounded-full sm:w-auto sm:h-auto sm:rounded-2xl sm:px-6 sm:py-3 sm:gap-2">
                <svg class="w-5 h-5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                <span class="hidden sm:inline font-semibold">Cancel</span>
            </a>
        </div>
    </header>

    <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8 bg-gray-50">
        
        <div class="max-w-3xl mx-auto">
            <div class="bg-white rounded-2xl p-5 sm:p-8 border border-gray-200 shadow-lg">
                
                <form method="POST" action="{{ route('seller.products.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-5 sm:mb-6">
                        <label class="block text-sm font-semibold text-black mb-2">Product Name</label>
                        <input type="text" name="name" value="{{ old('name') }}" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:border-black transition-colors text-sm sm:text-base" placeholder="e.g. Modern Sofa" required autofocus>
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div class="mb-5 sm:mb-6">
                        <label class="block text-sm font-semibold text-black mb-2">Category</label>
                        <div class="relative">
                            <select name="category_id" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:border-black transition-colors appearance-none text-sm sm:text-base cursor-pointer" required>
                                <option value="" disabled selected>Select a Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                    </div>

                    <div class="mb-5 sm:mb-6">
                        <label class="block text-sm font-semibold text-black mb-2">Description</label>
                        <textarea name="description" rows="5" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:border-black transition-colors text-sm sm:text-base" placeholder="Describe your product..." required>{{ old('description') }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 sm:gap-6 mb-6">
                        <div>
                            <label class="block text-sm font-semibold text-black mb-2">Price (Rp)</label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 font-semibold">Rp</span>
                                <input type="number" name="price" value="{{ old('price') }}" class="w-full pl-12 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:border-black transition-colors text-sm sm:text-base" placeholder="0" min="0" required>
                            </div>
                            <x-input-error :messages="$errors->get('price')" class="mt-2" />
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-black mb-2">Stock</label>
                            <input type="number" name="stock" value="{{ old('stock') }}" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:border-black transition-colors text-sm sm:text-base" placeholder="0" min="0" required>
                            <x-input-error :messages="$errors->get('stock')" class="mt-2" />
                        </div>
                    </div>

                    <div class="mb-8">
                        <label class="block text-sm font-semibold text-black mb-2">Product Image</label>
                        
                        <div class="flex items-center justify-center w-full">
                            <label for="dropzone-file" class="flex flex-col items-center justify-center w-full h-48 sm:h-64 border-2 border-gray-300 border-dashed rounded-2xl cursor-pointer bg-gray-50 hover:bg-gray-100 transition-colors relative overflow-hidden group">
                                
                                <div class="flex flex-col items-center justify-center pt-5 pb-6 relative z-10 p-4 text-center">
                                    <div class="w-10 h-10 sm:w-12 sm:h-12 mb-3 sm:mb-4 rounded-full bg-gray-200 flex items-center justify-center group-hover:bg-gray-300 transition-colors">
                                        <svg class="w-5 h-5 sm:w-6 sm:h-6 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                                        </svg>
                                    </div>
                                    <p class="mb-1 text-sm text-gray-500"><span class="font-semibold text-black">Click to upload</span></p>
                                    <p class="text-xs text-gray-500">JPG, PNG (Max 2MB)</p>
                                </div>

                                <input id="dropzone-file" type="file" name="image" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"/>
                                <img id="preview" class="absolute inset-0 w-full h-full object-contain bg-white hidden pointer-events-none p-2" />
                            </label>
                        </div>
                        <x-input-error :messages="$errors->get('image')" class="mt-2" />
                    </div>

                    <div class="flex flex-col-reverse sm:flex-row items-center gap-3 sm:gap-4 pt-4 border-t border-gray-100">
                        <a href="{{ route('seller.products.index') }}" class="w-full sm:w-auto px-6 py-3 text-gray-500 font-semibold hover:text-black transition-colors text-center rounded-2xl hover:bg-gray-50">
                            Cancel
                        </a>
                        <button type="submit" class="w-full sm:flex-1 px-6 py-3 bg-black text-white font-semibold rounded-2xl hover:bg-gray-800 transition-all shadow-md hover:shadow-lg">
                            Create Product
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </main>
</x-app-layout>
@endif