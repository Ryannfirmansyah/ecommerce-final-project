<x-guest-layout>
    <div class="bg-gray-50 min-h-screen pb-20 font-['Poppins']">

        <div class="bg-white border-b border-gray-200 z-20 shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">My Wishlist</h1>
                    <p class="text-sm text-gray-500 mt-1">Saved items you want to buy later.</p>
                </div>
                <span class="bg-red-50 text-red-600 text-xs font-bold px-3 py-1 rounded-full border border-red-100">
                    {{ $wishlists->total() }} Items
                </span>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

            @if($wishlists->count() > 0)
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @foreach($wishlists as $item)
                        <div class="group bg-white rounded-2xl border border-gray-200 shadow-sm hover:shadow-md transition-all duration-300 overflow-hidden flex flex-col relative">

                            <form action="{{ route('buyer.wishlist.destroy', $item) }}" method="POST" class="absolute top-3 right-3 z-10">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 bg-white/80 backdrop-blur-sm rounded-full text-gray-400 hover:text-red-500 hover:bg-red-50 transition shadow-sm" title="Remove">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                </button>
                            </form>

                            <a href="{{ route('products.show', $item->product) }}" class="relative aspect-square bg-gray-100 overflow-hidden block">
                                @if($item->product->image)
                                    <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-300">
                                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    </div>
                                @endif

                                @if($item->product->stock <= 0)
                                    <div class="absolute inset-0 bg-white/60 backdrop-blur-[1px] flex items-center justify-center">
                                        <span class="bg-black text-white text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider">Out of Stock</span>
                                    </div>
                                @endif
                            </a>

                            <div class="p-4 flex-1 flex flex-col">
                                <div class="mb-3">
                                    <p class="text-xs text-gray-500 mb-1">{{ $item->product->category->name ?? 'General' }}</p>
                                    <h3 class="font-bold text-gray-900 text-sm sm:text-base leading-tight line-clamp-2">
                                        <a href="{{ route('products.show', $item->product) }}" class="hover:underline">
                                            {{ $item->product->name }}
                                        </a>
                                    </h3>
                                    <p class="mt-2 font-bold text-gray-900">
                                        Rp {{ number_format($item->product->price, 0, ',', '.') }}
                                    </p>
                                </div>

                                <div class="mt-auto">
                                    @if($item->product->stock > 0)
                                        <form action="{{ route('buyer.cart.store', $item->product) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="quantity" value="1">
                                            <button type="submit" class="w-full py-2.5 bg-black text-white text-xs sm:text-sm font-bold rounded-xl hover:bg-gray-800 transition flex items-center justify-center gap-2 shadow-sm hover:shadow-md transform hover:-translate-y-0.5">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                                                Add to Cart
                                            </button>
                                        </form>
                                    @else
                                        <button disabled class="w-full py-2.5 bg-gray-100 text-gray-400 text-xs sm:text-sm font-bold rounded-xl cursor-not-allowed border border-gray-200">
                                            Unavailable
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-8">
                    {{ $wishlists->links('vendor.pagination.custom') }}
                </div>
            @else
                <div class="flex flex-col items-center justify-center py-20 text-center bg-white rounded-3xl border border-dashed border-gray-300 min-h-[400px]">
                    <div class="relative mb-6 group">
                        <div class="w-24 h-24 bg-red-50 rounded-full flex items-center justify-center mb-4 transition-transform duration-500 group-hover:scale-110">
                            <svg class="w-12 h-12 text-red-300 transition-colors duration-300 group-hover:text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                            </svg>
                        </div>
                    </div>

                    <h3 class="text-xl sm:text-2xl font-bold text-gray-900 mb-2">Your wishlist is empty</h3>
                    <p class="text-gray-500 max-w-sm mx-auto mb-8">
                        Save items you love here. Just click on the heart icon while browsing the shop.
                    </p>

                    <a href="{{ route('shop') }}" class="inline-flex items-center gap-2 px-8 py-3 bg-black text-white rounded-full font-bold text-sm hover:bg-gray-800 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                        <span>Browse Products</span>
                    </a>
                </div>
            @endif

        </div>
    </div>
</x-guest-layout>