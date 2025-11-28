<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Order Details
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Success Message -->
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Order Info -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6 hover:shadow-md transition-shadow duration-200">
                <div class="p-6">
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Order #{{ $order->order_number }}</h3>
                            <p class="text-sm text-gray-600 mt-1">Placed on {{ $order->created_at->format('d M Y, H:i') }}</p>
                        </div>
                        <div class="flex items-center justify-center">
                            <span class="px-4 py-2 inline-flex items-center justify-center text-sm leading-5 font-semibold rounded-full
                                @if($order->status === 'completed') bg-green-100 text-green-800
                                @elseif($order->status === 'processing') bg-blue-100 text-blue-800
                                @elseif($order->status === 'cancelled') bg-red-100 text-red-800
                                @else bg-yellow-100 text-yellow-800
                                @endif">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Customer Info -->
                        <div>
                            <h4 class="text-sm font-semibold text-gray-900 mb-2">Customer Information</h4>
                            <div class="text-sm text-gray-600 space-y-1">
                                <p><strong>Name:</strong> {{ $order->user->name }}</p>
                                <p><strong>Email:</strong> {{ $order->user->email }}</p>
                            </div>
                        </div>

                        <!-- Shipping Address -->
                        <div>
                            <h4 class="text-sm font-semibold text-gray-900 mb-2">Shipping Address</h4>
                            <div class="text-sm text-gray-600">
                                <p>{{ $order->shipping_address ?? 'No address provided' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Items -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition-shadow duration-200">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Order Items</h3>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Store</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subtotal</th>
                                    @if($order->status === 'completed')
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Review</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($order->orderItems as $item)
                                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center">
                                                @if($item->product->image)
                                                    <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="w-16 h-16 rounded-lg object-cover mr-3 shadow-sm flex-shrink-0">
                                                @else
                                                    <div class="w-16 h-16 bg-gray-200 rounded-lg mr-3 flex-shrink-0"></div>
                                                @endif
                                                <div>
                                                    <div class="text-sm font-medium text-gray-900">{{ $item->product->name }}</div>
                                                    <div class="text-xs text-gray-500 mt-1">{{ $item->product->category->name }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $item->product->store->name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            Rp {{ number_format($item->price, 0, ',', '.') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $item->quantity }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                            Rp {{ number_format($item->subtotal(), 0, ',', '.') }}
                                        </td>
                                        @if($order->status === 'completed')
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                @php
                                                    $hasReview = $order->reviews()->where('product_id', $item->product_id)->exists();
                                                @endphp
                                                
                                                @if($hasReview)
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                                        </svg>
                                                        Reviewed
                                                    </span>
                                                @else
                                                    <a href="{{ route('buyer.orders.review-form', [$order, $item->product_id]) }}" class="inline-flex items-center px-3 py-1 border border-indigo-600 rounded-full text-xs font-medium text-indigo-600 hover:bg-indigo-600 hover:text-white transition-colors duration-150">
                                                        Add Review
                                                    </a>
                                                @endif
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Total -->
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <div class="flex justify-end">
                            <div class="text-right">
                                <p class="text-sm text-gray-600 mb-1">Total Order</p>
                                <p class="text-2xl font-bold text-gray-900">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end">
                        <a href="{{ route('buyer.orders.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 active:bg-gray-500 transition-colors duration-150">
                            Back to Orders
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>