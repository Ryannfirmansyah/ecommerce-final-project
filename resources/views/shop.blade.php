<x-guest-layout>
    <main class="max-w-7xl w-full mx-auto px-4 sm:px-6 pb-20 font-['Poppins'] flex flex-col lg:flex-row lg:gap-10 pt-8" x-data="{ mobileFiltersOpen: false }">

        <div class="lg:w-1/4 shrink-0">

            <button @click="mobileFiltersOpen = !mobileFiltersOpen"
                    class="lg:hidden w-full flex items-center justify-between px-4 py-3 bg-white border border-gray-200 rounded-xl shadow-sm mb-6 text-sm font-bold text-gray-900 hover:bg-gray-50 transition">
                <span class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                    Filters & Sort
                </span>
                <svg class="w-5 h-5 text-gray-400 transition-transform duration-200" :class="{'rotate-180': mobileFiltersOpen}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
            </button>

            <aside class="lg:block transition-all duration-300 ease-in-out mb-8"
                :class="mobileFiltersOpen ? 'block' : 'hidden'">

                <div class="flex justify-between items-center mb-4 lg:mb-6">
                    <h2 class="font-bold text-lg hidden lg:block">Filters</h2>
                    @if(request()->anyFilled(['search', 'category', 'sort']))
                        <a href="{{ route('shop') }}" class="text-xs font-semibold text-red-500 hover:text-red-700 underline decoration-red-500/30">
                            Clear All
                        </a>
                    @endif
                </div>

                <div class="mb-3">
                    <h3 class="font-bold text-xs text-gray-400 uppercase tracking-wider mb-3">Sort By</h3>
                    <form action="{{ route('shop') }}" method="GET" id="filterForm" class="mb-2">
                        @if(request('category')) <input type="hidden" name="category" value="{{ request('category') }}"> @endif
                        @if(request('search')) <input type="hidden" name="search" value="{{ request('search') }}"> @endif

                        <div class="space-y-2">
                            <label class="cursor-pointer block">
                                <input type="radio" name="sort" value="newest" onchange="this.form.submit()" {{ request('sort', 'newest') == 'newest' ? 'checked' : '' }} class="peer sr-only" />
                                <div class="px-4 py-2.5 rounded-xl border bg-white text-sm font-medium text-gray-500 transition-all hover:border-gray-300 peer-checked:bg-black peer-checked:text-white peer-checked:border-black peer-checked:shadow-md flex justify-between items-center">
                                    <span>Newest Arrival</span>
                                    @if(request('sort', 'newest') == 'newest') <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> @endif
                                </div>
                            </label>

                            <label class="cursor-pointer block">
                                <input type="radio" name="sort" value="price_high" onchange="this.form.submit()" {{ request('sort') == 'price_high' ? 'checked' : '' }} class="peer sr-only" />
                                <div class="px-4 py-2.5 rounded-xl border bg-white text-sm font-medium text-gray-500 transition-all hover:border-gray-300 peer-checked:bg-black peer-checked:text-white peer-checked:border-black peer-checked:shadow-md flex justify-between items-center">
                                    <span>Price: High to Low</span>
                                    @if(request('sort') == 'price_high') <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> @endif
                                </div>
                            </label>

                            <label class="cursor-pointer block">
                                <input type="radio" name="sort" value="price_low" onchange="this.form.submit()" {{ request('sort') == 'price_low' ? 'checked' : '' }} class="peer sr-only" />
                                <div class="px-4 py-2.5 rounded-xl border bg-white text-sm font-medium text-gray-500 transition-all hover:border-gray-300 peer-checked:bg-black peer-checked:text-white peer-checked:border-black peer-checked:shadow-md flex justify-between items-center">
                                    <span>Price: Low to High</span>
                                    @if(request('sort') == 'price_low') <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> @endif
                                </div>
                            </label>
                        </div>
                    </form>
                </div>

                <div class="mb-3">
                    <h3 class="font-bold text-xs text-gray-400 uppercase tracking-wider mb-3">Categories</h3>
                    <div class="space-y-1">
                        <a href="{{ route('shop', request()->except('category', 'page')) }}"
                        class="flex items-center justify-between px-4 py-3 rounded-2xl text-sm font-medium transition group {{ !request('category')? 'bg-black text-white shadow-lg' : 'bg-white text-gray-500 hover:bg-gray-50' }}"
                        class="flex items-center justify-between px-3 py-2 rounded-lg text-sm font-medium transition {{ !request('category') ? 'text-black bg-gray-100' : 'text-gray-500 hover:text-black hover:bg-gray-50' }}"
                        >
                            <span>All Products</span>
                        </a>

                        @foreach($categories as $category)
                            <a href="{{ route('shop', array_merge(['category' => $category->slug], request()->except('category', 'page'))) }}"
                            class="flex items-center justify-between px-4 py-3 rounded-2xl text-sm font-medium transition group {{ request('category') == $category->slug ? 'bg-black text-white shadow-lg' : 'bg-white text-gray-500 hover:bg-gray-50' }}">
                                <div class="flex items-center gap-3">
                                    <span class="w-6 h-6 rounded-lg flex items-center justify-center text-xs font-bold {{ request('category') == $category->slug ? 'bg-gray-800' : 'bg-gray-100 text-gray-400 group-hover:text-black' }}">
                                        {{ substr($category->name, 0, 1) }}
                                    </span>
                                    {{ $category->name }}
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>

            </aside>
        </div>

        <div class="w-full lg:w-3/4 shrink-0">

            @if(request('search'))
                <div class="mb-6 flex items-center gap-2 text-sm text-gray-500">
                    <span>Search results for:</span>
                    <span class="font-bold text-black">"{{ request('search') }}"</span>
                    <span class="bg-gray-100 text-xs px-2 py-0.5 rounded-full">{{ $products->total() }} items</span>
                </div>
            @endif

            @if($products->count() > 0)
                <div class="grid grid-cols-2 md:grid-cols-3 gap-x-4 gap-y-8 md:gap-6 lg:gap-8">
                    @foreach($products as $product)
                        <x-product-card :product="$product" />
                    @endforeach
                </div>

                @if($products->hasPages())
                    <div class="mt-12">
                        {{ $products->links('vendor.pagination.custom') }}
                    </div>
                @endif
            @else
                <div class="flex flex-col items-center justify-center py-20 text-center bg-gray-50 rounded-3xl border border-dashed border-gray-200">
                    <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center shadow-sm mb-4">
                        <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>

                    <h3 class="text-lg font-bold text-gray-900 mb-1">No products found</h3>
                    <p class="text-sm text-gray-500 max-w-xs mx-auto mb-6">
                        We couldn't find what you're looking for. Try adjusting your search or filters.
                    </p>

                    <a href="{{ route('shop') }}" class="px-6 py-2.5 bg-black text-white text-sm font-bold rounded-full hover:bg-gray-800 transition shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                        Clear All Filters
                    </a>
                </div>
            @endif
        </div>

    </main>
</x-guest-layout>