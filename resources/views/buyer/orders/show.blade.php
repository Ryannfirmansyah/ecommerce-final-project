@php
    $badges = [
        'pending' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
        'processing' => 'bg-blue-100 text-blue-800 border-blue-200',
        'completed' => 'bg-green-100 text-green-800 border-green-200',
        'cancelled' => 'bg-red-100 text-red-800 border-red-200',
    ];
@endphp

<x-guest-layout>
    <div class="bg-gray-50 min-h-screen pb-20 font-['Poppins']">

        <div class="bg-white border-b border-gray-200 sticky top-0 z-30 shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <div class="flex items-center gap-2 text-sm text-gray-500">
                    <a href="{{ route('home') }}" class="hover:text-black">Home</a>
                    <span>/</span>
                    <a href="{{ route('buyer.orders.index') }}" class="hover:text-black">My Orders</a>
                    <span>/</span>
                    <span class="text-black font-semibold">#{{ $order->order_number }}</span>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
                <div>
                    <h1 class="text-3xl font-serif font-bold text-gray-900">Order Details</h1>
                    <p class="text-gray-500 mt-1">Placed on {{ $order->created_at->format('d F Y, H:i') }}</p>
                </div>

                <div class="px-6 py-2 rounded-full border {{ $badges[$order->status] ?? 'bg-gray-100 text-gray-800' }}">
                    <span class="text-sm font-bold uppercase tracking-wide">{{ ucfirst($order->status) }}</span>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <div class="lg:col-span-2 space-y-6">

                    <div class="bg-white rounded-3xl border border-gray-200 shadow-sm overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                            <h3 class="font-bold text-gray-900">Items Ordered</h3>
                        </div>

                        <div class="divide-y divide-gray-100">
                            @foreach($order->orderItems as $item)
                                <div class="p-6 flex flex-col sm:flex-row gap-6">
                                    <div class="w-24 h-24 sm:w-28 sm:h-28 bg-gray-100 rounded-2xl overflow-hidden shrink-0 border border-gray-200">
                                        @if($item->product && $item->product->image)
                                            <img src="{{ asset('storage/' . $item->product->image) }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-gray-400">
                                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="flex-1 flex flex-col justify-between">
                                        <div>
                                            <div class="flex justify-between items-start">
                                                <div>
                                                    <h4 class="font-bold text-lg text-gray-900 line-clamp-1">
                                                        <a href="{{ route('products.show', $item->product_id) }}" class="hover:underline">
                                                            {{ $item->product->name ?? 'Product Deleted' }}
                                                        </a>
                                                    </h4>
                                                    <div class="flex items-center gap-2 mt-1 text-sm text-gray-500">
                                                        <span>Store: {{ $item->product->store->name ?? 'Unknown Store' }}</span>
                                                    </div>
                                                </div>
                                                <p class="font-bold text-lg text-gray-900">
                                                    Rp {{ number_format($item->subtotal(), 0, ',', '.') }}
                                                </p>
                                            </div>

                                            <div class="mt-2 text-sm text-gray-600">
                                                {{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }} |
                                                <div class="px-2 pb-1 inline w-fit rounded-full border {{ $badges[$item->status] ?? 'bg-gray-100 text-gray-800' }}">
                                                    <span class="text-sm font-thin lowercase tracking-wide">{{ ucfirst($item->status) }}</span>
                                                </div>
                                            </div>

                                        </div>

                                        @if($order->status === 'completed')
                                            <div class="mt-4 pt-4 border-t border-gray-100 flex justify-end">

                                                {{-- Pengecekan Bersih: Cukup cek apakah relasi 'userReview' tidak null --}}
                                                @if($item->userReview)
                                                    <span class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-bold bg-green-100 text-green-700">
                                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                                        Review Submitted
                                                    </span>
                                                @else
                                                    <a href="{{ route('buyer.orders.review-form', [$order->id, $item->product_id]) }}" class="inline-flex items-center gap-2 px-4 py-2 border border-black rounded-xl text-xs font-bold text-black hover:bg-black hover:text-white transition-all">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                                                        Write a Review
                                                    </a>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="lg:hidden">
                        <a href="{{ route('buyer.orders.index') }}" class="block w-full py-3 bg-white border border-gray-300 text-center rounded-xl font-bold text-gray-700 hover:bg-gray-50">
                            &larr; Back to My Orders
                        </a>
                    </div>

                </div>

                <div class="space-y-6">

                    <div class="bg-white rounded-3xl border border-gray-200 shadow-sm p-6">
                        <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            Shipping Details
                        </h3>
                        <div class="space-y-3">
                            <div>
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Recipient</p>
                                <p class="text-sm font-medium text-gray-900">{{ $order->user->name }}</p>
                                <p class="text-xs text-gray-500">{{ $order->user->email }}</p>
                            </div>
                            <hr class="border-gray-100">
                            <div>
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Delivery Address</p>
                                <p class="text-sm text-gray-600 leading-relaxed">
                                    {{ $order->shipping_address ?? 'Address not provided' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-3xl border border-gray-200 shadow-sm p-6 sticky top-24">
                        <h3 class="font-bold text-gray-900 mb-4">Payment Summary</h3>

                        <div class="space-y-3 text-sm text-gray-600">
                            <div class="flex justify-between">
                                <span>Subtotal</span>
                                <span>Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Shipping Fee</span>
                                <span class="text-green-600 font-medium">Free</span>
                            </div>
                        </div>

                        <hr class="border-dashed border-gray-200 my-4">

                        <div class="flex justify-between items-center mb-6">
                            <span class="font-bold text-gray-900 text-lg">Total Paid</span>
                            <span class="font-bold text-gray-900 text-xl">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                        </div>

                        <a href="{{ route('buyer.orders.index') }}" class="hidden lg:block w-full py-3 bg-black text-white text-center rounded-xl font-bold hover:bg-gray-800 transition shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                            Back to My Orders
                        </a>
                    </div>

                </div>

            </div>
        </div>
    </div>
</x-guest-layout>