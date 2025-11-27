<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Shopping Cart
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Success/Error Messages -->
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

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Cart Items -->
                <div class="lg:col-span-2">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Cart Items ({{ $cartItems->count() }})</h3>

                            @forelse($cartItems as $item)
                                <div class="flex items-center border-b border-gray-200 py-4 last:border-b-0">
                                    <!-- Product Image -->
                                    <div class="flex-shrink-0">
                                        @if($item->product->image)
                                            <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="w-20 h-20 rounded object-cover">
                                        @else
                                            <div class="w-20 h-20 bg-gray-200 rounded"></div>
                                        @endif
                                    </div>

                                    <!-- Product Info -->
                                    <div class="flex-1 ml-4">
                                        <h4 class="font-semibold text-gray-900">{{ $item->product->name }}</h4>
                                        <p class="text-sm text-gray-600">{{ $item->product->category->name }}</p>
                                        <p class="text-sm text-gray-600">by {{ $item->product->store->name }}</p>
                                        <p class="font-bold text-gray-900 mt-1">Rp {{ number_format($item->product->price, 0, ',', '.') }}</p>
                                    </div>

                                    <!-- Quantity & Actions -->
                                    <div class="flex flex-col items-end space-y-2">
                                        <form method="POST" action="{{ route('buyer.cart.update', $item) }}" class="flex items-center space-x-2">
                                            @csrf
                                            @method('PUT')
                                            <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" max="{{ $item->product->stock }}" class="w-16 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                            <button type="submit" class="text-sm text-indigo-600 hover:text-indigo-900">Update</button>
                                        </form>

                                        <p class="font-bold text-gray-900">Rp {{ number_format($item->subtotal(), 0, ',', '.') }}</p>

                                        <form method="POST" action="{{ route('buyer.cart.destroy', $item) }}" onsubmit="return confirm('Remove this item?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-sm text-red-600 hover:text-red-900">Remove</button>
                                        </form>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-12">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900">Your cart is empty</h3>
                                    <p class="mt-1 text-sm text-gray-500">Start shopping to add items to your cart.</p>
                                    <div class="mt-6">
                                        <a href="{{ route('home') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                                            Browse Products
                                        </a>
                                    </div>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Order Summary -->
                @if($cartItems->isNotEmpty())
                    <div class="lg:col-span-1">
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg sticky top-6">
                            <div class="p-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Order Summary</h3>

                                <div class="space-y-2">
                                    <div class="flex justify-between text-gray-600">
                                        <span>Subtotal</span>
                                        <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="flex justify-between text-gray-600">
                                        <span>Shipping</span>
                                        <span>Free</span>
                                    </div>
                                    <div class="border-t border-gray-200 pt-2 mt-2">
                                        <div class="flex justify-between text-lg font-bold text-gray-900">
                                            <span>Total</span>
                                            <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-6">
                                    <a href="{{ route('buyer.checkout.index') }}" class="block w-full text-center px-4 py-3 bg-indigo-600 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-indigo-700">
                                        Proceed to Checkout
                                    </a>
                                </div>

                                <div class="mt-4">
                                    <a href="{{ route('home') }}" class="block text-center text-sm text-indigo-600 hover:text-indigo-900">
                                        Continue Shopping
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>