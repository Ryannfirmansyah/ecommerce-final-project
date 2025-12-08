@php
    $cartCount = 0;
    $wishCount = 0;
    if(auth()->check() && auth()->user()->role === 'buyer') {
        $cartCount = \App\Models\Cart::where('user_id', auth()->id())->count();
        $wishCount = \App\Models\Wishlist::where('user_id', auth()->id())->count();
    }
@endphp

<nav x-data="{ mobileMenuOpen: false, searchOpen: false }" class="bg-white/90 backdrop-blur-md sticky top-0 z-50 border-b border-gray-100 transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 h-16 sm:h-20 flex items-center justify-between gap-4">

        <div class="flex items-center gap-2 shrink-0">
            <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                <div class="w-9 h-9 bg-black rounded-full flex items-center justify-center text-white font-bold text-lg group-hover:bg-gray-800 transition-colors">N</div>
                <span class="text-xl font-bold tracking-tight text-gray-900">NexusPlace</span>
            </a>
        </div>

        <div class="hidden md:flex flex-1 max-w-lg mx-8">
            <form action="{{ route('shop') }}" method="GET" class="w-full relative group">
                @if(request('category')) <input type="hidden" name="category" value="{{ request('category') }}"> @endif
                @if(request('sort')) <input type="hidden" name="sort" value="{{ request('sort') }}"> @endif
                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       placeholder="Search for furniture, electronics..."
                       class="w-full bg-gray-100 border-none rounded-full py-2.5 pl-12 pr-4 text-sm text-gray-900 placeholder-gray-500 focus:ring-2 focus:ring-black/5 focus:bg-white transition-all shadow-sm group-hover:shadow-md"
                >
                <button type="submit" class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-black transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </button>
            </form>
        </div>

        <div class="flex items-center gap-1 sm:gap-3">

            <button @click="searchOpen = !searchOpen" class="md:hidden p-2 text-gray-600 hover:bg-gray-100 rounded-full transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </button>

            <div class="hidden md:flex items-center gap-6 mr-4">
                <a href="{{ route('home') }}" class="text-sm font-medium transition-colors {{ request()->routeIs('home') ? 'text-black font-bold' : 'text-gray-600 hover:text-black' }}">Home</a>
                <a href="{{ route('shop') }}" class="text-sm font-medium transition-colors {{ request()->routeIs('shop.*') ? 'text-black font-bold' : 'text-gray-600 hover:text-black' }}">Shop</a>
            </div>

            @auth
                <div class="flex items-center gap-1 sm:gap-2 border-l border-gray-200 pl-2 sm:pl-4">

                    @if(auth()->user()->role === 'buyer')
                        <a href="{{route('buyer.wishlist.index')}}" class="relative hidden sm:flex p-2 text-gray-500 hover:text-red-500 hover:bg-red-50 rounded-full transition-all" title="Wishlist">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                            @if($wishCount > 0)
                                <span class="absolute top-1 right-1 inline-flex items-center justify-center w-4 h-4 text-[10px] font-bold text-white bg-black rounded-full ring-2 ring-white transform translate-x-1/4 -translate-y-1/4">
                                    {{ $wishCount }}
                                </span>
                            @endif
                        </a>

                        <a href="{{ route('buyer.orders.index') }}" class="hidden sm:flex p-2 text-gray-500 hover:text-blue-600 hover:bg-blue-50 rounded-full transition-all" title="My Orders">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                        </a>

                        <a href="{{ route('buyer.cart.index') }}" class="relative p-2 text-gray-500 hover:text-black hover:bg-gray-100 rounded-full transition-all group" title="Cart">
                            <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                            @if($cartCount > 0)
                                <span class="absolute top-1 right-1 inline-flex items-center justify-center w-4 h-4 text-[10px] font-bold text-white bg-black rounded-full ring-2 ring-white transform translate-x-1/4 -translate-y-1/4">
                                    {{ $cartCount }}
                                </span>
                            @endif
                        </a>
                    @endif

                    <div class="relative ml-1" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center gap-2 focus:outline-none p-1 rounded-full hover:ring-2 hover:ring-gray-100 transition-all">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=000&color=fff&size=64" class="w-8 h-8 rounded-full border border-gray-200 object-cover">
                        </button>

                        <div x-show="open" @click.away="open = false"
                             x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95"
                             class="absolute right-0 mt-3 w-56 bg-white rounded-2xl shadow-xl border border-gray-100 py-2 z-50 overflow-hidden"
                             style="display: none;">

                            <div class="px-4 py-3 border-b border-gray-100 bg-gray-50/50">
                                <p class="text-sm font-bold text-gray-900 truncate">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-gray-500 capitalize">{{ Auth::user()->role }} Account</p>
                            </div>

                            <div class="py-1">
                                <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-black">
                                    <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    Settings
                                </a>
                            </div>

                            <div class="border-t border-gray-100 my-1"></div>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="flex w-full items-center px-4 py-2 text-sm text-red-600 hover:bg-red-50 hover:text-red-700">
                                    <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                    Sign Out
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @else
                <div class="hidden md:flex items-center gap-3 ml-4">
                    <a href="{{ route('login') }}" class="px-4 py-2 text-sm font-semibold text-gray-700 hover:text-black hover:bg-gray-50 rounded-lg transition-colors">Login</a>
                    <a href="{{ route('register') }}" class="px-5 py-2.5 text-sm font-bold bg-black text-white rounded-full hover:bg-gray-800 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">Sign Up</a>
                </div>
            @endauth

            <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden p-2 text-gray-600 hover:bg-gray-100 rounded-lg ml-1">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path :class="{'hidden': mobileMenuOpen, 'inline-flex': !mobileMenuOpen }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    <path :class="{'hidden': !mobileMenuOpen, 'inline-flex': mobileMenuOpen }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>

    <div x-show="searchOpen" x-collapse class="md:hidden border-b border-gray-100 bg-white px-4 py-3">
        <form action="{{ route('shop') }}" method="GET" class="relative">
            @if(request('category')) <input type="hidden" name="category" value="{{ request('category') }}"> @endif
            @if(request('sort')) <input type="hidden" name="sort" value="{{ request('sort') }}"> @endif
            <input type="text"
                name="search"
                placeholder="Search..."
                value="{{request('search')}}"
                class="w-full bg-gray-50 border-gray-200 rounded-lg py-2 pl-10 pr-4 text-sm focus:ring-black focus:border-black"
            >

            <button type="submit" class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-black transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </button>
        </form>
    </div>

    <div x-show="mobileMenuOpen" x-collapse @click.away="mobileMenuOpen = false" class="md:hidden border-b border-gray-100 bg-white shadow-lg">
        <div class="space-y-1 pt-2 pb-3">

            <a href="{{ route('home') }}"
               class="block w-full pl-3 pr-4 py-3 border-l-4 text-left text-base font-medium transition-colors duration-150 ease-in-out
               {{ request()->routeIs('home')
                   ? 'border-black text-black bg-gray-50'
                   : 'border-transparent text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300' }}">
                Home
            </a>

            <a href="{{ route('shop') }}"
               class="block w-full pl-3 pr-4 py-3 border-l-4 text-left text-base font-medium transition-colors duration-150 ease-in-out
               {{ request()->routeIs('shop')
                   ? 'border-black text-black bg-gray-50'
                   : 'border-transparent text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300' }}">
                Shop
            </a>

            @auth
                @if(auth()->user()->role === 'buyer')
                    <a href="{{route('buyer.wishlist.index')}}"
                        class="block w-full pl-3 pr-4 py-3 border-l-4 text-left text-base font-medium transition-colors duration-150 ease-in-out border-transparent text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300"
                    >
                        <svg class="w-5 h-5 inline " fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                        Wishlist
                    </a>

                    <a href="{{ route('buyer.orders.index') }}"
                       class="block w-full pl-3 pr-4 py-3 border-l-4 text-left text-base font-medium transition-colors duration-150 ease-in-out
                       {{ request()->routeIs('buyer.orders.*')
                           ? 'border-black text-black bg-gray-50'
                           : 'border-transparent text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300' }}"
                    >

                        <svg class="w-5 h-5 inline " fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                        My Orders
                    </a>

                    {{-- 3. Link My Cart --}}
                    <a href="{{ route('buyer.cart.index') }}"
                       class="block w-full pl-3 pr-4 py-3 border-l-4 text-left text-base font-medium transition-colors duration-150 ease-in-out
                       {{ request()->routeIs('buyer.cart.*')
                           ? 'border-black text-black bg-gray-50'
                           : 'border-transparent text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300' }}"
                    >
                        <svg class="w-5 h-5 inline  group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        My Cart
                    </a>

                    {{-- 4. Link Wishlist --}}

                @endif
            @else
                {{-- Tombol Login/Register Mobile --}}
                <div class="mt-3 space-y-1 border-t border-gray-200 pt-3 pb-2 px-4">
                    <a href="{{ route('login') }}"
                       class="block w-full text-center py-2.5 border border-gray-300 rounded-lg text-base font-medium text-gray-700 hover:bg-gray-50 transition-colors mb-2">
                       Login
                    </a>
                    <a href="{{ route('register') }}"
                       class="block w-full text-center py-2.5 bg-black text-white rounded-lg text-base font-bold hover:bg-gray-800 transition-colors">
                       Sign Up
                    </a>
                </div>
            @endauth
        </div>
    </div>
</nav>