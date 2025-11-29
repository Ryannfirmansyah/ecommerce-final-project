<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-2xl bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">
                NexusPlace
            </h2>
        </div>
    </x-slot>

    <!-- Hero Banner Section -->
    <div class="relative bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 overflow-hidden">
        <div class="max-w-[1920px] mx-auto px-8 lg:px-16">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 py-12">
                
                <!-- Main Hero Banner (2 columns) -->
                <div class="lg:col-span-2 group relative overflow-hidden rounded-3xl shadow-2xl h-[500px] bg-gradient-to-br from-gray-100 to-blue-50">
                    <img src="{{ asset('storage/hero/hero-main.jpg') }}" alt="Discover Amazing Products" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent"></div>
                    <div class="relative h-full flex flex-col justify-end p-12">
                        <h1 class="text-5xl font-black text-white mb-4 transform transition-transform duration-500 group-hover:translate-x-2">
                            Discover Amazing Products
                        </h1>
                        <p class="text-xl text-white/90 mb-8 transform transition-transform duration-500 delay-75 group-hover:translate-x-2">
                            Shop from thousands of products with the best prices and quality
                        </p>
                        <div class="flex gap-4 transform transition-transform duration-500 delay-100 group-hover:translate-x-2">
                            <a href="#products" class="px-8 py-4 bg-white text-blue-600 rounded-xl font-bold text-lg hover:bg-blue-50 transform hover:scale-105 transition-all duration-300 shadow-xl">
                                Shop Now
                            </a>
                            <a href="#categories" class="px-8 py-4 bg-white/20 backdrop-blur-sm text-white rounded-xl font-bold text-lg hover:bg-white/30 transform hover:scale-105 transition-all duration-300 border-2 border-white/50">
                                Browse Categories
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Side Promo Cards -->
                <div class="flex flex-col gap-6">
                    <!-- Promo Card 1 - Fashion -->
                    <div class="group relative overflow-hidden rounded-3xl shadow-xl h-[240px] bg-gradient-to-br from-cyan-400 to-blue-500">
                        <img src="{{ asset('storage/hero/promo-fashion.jpg') }}" alt="Fresh Fashion" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110 group-hover:rotate-2">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                        <div class="relative h-full flex flex-col justify-end p-8">
                            <h3 class="text-3xl font-black text-white mb-3">Fresh Arrivals</h3>
                            <a href="{{ route('home', ['category' => 3]) }}" class="inline-flex items-center text-white font-semibold group-hover:gap-3 gap-2 transition-all">
                                Shop Fashion
                                <svg class="w-5 h-5 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                </svg>
                            </a>
                        </div>
                    </div>

                    <!-- Promo Card 2 - Electronics -->
                    <div class="group relative overflow-hidden rounded-3xl shadow-xl h-[240px] bg-gradient-to-br from-blue-500 to-purple-600">
                        <img src="{{ asset('storage/hero/promo-electronics.jpg') }}" alt="Latest Electronics" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110 group-hover:rotate-2">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                        <div class="relative h-full flex flex-col justify-end p-8">
                            <h3 class="text-3xl font-black text-white mb-3">Latest Electronics</h3>
                            <a href="{{ route('home', ['category' => 1]) }}" class="inline-flex items-center text-white font-semibold group-hover:gap-3 gap-2 transition-all">
                                Shop Now
                                <svg class="w-5 h-5 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="bg-gray-50 min-h-screen pb-12">
        <div class="max-w-[1920px] mx-auto px-8 lg:px-16">
            
            <!-- Category Showcase Section -->
            <div class="bg-white rounded-3xl shadow-lg p-10 mb-10 -mt-16 relative z-10" id="categories">
                <h3 class="text-3xl font-black text-gray-900 mb-8 text-center">Shop by Category</h3>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-8">
                    
                    <!-- Electronics -->
                    <a href="{{ route('home', ['category' => 1]) }}" class="group">
                        <div class="relative overflow-hidden rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                            <img src="{{ asset('storage/categories/electronics.jpg') }}" alt="Electronics" class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                            <div class="absolute bottom-0 left-0 right-0 p-4">
                                <h4 class="text-lg font-bold text-white">Electronics</h4>
                                <p class="text-sm text-white/80">Laptops, Phones & More</p>
                            </div>
                        </div>
                    </a>

                    <!-- Gaming -->
                    <a href="{{ route('home', ['category' => 2]) }}" class="group">
                        <div class="relative overflow-hidden rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                            <img src="{{ asset('storage/categories/gaming.jpg') }}" alt="Gaming" class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                            <div class="absolute bottom-0 left-0 right-0 p-4">
                                <h4 class="text-lg font-bold text-white">Gaming</h4>
                                <p class="text-sm text-white/80">Console & Accessories</p>
                            </div>
                        </div>
                    </a>

                    <!-- Fashion -->
                    <a href="{{ route('home', ['category' => 3]) }}" class="group">
                        <div class="relative overflow-hidden rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                            <img src="{{ asset('storage/categories/fashion.jpg') }}" alt="Fashion" class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                            <div class="absolute bottom-0 left-0 right-0 p-4">
                                <h4 class="text-lg font-bold text-white">Fashion</h4>
                                <p class="text-sm text-white/80">Shoes, Clothes & Bags</p>
                            </div>
                        </div>
                    </a>

                    <!-- Books -->
                    <a href="{{ route('home', ['category' => 4]) }}" class="group">
                        <div class="relative overflow-hidden rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                            <img src="{{ asset('storage/categories/books.jpg') }}" alt="Books" class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                            <div class="absolute bottom-0 left-0 right-0 p-4">
                                <h4 class="text-lg font-bold text-white">Books</h4>
                                <p class="text-sm text-white/80">Fiction & Educational</p>
                            </div>
                        </div>
                    </a>

                    <!-- Home & Living -->
                    <a href="{{ route('home', ['category' => 5]) }}" class="group">
                        <div class="relative overflow-hidden rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                            <img src="{{ asset('storage/categories/home.jpg') }}" alt="Home & Living" class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                            <div class="absolute bottom-0 left-0 right-0 p-4">
                                <h4 class="text-lg font-bold text-white">Home & Living</h4>
                                <p class="text-sm text-white/80">Furniture & Decor</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Trust Badges -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-12">
                <div class="bg-white rounded-2xl p-6 shadow-md hover:shadow-xl transition-shadow duration-300 flex items-center gap-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-green-100 to-emerald-100 rounded-full flex items-center justify-center flex-shrink-0">
                        <svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-900">Free Shipping</h4>
                        <p class="text-sm text-gray-600">On orders over Rp 100k</p>
                    </div>
                </div>

                <div class="bg-white rounded-2xl p-6 shadow-md hover:shadow-xl transition-shadow duration-300 flex items-center gap-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-blue-100 to-indigo-100 rounded-full flex items-center justify-center flex-shrink-0">
                        <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-900">Secure Payment</h4>
                        <p class="text-sm text-gray-600">100% secure payment</p>
                    </div>
                </div>

                <div class="bg-white rounded-2xl p-6 shadow-md hover:shadow-xl transition-shadow duration-300 flex items-center gap-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-purple-100 to-pink-100 rounded-full flex items-center justify-center flex-shrink-0">
                        <svg class="w-7 h-7 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-900">Quality Guarantee</h4>
                        <p class="text-sm text-gray-600">Certified products</p>
                    </div>
                </div>

                <div class="bg-white rounded-2xl p-6 shadow-md hover:shadow-xl transition-shadow duration-300 flex items-center gap-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-orange-100 to-red-100 rounded-full flex items-center justify-center flex-shrink-0">
                        <svg class="w-7 h-7 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-900">24/7 Support</h4>
                        <p class="text-sm text-gray-600">Dedicated support</p>
                    </div>
                </div>
            </div>

            <!-- Search & Filter -->
            <div class="bg-white overflow-hidden shadow-lg rounded-2xl mb-8" id="products">
                <div class="p-8">
                    <form method="GET" action="{{ route('home') }}" class="grid grid-cols-1 md:grid-cols-4 gap-6">
                        <!-- Search -->
                        <div class="md:col-span-2">
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                    </svg>
                                </div>
                                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search products..." class="block w-full pl-12 pr-4 py-3.5 border-2 border-gray-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-100 rounded-xl shadow-sm transition-all duration-200">
                            </div>
                        </div>

                        <!-- Category Filter -->
                        <div>
                            <select name="category" class="block w-full px-4 py-3.5 border-2 border-gray-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-100 rounded-xl shadow-sm transition-all duration-200">
                                <option value="">All Categories</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Sort -->
                        <div>
                            <select name="sort" class="block w-full px-4 py-3.5 border-2 border-gray-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-100 rounded-xl shadow-sm transition-all duration-200">
                                <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest</option>
                                <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                                <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                            </select>
                        </div>

                        <div class="md:col-span-4 flex justify-end gap-3">
                            <button type="submit" class="inline-flex items-center px-6 py-3.5 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 border border-transparent rounded-xl font-semibold text-sm text-white uppercase tracking-widest shadow-lg hover:shadow-xl active:scale-95 transition-all duration-200">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                                </svg>
                                Apply Filters
                            </button>
                            @if(request()->hasAny(['search', 'category', 'sort']))
                                <a href="{{ route('home') }}" class="inline-flex items-center px-6 py-3.5 bg-gray-200 hover:bg-gray-300 border border-transparent rounded-xl font-semibold text-sm text-gray-700 uppercase tracking-widest active:scale-95 transition-all duration-200">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                    Clear
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            <!-- Products Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5 gap-6">
                @forelse($products as $product)
                    <div class="group bg-white overflow-hidden shadow-md hover:shadow-2xl rounded-2xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-100">
                        <div class="relative overflow-hidden bg-gray-50 h-72">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-gray-100 to-gray-200">
                                    <svg class="w-20 h-20 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            @endif
                            
                            <!-- Stock Badge -->
                            @if($product->stock == 0)
                                <span class="absolute top-3 right-3 px-3 py-1.5 text-xs font-bold rounded-lg bg-red-500 text-white shadow-lg">
                                    Out of Stock
                                </span>
                            @elseif($product->stock < 10)
                                <span class="absolute top-3 right-3 px-3 py-1.5 text-xs font-bold rounded-lg bg-yellow-500 text-white shadow-lg">
                                    Low Stock
                                </span>
                            @endif

                            <!-- Quick View Overlay -->
                            <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center gap-3">
                                <a href="{{ route('products.show', $product) }}" class="px-6 py-3 bg-white text-gray-900 rounded-lg font-semibold text-sm hover:bg-gray-100 transform hover:scale-105 transition-all duration-200 shadow-xl">
                                    Quick View
                                </a>
                            </div>
                        </div>
                        
                        <div class="p-5">
                            <a href="{{ route('products.show', $product) }}" class="block">
                                <span class="text-xs font-semibold text-blue-600 uppercase tracking-wide">{{ $product->category->name }}</span>
                                <h3 class="font-bold text-lg text-gray-900 group-hover:text-blue-600 transition-colors duration-200 line-clamp-2 min-h-[3.5rem] mt-1">
                                    {{ $product->name }}
                                </h3>
                            </a>
                            
                            <div class="mt-4 flex items-center justify-between">
                                <div>
                                    <span class="text-2xl font-black text-gray-900">
                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </span>
                                </div>
                                <span class="text-xs font-semibold px-3 py-1.5 rounded-lg {{ $product->stock > 10 ? 'bg-green-50 text-green-700 border border-green-200' : ($product->stock > 0 ? 'bg-yellow-50 text-yellow-700 border border-yellow-200' : 'bg-red-50 text-red-700 border border-red-200') }}">
                                    Stock: {{ $product->stock }}
                                </span>
                            </div>
                            
                            <div class="mt-3 flex items-center">
                                <div class="flex items-center">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= floor($product->averageRating()))
                                            <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                        @else
                                            <svg class="w-4 h-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                        @endif
                                    @endfor
                                </div>
                                <span class="ml-2 text-sm font-medium text-gray-700">{{ number_format($product->averageRating(), 1) }}</span>
                                <span class="ml-1 text-xs text-gray-500">({{ $product->totalReviews() }})</span>
                            </div>
                            
                            <div class="mt-4 flex items-center text-sm text-gray-600 bg-gray-50 rounded-lg px-3 py-2">
                                <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                                <span>{{ $product->store->name }}</span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-16 bg-white rounded-2xl shadow-lg">
                        <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gray-100 mb-4">
                            <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">No products found</h3>
                        <p class="text-gray-500 mb-6">Try adjusting your search or filter.</p>
                        <a href="{{ route('home') }}" class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-semibold transition-all duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                            </svg>
                            Reset Filters
                        </a>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</x-app-layout>