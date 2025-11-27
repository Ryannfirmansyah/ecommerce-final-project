<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Product Details
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Success Message -->
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                <!-- Product Image -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-96 object-cover rounded-lg">
                        @else
                            <div class="w-full h-96 bg-gray-200 rounded-lg flex items-center justify-center">
                                <svg class="w-32 h-32 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Product Info -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h1 class="text-3xl font-bold text-gray-900">{{ $product->name }}</h1>
                        
                        <!-- Category & Store -->
                        <div class="mt-2 flex items-center space-x-4">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                {{ $product->category->name }}
                            </span>
                            <span class="text-sm text-gray-600">by {{ $product->store->name }}</span>
                        </div>

                        <!-- Rating -->
                        <div class="mt-4 flex items-center">
                            <div class="flex items-center">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="w-5 h-5 {{ $i <= round($product->averageRating()) ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                @endfor
                            </div>
                            <span class="ml-2 text-sm text-gray-600">{{ number_format($product->averageRating(), 1) }} ({{ $product->totalReviews() }} reviews)</span>
                        </div>

                        <!-- Price -->
                        <div class="mt-6">
                            <span class="text-4xl font-bold text-gray-900">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                        </div>

                        <!-- Stock -->
                        <div class="mt-4">
                            @if($product->stock > 0)
                                <span class="text-sm text-green-600 font-semibold">In Stock: {{ $product->stock }} units</span>
                            @else
                                <span class="text-sm text-red-600 font-semibold">Out of Stock</span>
                            @endif
                        </div>

                        <!-- Description -->
                        <div class="mt-6">
                            <h3 class="text-lg font-semibold text-gray-900">Description</h3>
                            <p class="mt-2 text-gray-600">{{ $product->description }}</p>
                        </div>

                        <!-- Add to Cart (Only for authenticated buyer) -->
                        @auth
                            @if(auth()->user()->isBuyer() && $product->stock > 0)
                                <form method="POST" action="{{ route('buyer.cart.store', $product) }}" class="mt-6">
                                    @csrf
                                    <div class="flex items-center space-x-4">
                                        <div>
                                            <label for="quantity" class="block text-sm font-medium text-gray-700">Quantity</label>
                                            <input type="number" id="quantity" name="quantity" value="1" min="1" max="{{ $product->stock }}" class="mt-1 block w-20 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                        </div>
                                        <button type="submit" class="mt-6 inline-flex items-center px-6 py-3 bg-indigo-600 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-indigo-700">
                                            Add to Cart
                                        </button>
                                    </div>
                                </form>
                            @endif
                        @else
                            <div class="mt-6">
                                <a href="{{ route('login') }}" style="background-color: #4f46e5; color: white; padding: 12px 24px; border-radius: 6px; font-weight: 600; font-size: 14px; text-transform: uppercase; text-decoration: none; display: inline-block;">
                                    Login to Purchase
                                </a>
                            </div>
                        @endauth
                    </div>
                </div>
            </div>

            <!-- Reviews Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Customer Reviews</h3>

                    @forelse($product->reviews as $review)
                        <div class="border-b border-gray-200 py-4 last:border-b-0">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="font-semibold text-gray-900">{{ $review->user->name }}</p>
                                    <div class="flex items-center mt-1">
                                        @for($i = 1; $i <= 5; $i++)
                                            <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                        @endfor
                                    </div>
                                </div>
                                <span class="text-xs text-gray-500">{{ $review->created_at->format('d M Y') }}</span>
                            </div>
                            @if($review->comment)
                                <p class="mt-2 text-gray-600">{{ $review->comment }}</p>
                            @endif
                        </div>
                    @empty
                        <p class="text-gray-500 text-center py-4">No reviews yet. Be the first to review!</p>
                    @endforelse
                </div>
            </div>

            <!-- Related Products -->
            @if($relatedProducts->isNotEmpty())
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Related Products</h3>
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            @foreach($relatedProducts as $related)
                                <a href="{{ route('products.show', $related) }}" class="group">
                                    @if($related->image)
                                        <img src="{{ asset('storage/' . $related->image) }}" alt="{{ $related->name }}" class="w-full h-32 object-cover rounded-lg">
                                    @else
                                        <div class="w-full h-32 bg-gray-200 rounded-lg"></div>
                                    @endif
                                    <h4 class="mt-2 text-sm font-semibold text-gray-900 group-hover:text-indigo-600">{{ $related->name }}</h4>
                                    <p class="text-sm font-bold text-gray-900">Rp {{ number_format($related->price, 0, ',', '.') }}</p>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>