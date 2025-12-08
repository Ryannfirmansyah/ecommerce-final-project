<x-guest-layout>
    <div class="bg-white min-h-screen font-['Poppins'] pb-20">

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <nav class="flex text-sm text-gray-500">
                <a href="{{ route('home') }}" class="hover:text-black transition-colors">Home</a>
                <span class="mx-2">/</span>
                <a href="{{ route('shop') }}" class="hover:text-black transition-colors">Shop</a>
                <span class="mx-2">/</span>
                <span class="text-black font-medium truncate">{{ $product->name }}</span>
            </nav>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16">

                <div class="space-y-4">
                    <div class="aspect-square bg-gray-100 rounded-3xl overflow-hidden relative group">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-300">
                                <svg class="w-24 h-24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                        @endif

                        <div class="absolute top-4 left-4">
                            <span class="bg-white/90 backdrop-blur-md text-black text-xs font-bold px-3 py-1.5 rounded-full uppercase tracking-wider shadow-sm">
                                {{ $product->category->name }}
                            </span>
                        </div>

                        @auth
                            <form action="{{ route('buyer.wishlist.toggle', $product) }}" method="POST" class="absolute top-4 right-4">
                                @csrf
                                <button type="submit" class="p-2 rounded-full shadow-sm transition-all duration-200
                                    {{ Auth::user()->hasWishlisted($product->id)
                                    ? 'bg-red-50 text-red-500 hover:bg-red-100'
                                    : 'bg-white text-gray-400 hover:text-red-500 hover:bg-white'
                                    }}">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </form>
                        @endauth
                    </div>
                </div>

                <div class="lg:sticky lg:top-24 h-fit">

                    <div class="mb-6 border-b border-gray-100 pb-6">
                        <h1 class="text-3xl sm:text-4xl font-serif font-bold text-gray-900 mb-2">{{ $product->name }}</h1>

                        <div class="flex items-center justify-between mt-4">
                            <p class="text-2xl sm:text-3xl font-bold text-gray-900">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </p>

                            <div class="flex items-center gap-1 bg-gray-50 px-3 py-1.5 rounded-lg">
                                <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" /></svg>
                                <span class="text-sm font-semibold text-gray-900">{{ number_format($product->averageRating(), 1) }}</span>
                                <span class="text-xs text-gray-500">({{ $product->totalReviews() }} reviews)</span>
                            </div>
                        </div>
                    </div>

                    <div class="mb-8">
                        <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-3">Description</h3>
                        <div class="prose prose-sm text-gray-600 leading-relaxed">
                            {{ $product->description }}
                        </div>
                    </div>

                    <div class="flex items-center gap-4 mb-8 p-4 bg-gray-50 rounded-2xl border border-gray-100">
                        <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center text-lg font-bold border border-gray-200 shadow-sm">
                            {{ substr($product->store->name ?? 'S', 0, 1) }}
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wider">Sold by</p>
                            <p class="font-bold text-gray-900">{{ $product->store->name ?? 'Official Store' }}</p>
                        </div>
                    </div>

                    <div class="mb-8">
                        @auth
                            @if(auth()->user()->isBuyer())
                                @if($product->stock > 0)
                                    <form method="POST" action="{{ route('buyer.cart.store', $product) }}">
                                        @csrf
                                        <div class="flex items-center gap-4">
                                            <div x-data="{ quantity: 1, maxStock: {{ $product->stock }} }" class="flex items-center border border-gray-300 rounded-xl">

                                                <button type="button"
                                                        @click="if(quantity > 1) quantity--"
                                                        class="px-3 py-2 text-gray-600 hover:bg-gray-100 rounded-l-xl text-2xl font-extrabold transition">
                                                    -
                                                </button>

                                                <input type="number"
                                                    id="quantity"
                                                    name="quantity"
                                                    x-model="quantity"
                                                    min="1"
                                                    :max="maxStock"
                                                    class="w-12 text-center border-none focus:ring-0 p-0 text-gray-900 font-semibold bg-transparent appearance-none [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none"
                                                    oninput="if(this.value > {{ $product->stock }}) this.value = {{ $product->stock }};"
                                                >

                                                <button type="button"
                                                        @click="if(quantity < maxStock) quantity++"
                                                        class="px-3 py-2 text-gray-600 hover:bg-gray-100 text-2xl font-extrabold rounded-r-xl transition">
                                                    +
                                                </button>

                                            </div>

                                            <button type="submit" class="flex-1 w-full bg-black text-white font-bold py-3.5 px-6 rounded-xl hover:bg-gray-800 transition shadow-lg hover:shadow-xl transform active:scale-95 flex justify-center items-center gap-2">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                                                Add to Cart
                                            </button>
                                        </div>
                                        <p class="text-xs text-green-600 font-medium mt-3 flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                            In Stock ({{ $product->stock }} units available)
                                        </p>
                                    </form>
                                @else
                                    <button disabled class="w-full bg-gray-200 text-gray-400 font-bold py-3.5 px-6 rounded-xl cursor-not-allowed">
                                        Out of Stock
                                    </button>
                                @endif
                            @else
                                <div class="p-4 bg-yellow-50 text-yellow-800 rounded-xl text-sm border border-yellow-100">
                                    Only buyers can purchase items.
                                </div>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="block w-full text-center bg-black text-white font-bold py-3.5 px-6 rounded-xl hover:bg-gray-800 transition shadow-lg">
                                Add to Cart
                            </a>
                        @endauth
                    </div>

                    <div class="border-t border-gray-100 pt-8" x-data="{ showReviews: false }">
                        <button @click="showReviews = !showReviews" class="flex items-center justify-between w-full group">
                            <h3 class="text-lg font-bold text-gray-900">Reviews ({{ $product->totalReviews() }})</h3>
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-black transition-transform duration-200" :class="{'rotate-180': showReviews}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>

                        <div x-show="showReviews" x-collapse class="mt-6 space-y-6">
                            @forelse($product->reviews as $review)
                                <div class="pb-6 border-b border-gray-50 last:border-0 last:pb-0">
                                    <div class="flex justify-between items-start mb-2">
                                        <div>
                                            <p class="font-bold text-sm text-gray-900">{{ $review->user->name }}</p>
                                            <div class="flex text-yellow-400 text-xs mt-1">
                                                @for($i=1; $i<=5; $i++)
                                                    @if($i <= $review->rating) ★ @else <span class="text-gray-200">★</span> @endif
                                                @endfor
                                            </div>
                                        </div>
                                        <span class="text-xs text-gray-400">{{ $review->created_at->format('M d, Y') }}</span>
                                    </div>
                                    <p class="text-sm text-gray-600 leading-relaxed">{{ $review->comment }}</p>
                                </div>
                            @empty
                                <p class="text-sm text-gray-500 italic">No reviews yet.</p>
                            @endforelse
                        </div>
                    </div>

                </div>
            </div>

            @if($relatedProducts->isNotEmpty())
            <div class="mt-20 border-t border-gray-200 pt-16">
                <h2 class="text-2xl font-bold text-gray-900 mb-8">You might also like</h2>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6 lg:gap-8">
                    @foreach($relatedProducts as $related)
                        <x-product-card :product="$related" />
                    @endforeach
                </div>
            </div>
            @endif

        </div>
    </div>

    <script>
        function increment() {
            let input = document.getElementById('quantity');
            let max = parseInt(input.getAttribute('max'));
            if(parseInt(input.value) < max) input.value = parseInt(input.value) + 1;
        }
        function decrement() {
            let input = document.getElementById('quantity');
            if(parseInt(input.value) > 1) input.value = parseInt(input.value) - 1;
        }
    </script>
</x-guest-layout>