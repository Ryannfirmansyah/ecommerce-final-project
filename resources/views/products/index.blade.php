<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'NexusPlace') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body { font-family: 'Inter', sans-serif; }
        .font-serif { font-family: 'Playfair Display', serif; }
        /* Hide scrollbar for category sidebar */
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="bg-gray-50 text-gray-900 antialiased selection:bg-black selection:text-white">

    <nav class="bg-white/80 backdrop-blur-md sticky top-0 z-50 border-b border-gray-100">
        <div class="max-w-[1600px] mx-auto px-6 h-20 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 bg-black rounded-full flex items-center justify-center text-white font-bold text-lg">N</div>
                <a href="{{ route('home') }}" class="text-xl font-bold tracking-tight">NexusPlace</a>
            </div>

            <div class="hidden md:flex space-x-8 text-sm font-medium text-gray-500">
                <a href="#" class="text-black font-semibold">Beranda</a>
                <a href="#shop" class="hover:text-black transition">Shop</a>
                <a href="#" class="hover:text-black transition">Blog</a>
            </div>

            <div class="flex items-center gap-4">
                <button class="p-2 hover:bg-gray-100 rounded-full transition text-gray-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </button>

                @auth
                    @if(auth()->user()->role === 'buyer')
                    <a href="{{ route('cart.index') }}" class="relative p-2 hover:bg-gray-100 rounded-full transition text-gray-500">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                        @php $cartCount = \App\Models\Cart::where('user_id', auth()->id())->sum('quantity'); @endphp
                        @if($cartCount > 0)
                            <span class="absolute top-1 right-1 w-2.5 h-2.5 bg-red-500 rounded-full border-2 border-white"></span>
                        @endif
                    </a>
                    @endif

                    <div class="relative ml-2" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center gap-2">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=000&color=fff" class="w-8 h-8 rounded-full border border-gray-200">
                        </button>
                        <div x-show="open" @click.away="open = false" class="absolute right-0 mt-3 w-48 bg-white rounded-2xl shadow-xl py-2 border border-gray-100 z-50" style="display: none;">
                            <div class="px-4 py-2 border-b border-gray-100">
                                <p class="text-sm font-semibold">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-gray-500">{{ ucfirst(Auth::user()->role) }}</p>
                            </div>
                            <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Dashboard</a>
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Settings</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 font-medium">Log Out</button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-medium hover:text-black">Login</a>
                    <a href="{{ route('register') }}" class="px-5 py-2.5 text-sm font-bold bg-black text-white rounded-full hover:bg-gray-800 transition shadow-lg shadow-gray-200/50">Sign Up</a>
                @endauth
            </div>
        </div>
    </nav>

    <header class="relative bg-white pt-10 pb-20 overflow-hidden">
        <div class="max-w-[1600px] mx-auto px-6 relative">
            <div class="relative h-[400px] md:h-[500px] rounded-[3rem] overflow-hidden">
                <img src="https://images.unsplash.com/photo-1618221195710-dd6b41faaea6?q=80&w=2000&auto=format&fit=crop"
                     alt="Interior" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent"></div>
            </div>

            <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-center w-full z-10">
                <h1 class="text-[8rem] md:text-[12rem] font-bold text-white leading-none font-serif drop-shadow-lg opacity-90 select-none">Shop</h1>
            </div>

            <div class="absolute bottom-12 left-0 right-0 px-12">
                <div class="max-w-5xl mx-auto bg-white/90 backdrop-blur-md rounded-full p-2 pl-8 flex justify-between items-center shadow-2xl">
                    <div>
                        <h2 class="text-xl font-bold text-gray-900">Give All You Need</h2>
                        <p class="text-xs text-gray-500">Discover furniture, electronics & more</p>
                    </div>

                    <form action="{{ route('home') }}" method="GET" class="flex items-center bg-gray-100 rounded-full px-4 py-2 w-1/2">
                        <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search on NexusPlace..." class="bg-transparent border-none outline-none w-full text-sm">
                    </form>

                    <button class="bg-black text-white px-8 py-3 rounded-full text-sm font-bold hover:bg-gray-800 transition">Search</button>
                </div>
            </div>
        </div>
    </header>

    <main id="shop" class="max-w-[1600px] mx-auto px-6 pb-24">
        <div class="flex flex-col lg:flex-row gap-12">

            <aside class="w-full lg:w-64 flex-shrink-0">
                <div class="sticky top-28 space-y-8">
                    <div>
                        <h3 class="font-bold text-lg mb-6 flex items-center gap-2">
                            Category
                        </h3>

                        <div class="space-y-2">
                            <a href="{{ route('home') }}" class="flex items-center justify-between px-4 py-3 rounded-2xl text-sm font-medium transition {{ !request('category') ? 'bg-black text-white shadow-lg' : 'bg-white text-gray-500 hover:bg-gray-50' }}">
                                <div class="flex items-center gap-3">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                                    All Product
                                </div>
                                <span class="text-xs {{ !request('category') ? 'text-gray-300' : 'text-gray-400' }}">{{ \App\Models\Product::count() }}</span>
                            </a>

                            @foreach(\App\Models\Category::all() as $category)
                            <a href="{{ route('home', ['category' => $category->id]) }}"
                               class="flex items-center justify-between px-4 py-3 rounded-2xl text-sm font-medium transition group {{ request('category') == $category->id ? 'bg-black text-white shadow-lg' : 'bg-white text-gray-500 hover:bg-gray-50' }}">
                                <div class="flex items-center gap-3">
                                    <span class="w-6 h-6 rounded-lg flex items-center justify-center text-xs font-bold {{ request('category') == $category->id ? 'bg-gray-800' : 'bg-gray-100 text-gray-400 group-hover:text-black' }}">
                                        {{ substr($category->name, 0, 1) }}
                                    </span>
                                    {{ $category->name }}
                                </div>
                            </a>
                            @endforeach
                        </div>
                    </div>

                    <div>
                        <h3 class="font-bold text-sm text-gray-400 uppercase tracking-wider mb-4">Filter</h3>
                        <div class="space-y-3">
                            <label class="flex items-center space-x-3 cursor-pointer group">
                                <div class="w-5 h-5 rounded-md border-2 border-gray-200 flex items-center justify-center group-hover:border-black transition">
                                    </div>
                                <span class="text-sm text-gray-600 group-hover:text-black">New Arrival</span>
                            </label>
                            <label class="flex items-center space-x-3 cursor-pointer group">
                                <div class="w-5 h-5 rounded-md border-2 border-gray-200 flex items-center justify-center group-hover:border-black transition"></div>
                                <span class="text-sm text-gray-600 group-hover:text-black">Best Seller</span>
                            </label>
                            <label class="flex items-center space-x-3 cursor-pointer group">
                                <div class="w-5 h-5 rounded-md border-2 border-gray-200 flex items-center justify-center group-hover:border-black transition"></div>
                                <span class="text-sm text-gray-600 group-hover:text-black">On Discount</span>
                            </label>
                        </div>
                    </div>
                </div>
            </aside>

            <div class="flex-1">
                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-8">
                    @forelse($products as $product)
                    <div class="bg-white rounded-[2rem] p-4 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group border border-transparent hover:border-gray-100">

                        <div class="relative bg-gray-50 rounded-[1.5rem] h-[280px] flex items-center justify-center overflow-hidden mb-5">
                            <span class="absolute top-4 right-4 bg-white px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider shadow-sm z-10">
                                {{ $product->category->name }}
                            </span>

                            <a href="{{ route('products.show', $product) }}">
                                <img src="{{ asset('storage/' . $product->image) }}"
                                     alt="{{ $product->name }}"
                                     class="h-48 object-contain mix-blend-multiply group-hover:scale-110 transition duration-500"
                                     onerror="this.src='https://placehold.co/400x400/png?text=No+Image'">
                            </a>
                        </div>

                        <div class="px-2">
                            <div class="flex justify-between items-start mb-2">
                                <h3 class="font-bold text-lg text-gray-900 leading-tight group-hover:text-blue-600 transition w-2/3">
                                    <a href="{{ route('products.show', $product) }}">{{ $product->name }}</a>
                                </h3>
                                <div class="flex items-center gap-1 text-yellow-400 text-xs">
                                    <span>★</span>
                                    <span class="text-gray-400 font-medium">5.0</span>
                                </div>
                            </div>

                            <p class="text-xs text-gray-400 mb-4">{{ $product->store->name ?? 'Nexus Store' }}</p>

                            <div class="flex items-center justify-between mt-4">
                                <span class="text-2xl font-bold text-gray-900">
                                    ${{ number_format($product->price, 0, ',', '.') }}
                                </span>
                            </div>

                            <div class="grid grid-cols-2 gap-3 mt-5">
                                @auth
                                    @if(auth()->user()->role === 'buyer')
                                        <form action="{{ route('cart.store', $product->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="w-full py-3 rounded-xl border-2 border-gray-100 text-sm font-bold text-gray-600 hover:border-black hover:text-black transition">
                                                Add to Cart
                                            </button>
                                        </form>
                                    @else
                                        <button disabled class="w-full py-3 rounded-xl border-2 border-gray-100 text-sm font-bold text-gray-400 cursor-not-allowed">
                                            Add to Cart
                                        </button>
                                    @endif
                                @else
                                    <a href="{{ route('login') }}" class="flex items-center justify-center w-full py-3 rounded-xl border-2 border-gray-100 text-sm font-bold text-gray-600 hover:border-black hover:text-black transition">
                                        Add to Cart
                                    </a>
                                @endauth

                                <a href="{{ route('products.show', $product) }}" class="flex items-center justify-center w-full py-3 rounded-xl bg-black text-white text-sm font-bold hover:bg-gray-800 shadow-lg shadow-gray-200 transition">
                                    Buy Now
                                </a>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-span-full py-20 text-center">
                        <div class="inline-block p-6 rounded-full bg-gray-50 mb-4">
                            <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900">No Products Found</h3>
                        <p class="text-gray-500 mt-2">Try selecting a different category.</p>
                    </div>
                    @endforelse
                </div>

                <div class="mt-16">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </main>

    <div class="max-w-[1600px] mx-auto px-6 pb-6">
        <div class="bg-neutral-900 rounded-[3rem] p-12 md:p-20 text-white relative overflow-hidden">
            <div class="relative z-10 max-w-2xl">
                <h2 class="text-4xl md:text-6xl font-bold mb-6 font-serif">Ready to Get<br>Our New Stuff?</h2>

                <form class="mt-10 relative max-w-md">
                    <input type="email" placeholder="Your Email" class="w-full bg-white text-black pl-8 pr-32 py-5 rounded-full focus:outline-none focus:ring-4 focus:ring-gray-700 transition">
                    <button class="absolute right-2 top-2 bg-black text-white px-8 py-3 rounded-full text-sm font-bold hover:bg-gray-800 transition">Send</button>
                </form>
            </div>

            <div class="mt-24 pt-8 border-t border-gray-800 flex flex-col md:flex-row justify-between items-center text-xs text-gray-500 font-medium tracking-wide">
                <div class="space-y-4 md:space-y-0 md:space-x-8 flex flex-col md:flex-row">
                    <div>
                        <h4 class="text-white font-bold mb-2">About</h4>
                        <ul class="space-y-1">
                            <li><a href="#" class="hover:text-white transition">Blog</a></li>
                            <li><a href="#" class="hover:text-white transition">Meet The Team</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="text-white font-bold mb-2">Support</h4>
                        <ul class="space-y-1">
                            <li><a href="#" class="hover:text-white transition">Contact Us</a></li>
                            <li><a href="#" class="hover:text-white transition">Shipping</a></li>
                        </ul>
                    </div>
                </div>

                <p class="mt-8 md:mt-0">&copy; 2025 NexusPlace. All Rights Reserved.</p>

                <div class="flex gap-4 mt-4 md:mt-0">
                    <a href="#" class="w-10 h-10 bg-white text-black rounded-full flex items-center justify-center font-bold hover:bg-gray-200 transition">X</a>
                    <a href="#" class="w-10 h-10 bg-white text-black rounded-full flex items-center justify-center font-bold hover:bg-gray-200 transition">in</a>
                </div>
            </div>
        </div>
    </div>

</body>
</html>