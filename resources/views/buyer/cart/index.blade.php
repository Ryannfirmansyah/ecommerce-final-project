<x-guest-layout>
    <div class="w-full flex justify-center bg-gray-50 min-h-screen">

        <div class="container max-w-7xl px-4 py-12">
            <h1 class="text-3xl font-bold mb-8 font-sans">Shopping Cart</h1>

            <div class="flex flex-col lg:flex-row gap-8">

                @if($groupedCarts->isNotEmpty())
                <div class="w-full lg:w-2/3 space-y-6">

                    @foreach($groupedCarts as $storeId => $items)
                        @include('components.grouped-cart', ['items' => $items])
                    @endforeach

                </div>

                <form action="{{ route('buyer.cart.checkout') }}" method="POST" class="w-full lg:w-1/3">
                    @csrf

                    <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm sticky top-24">
                        <h2 class="text-lg font-bold mb-6">Order Summary</h2>

                        <div class="mb-6">
                            <label for="shipping_address" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">
                                Shipping Address
                            </label>
                            <textarea
                                name="shipping_address"
                                id="shipping_address"
                                rows="4"
                                class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-black focus:ring-1 focus:ring-black transition-colors resize-none bg-gray-50 focus:bg-white"
                                placeholder="Enter your full street address, city, and postal code..."
                                required
                            >{{ old('shipping_address') }}</textarea>
                            @error('shipping_address')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-3 text-sm text-gray-600 mb-6">
                            <div class="flex justify-between">
                                <span>Subtotal ({{ $cartItems->sum('quantity') }} items)</span>
                                <span class="font-bold text-gray-900">Rp {{ number_format($grandTotal, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Shipping Fee</span>
                                <span class="text-green-600 font-medium text-xs bg-green-50 px-2 py-1 rounded">Free Shipping</span>
                            </div>
                        </div>

                        <hr class="border-dashed border-gray-200 my-4">

                        <div class="flex justify-between items-center mb-6">
                            <span class="font-bold text-gray-900 text-lg">Total Payment</span>
                            <span class="text-2xl font-bold text-gray-900">Rp {{ number_format($grandTotal, 0, ',', '.') }}</span>
                        </div>

                        <button type="submit" class="w-full bg-black text-white py-4 rounded-xl font-bold hover:bg-gray-800 transition-all text-center shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 flex justify-center items-center gap-2 group">
                            <span>Place Order</span>
                            <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </button>

                        <div class="mt-6 flex items-start gap-3 bg-gray-50 p-4 rounded-xl border border-gray-100">
                            <svg class="w-5 h-5 text-gray-400 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p class="text-xs text-gray-500 leading-relaxed">
                                <strong>Secure Checkout.</strong> Your order will be processed immediately after confirmation.
                            </p>
                        </div>
                    </div>
                </form>

                @else

                <div class="w-full">
                    <div class="flex flex-col items-center justify-center py-16 px-4 sm:px-6 lg:px-8 text-center bg-white rounded-3xl border border-dashed border-gray-300 min-h-[500px]">

                        <div class="relative mb-6 group">
                            <div class="w-32 h-32 bg-gray-50 rounded-full flex items-center justify-center mb-4 transition-transform duration-500 group-hover:scale-110">
                                <svg class="w-16 h-16 text-gray-300 transition-colors duration-300 group-hover:text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                </svg>
                            </div>

                            <div class="absolute top-0 right-0 -mr-2 -mt-2 w-4 h-4 bg-yellow-400 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-700 delay-100 animate-bounce"></div>
                            <div class="absolute bottom-0 left-0 -ml-2 -mb-2 w-3 h-3 bg-black rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-700 delay-200 animate-pulse"></div>
                        </div>

                        <h3 class="text-2xl sm:text-3xl font-serif font-bold text-gray-900 mb-3">
                            Your Cart is Empty
                        </h3>
                        <p class="text-gray-500 max-w-md mx-auto mb-8 leading-relaxed">
                            Looks like you haven't made your choice yet. Explore our collection to find the furniture & electronics you love.
                        </p>

                        <a href="{{ route('home') }}" class="inline-flex items-center gap-2 px-8 py-4 bg-black text-white rounded-full font-bold text-sm hover:bg-gray-800 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            <span>Start Shopping</span>
                        </a>

                    </div>
                </div>

                @endif

            </div>
        </div>
    </div>
</x-seller-layout>