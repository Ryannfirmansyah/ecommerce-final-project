<div class="bg-white p-2 sm:p-4 rounded-[28px] sm:rounded-[40px] shadow-xl font-['Poppins'] border border-gray-100">

    <div class="relative w-full mb-4 group">
        <div class="overflow-hidden rounded-[20px] sm:rounded-[30px]">
            <img
                src="{{ asset('storage/products/backpack.jpg') }}"
                alt="Nike Airforce 1"
                class="w-full h-full object-cover aspect-square group-hover:scale-105 transition-transform"
            >
        </div>

        <div class="absolute top-1 sm:top-4 left-1 sm:left-4 bg-black/5 backdrop-blur-md border border-white/10 text-black shadow-sm font-medium p-2 py-1 rounded-full">
            {{  $product->category->name ?? 'Uncategorized' }}
        </div>

        @auth
        <form action="{{ route('buyer.wishlist.toggle', $product) }}" method="POST" class="absolute top-1 sm:top-4 right-1 sm:right-4">
            @csrf
            <button type="submit" class="p-2 rounded-full shadow-sm transition-all duration-200
                {{ Auth::user()->hasWishlisted($product->id)
                ? 'bg-red-50 text-red-500 hover:bg-red-100'
                : 'bg-white text-gray-400 hover:text-red-500 hover:bg-white'
                }}">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd" />
                </svg>
            </button>
        </form>
        @endauth

        <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex gap-1.5">
            <div class="w-1.5 h-1.5 bg-white rounded-full"></div>
            <div class="w-1.5 h-1.5 bg-white/50 rounded-full"></div>
            <div class="w-1.5 h-1.5 bg-white/50 rounded-full"></div>
            <div class="w-1.5 h-1.5 bg-white/50 rounded-full"></div>
        </div>
    </div>

    <div class="sm:px-2">
        <h3 class="text-xl font-bold text-black mb-1 line-clamp-1">{{ $product->name }}</h3>
        <div class="flex items-center gap-1 text-yellow-400 text-xs">★
            <span class="text-gray-800">
                ({{ number_format($product->reviews_avg_rating, 1) ?? 'No Rating' }})
            </span>
        </div>

        <p class="text-gray-500 text-xs leading-relaxed mb-6 line-clamp-2">
            {{ $product->description }}
        </p>

        <div class="bg-gray-100 text-black text-center font-bold text-md px-5 py-2 mb-4 rounded-full shadow-inner">
            {{ 'Rp' . number_format($product->price, 0, ',', '.') }}
        </div>

        <a
            href="{{ route('products.show', $product->slug) }}"
            class="bg-black w-full text-white px-3 justify-center py-2.5 rounded-full inline-flex items-center gap-2 text-xs sm:text-sm font-medium hover:bg-gray-800 transition-colors group"
        >
            Buy Now
            <svg class="w-3 h-3 group-hover:translate-x-0.5 group-hover:-translate-y-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 19L19 5M19 5H9M19 5V15"></path>
            </svg>
        </a>

    </div>

</div>