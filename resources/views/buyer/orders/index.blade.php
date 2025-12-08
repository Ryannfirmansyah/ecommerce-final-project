<x-guest-layout>
    <div class="bg-gray-50 min-h-screen pb-20 font-['Poppins']">

        <div class="bg-white border-b border-gray-20 z-20 shadow-sm">
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <h1 class="text-2xl font-bold text-gray-900">My Orders</h1>
                <p class="text-sm text-gray-500 mt-1">Track your order history and status.</p>
            </div>
        </div>

        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

            <div class="mb-8 overflow-x-auto pb-2 -mx-4 px-4 sm:mx-0 sm:px-0">
                <div class="flex items-center gap-2 min-w-max">
                    @php
                        $currentStatus = request('status');
                        $statuses = [
                            '' => 'All Orders',
                            'pending' => 'Pending',
                            'processing' => 'Processing',
                            'completed' => 'Completed',
                            'cancelled' => 'Cancelled'
                        ];
                    @endphp

                    @foreach($statuses as $key => $label)
                        <a href="{{ route('buyer.orders.index', ['status' => $key]) }}"
                           class="px-5 py-2.5 rounded-full text-sm font-semibold transition-all border
                           {{ $currentStatus == $key
                               ? 'bg-black text-white border-black shadow-md'
                               : 'bg-white text-gray-600 border-gray-200 hover:bg-gray-50 hover:border-gray-300'
                           }}">
                            {{ $label }}
                        </a>
                    @endforeach
                </div>
            </div>

            <div class="space-y-6">
                @forelse($orders as $order)
                    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden hover:shadow-md transition-shadow">

                        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50 flex flex-wrap justify-between items-center gap-4">
                            <div class="flex items-center gap-4 text-sm">
                                <div>
                                    <p class="text-gray-500 text-xs uppercase tracking-wider font-bold">Order Placed</p>
                                    <p class="font-medium text-gray-900">{{ $order->created_at->format('d F Y') }}</p>
                                </div>
                                <div class="hidden sm:block w-px h-8 bg-gray-300"></div>
                                <div>
                                    <p class="text-gray-500 text-xs uppercase tracking-wider font-bold">Order ID</p>
                                    <p class="font-medium text-gray-900">#{{ $order->order_number }}</p>
                                </div>
                            </div>

                            <div>
                                @php
                                    $badges = [
                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                        'processing' => 'bg-blue-100 text-blue-800',
                                        'completed' => 'bg-green-100 text-green-800',
                                        'cancelled' => 'bg-red-100 text-red-800',
                                    ];
                                @endphp
                                <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wide {{ $badges[$order->status] ?? 'bg-gray-100 text-gray-800' }}">
                                    {{ $order->status }}
                                </span>
                            </div>
                        </div>

                        <div class="p-6">
                            <div class="flex flex-col md:flex-row gap-6 items-start md:items-center">

                                <div class="flex-1 w-full space-y-4">
                                    @foreach($order->orderItems->take(2) as $item)
                                        <div class="flex items-start gap-4">
                                            <div class="w-16 h-16 bg-gray-100 rounded-lg overflow-hidden border border-gray-200 shrink-0">
                                                @if($item->product->image)
                                                    <img src="{{ asset('storage/' . $item->product->image) }}" class="w-full h-full object-cover">
                                                @else
                                                    <div class="w-full h-full flex items-center justify-center text-gray-400">
                                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                                    </div>
                                                @endif
                                            </div>

                                            <div>
                                                <h4 class="font-bold text-sm text-gray-900 line-clamp-1">{{ $item->product->name }}</h4>
                                                <p class="text-xs text-gray-500 mt-1">Qty: {{ $item->quantity }}</p>
                                                <p class="text-sm font-semibold mt-1">Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                            </div>
                                        </div>
                                    @endforeach

                                    {{-- Jika item lebih dari 2 --}}
                                    @if($order->orderItems->count() > 2)
                                        <p class="text-xs text-gray-500 pl-2">
                                            + {{ $order->orderItems->count() - 2 }} other products
                                        </p>
                                    @endif
                                </div>

                                <div class="w-full md:w-auto md:text-right border-t md:border-t-0 md:border-l border-gray-100 pt-4 md:pt-0 md:pl-6 shrink-0 flex flex-row md:flex-col justify-between items-center md:items-end">
                                    <div class="mb-0 md:mb-4">
                                        <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Total Amount</p>
                                        <p class="text-xl font-bold text-gray-900">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                                    </div>

                                    <a href="{{ route('buyer.orders.show', $order) }}" class="px-6 py-2.5 bg-white border border-gray-300 text-gray-700 font-semibold rounded-xl text-sm hover:bg-black hover:text-white hover:border-black transition-colors shadow-sm">
                                        View Details
                                    </a>
                                </div>

                            </div>
                        </div>

                    </div>
                @empty
                    <div class="bg-white rounded-3xl p-12 text-center border border-dashed border-gray-300">
                        <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900">No orders yet</h3>
                        <p class="text-gray-500 mt-2 mb-8">When you place an order, it will appear here.</p>
                        <a href="{{ route('shop') }}" class="inline-flex items-center px-6 py-3 bg-black text-white font-bold rounded-xl hover:bg-gray-800 transition shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                            Start Shopping
                        </a>
                    </div>
                @endforelse
            </div>

            <div class="mt-8">
                {{ $orders->links() }}
            </div>

        </div>
    </div>
</x-guest-layout>