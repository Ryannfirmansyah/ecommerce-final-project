<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Checkout
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Checkout Form -->
                <div class="lg:col-span-2">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Shipping Information</h3>

                            <form method="POST" action="{{ route('buyer.checkout.process') }}">
                                @csrf

                                <!-- Shipping Address -->
                                <div>
                                    <x-input-label for="shipping_address" :value="__('Shipping Address')" />
                                    <textarea id="shipping_address" name="shipping_address" rows="4" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" placeholder="Enter your complete address...">{{ old('shipping_address') }}</textarea>
                                    <x-input-error :messages="$errors->get('shipping_address')" class="mt-2" />
                                </div>

                                <!-- Order Items Review -->
                                <div class="mt-6">
                                    <h4 class="text-md font-semibold text-gray-900 mb-3">Order Items</h4>
                                    <div class="space-y-3">
                                        @foreach($cartItems as $item)
                                            <div class="flex items-center justify-between py-2 border-b border-gray-200">
                                                <div class="flex items-center">
                                                    @if($item->product->image)
                                                        <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="w-12 h-12 rounded object-cover">
                                                    @else
                                                        <div class="w-12 h-12 bg-gray-200 rounded"></div>
                                                    @endif
                                                    <div class="ml-3">
                                                        <p class="text-sm font-semibold text-gray-900">{{ $item->product->name }}</p>
                                                        <p class="text-xs text-gray-600">Qty: {{ $item->quantity }}</p>
                                                    </div>
                                                </div>
                                                <p class="text-sm font-semibold text-gray-900">Rp {{ number_format($item->subtotal(), 0, ',', '.') }}</p>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="mt-6 flex justify-between items-center">
                                    <a href="{{ route('buyer.cart.index') }}" class="text-sm text-gray-600 hover:text-gray-900">← Back to Cart</a>
                                    <button type="submit" class="inline-flex items-center px-6 py-3 bg-indigo-600 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-indigo-700">
                                        Place Order
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg sticky top-6">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Order Summary</h3>

                            <div class="space-y-2">
                                <div class="flex justify-between text-gray-600">
                                    <span>Subtotal ({{ $cartItems->count() }} items)</span>
                                    <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between text-gray-600">
                                    <span>Shipping Fee</span>
                                    <span>Free</span>
                                </div>
                                <div class="border-t border-gray-200 pt-2 mt-2">
                                    <div class="flex justify-between text-xl font-bold text-gray-900">
                                        <span>Total</span>
                                        <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>