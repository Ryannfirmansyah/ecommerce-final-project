<x-guest-layout>

    <main class="max-w-7xl mx-auto px-6 pb-24">
        <header class="relative px-4 sm:px-6 lg:px-8 pt-6 pb-12 lg:pt-10 lg:pb-24 group">
            <div class="relative h-[50vh] sm:h-[60vh] lg:h-[600px] rounded-[2rem] sm:rounded-[3rem] overflow-hidden shadow-2xl">
                <img src="https://images.unsplash.com/photo-1618221195710-dd6b41faaea6?q=80&w=2000&auto=format&fit=crop"
                    alt="Interior"
                    class="w-full h-full object-cover transition-transform duration-700 ease-in-out group-hover:scale-105">

                <div class="absolute inset-0 bg-gradient-to-b from-black/20 via-transparent to-black/60"></div>
            </div>

            <div class="absolute inset-4 flex items-center justify-center pointer-events-none z-10">
                <h1 class="text-[5rem] sm:text-[8rem] lg:text-[13rem] font-bold text-white leading-none font-serif drop-shadow-2xl opacity-90 select-none tracking-tighter">
                    Shop
                </h1>
            </div>

            <div class="relative -mt-16 mx-4 sm:absolute -bottom-8 sm:mt-0 sm:bottom-8 sm:left-8 sm:right-8 lg:bottom-12 lg:left-12 lg:right-12 z-20">

                <div class="max-w-5xl mx-auto sm:bg-white/80 backdrop-blur-md border border-white/20 rounded-3xl p-2 shadow-2xl flex flex-col sm:flex-row items-center gap-4 sm:gap-6">

                    <div class="w-full sm:w-1/3 text-center sm:text-left px-4 sm:pl-6 pt-4 sm:pt-0  text-white">
                        <h2 class="text-lg sm:text-xl font-bold md:text-gray-900 leading-tight">Give All You Need</h2>
                        <p class="text-xs sm:text-sm sm:text-gray-500 mt-0.5">Furniture, electronics & more</p>
                    </div>

                    <div class="hidden sm:block w-px h-10 bg-gray-300"></div>

                    <form action="{{ route('shop') }}" method="GET" class="w-full flex flex-col sm:flex-row items-center gap-4 sm:gap-6 px-4 sm:pr-6 pb-4 sm:pb-0">
                        <div class="flex-1 w-full flex items-center gap-2 bg-gray-50 sm:bg-white/50 border border-gray-200 sm:border-transparent rounded-2xl px-4 py-2 mx-2 transition-all focus-within:bg-white focus-within:ring-2 focus-within:ring-black/5 focus-within:border-gray-300">
                            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2.5-4.5A7.5 7.5 0 1110.5 3a7.5 7.5 0 017.5 7.5z"/></svg>
                            <input type="text"
                                name="search"
                                value=""
                                placeholder="Search on NexusPlace..."
                                class="bg-transparent border-none outline-none w-full text-sm text-gray-900 placeholder-gray-500 h-10 focus:ring-0">
                        </div>

                        <button class="w-full sm:w-auto bg-black hover:bg-gray-800 text-white px-8 py-3.5 rounded-2xl text-sm font-bold transition-all transform active:scale-95 shadow-lg">
                            Search
                        </button>
                    </div>

                </div>
            </div>
        </header>

        <section class="pt-8">

            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-16">

                <div class="flex flex-col justify-center">
                    <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-6 leading-tight">
                        Shop <br> by categories
                    </h2>

                    <div class="flex items-center gap-4 mb-8">
                        <div class="w-10 h-10 border border-black rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                        </div>
                        <div>
                            <p class="font-bold text-gray-900 text-sm">200 +</p>
                            <p class="text-xs text-gray-500">Unique products</p>
                        </div>
                    </div>

                    <a href="{{ route('home') }}" class="text-xs font-bold text-gray-900 uppercase tracking-wide border-b-2 border-black w-max pb-1 hover:text-rose-500 hover:border-rose-500 transition-colors">
                        All Categories &rarr;
                    </a>
                </div>

                @foreach($categories as $category)
                    @include('components.category', ['category' => $category])
                @endforeach

            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                <div class="relative h-[300px] md:h-[400px] bg-gray-200 overflow-hidden group">
                    <img src="{{ asset('storage/hero/promo-fashion.jpg') }}" alt="Living Room" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">

                    <div class="absolute inset-0 bg-black/10 group-hover:bg-black/20 transition-colors"></div>

                    <div class="absolute inset-6 border border-white/80 z-10 flex flex-col justify-center items-center text-center p-6">
                        <p class="text-white text-xs font-medium uppercase tracking-widest mb-2">30% Off All Order</p>
                        <h3 class="text-white text-3xl md:text-4xl font-bold mb-6">Fashion</h3>

                        <a href="#" class="bg-rose-500 text-white px-8 py-3 rounded-full text-sm font-semibold hover:bg-rose-600 transition-colors shadow-lg">
                            Shop now
                        </a>
                    </div>
                </div>

                <div class="relative h-[300px] md:h-[400px] bg-gray-200 overflow-hidden group">
                    <img src="{{ asset('storage/hero/promo-electronics.jpg') }}" alt="Dining Room" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">

                    <div class="absolute inset-0 bg-black/10 group-hover:bg-black/20 transition-colors"></div>

                    <div class="absolute inset-6 border border-white/80 z-10 flex flex-col justify-center items-center text-center p-6">
                        <p class="text-white text-xs font-medium uppercase tracking-widest mb-2">30% Off All Order</p>
                        <h3 class="text-white text-3xl md:text-4xl font-bold mb-6">Electronic</h3>

                        <a href="#" class="bg-rose-500 text-white px-8 py-3 rounded-full text-sm font-semibold hover:bg-rose-600 transition-colors shadow-lg">
                            Shop now
                        </a>
                    </div>
                </div>

            </div>

        </section>

        <x-hot-product :latestProducts="$latestProducts" :topRatedProducts="$topRatedProducts" :bestSellerProducts="$bestSellerProducts" />
    </main>

</x-guest-layout>