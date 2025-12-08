<section x-data="{ activeTab: 'latest' }" class="pt-8">

    <div class="flex flex-col md:flex-row justify-between items-center mb-12 border-b border-gray-100 pb-4 md:pb-0 md:border-none gap-4 md:gap-0">

        <div class="relative">
            <h2 class="text-2xl font-bold text-gray-900">Hot Products</h2>
            <div class="w-8 h-1 bg-rose-500 mt-2 rounded-full"></div>
        </div>

        <div class="flex items-center gap-8 text-sm font-semibold text-gray-400 uppercase tracking-wider">

            <button
                @click="activeTab = 'latest'"
                :class="{ 'text-rose-500 border-b-2 border-rose-500 pb-2': activeTab === 'latest', 'hover:text-gray-600 pb-2': activeTab !== 'latest' }"
                class="transition-all duration-300"
            >
                Latest Products
            </button>

            <button
                @click="activeTab = 'top_rating'"
                :class="{ 'text-rose-500 border-b-2 border-rose-500 pb-2': activeTab === 'top_rating', 'hover:text-gray-600 pb-2': activeTab !== 'top_rating' }"
                class="transition-all duration-300"
            >
                Top Rating
            </button>

            <button
                @click="activeTab = 'best_sellers'"
                :class="{ 'text-rose-500 border-b-2 border-rose-500 pb-2': activeTab === 'best_sellers', 'hover:text-gray-600 pb-2': activeTab !== 'best_sellers' }"
                class="transition-all duration-300"
            >
                Best Sellers
            </button>
        </div>

        <a href="{{ route('shop') }}" class="hidden md:flex items-center gap-2 text-sm font-semibold text-gray-900 hover:text-rose-500 transition-colors border border-gray-300 px-4 py-2 rounded-lg hover:border-rose-500">
            All products
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
        </a>
    </div>

    <div class="relative min-h-[400px]">

        <div x-show="activeTab === 'latest'"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0"
             class="grid grid-cols-2 lg:grid-cols-4 gap-8">

             @foreach($latestProducts as $product)
                <x-furniture-card :product="$product" badge="NEW" />
             @endforeach

        </div>

        <div x-show="activeTab === 'top_rating'"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0"
             class="grid grid-cols-2 lg:grid-cols-4 gap-8"
             style="display: none;"> {{-- Hide by default --}}

             @foreach($topRatedProducts as $product)
                <x-furniture-card :product="$product" badge="HOT" />
             @endforeach

        </div>

        <div x-show="activeTab === 'best_sellers'"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0"
             class="grid grid-cols-2 lg:grid-cols-4 gap-8"
             style="display: none;"> {{-- Hide by default --}}

             @foreach($bestSellerProducts as $product)
                <x-furniture-card :product="$product" badge="BEST" />
             @endforeach

        </div>

    </div>
</section>