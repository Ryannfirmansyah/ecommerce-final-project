<x-app-layout>
    <header class="bg-white border-b border-gray-200 px-4 py-3 sm:px-6 lg:px-8 md:py-4 shadow-sm">
        <div class="flex items-center justify-between">
            <div>
                <div class="flex items-center gap-2 text-xs sm:text-sm text-gray-500">
                    <a href="{{ route('seller.dashboard') }}" class="hover:text-black">Dashboard</a>
                    <span>›</span>
                    <a href="{{ route('seller.orders.index') }}" class="hover:text-black">Orders</a>
                    <span>›</span>
                    <span class="text-black font-semibold">#{{ $order->order_number }}</span>
                </div>
                <div class="sm:flex items-center">
                    <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-1">Order Details</h2>
                    <span class="indent-4 text-sm inline text-gray-500"> | Placed on {{ $order->created_at->format('d F Y, H:i') }}</span>
                </div>
            </div>

            <a href="{{ route('seller.orders.index') }}" class="flex items-center justify-center bg-black text-white hover:bg-gray-800 transition-colors shadow-lg w-10 h-10 rounded-full sm:w-auto sm:h-auto sm:rounded-2xl sm:px-6 sm:py-3 sm:gap-2">
                <svg class="w-5 h-5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                <span class="hidden sm:inline font-semibold">Back</span>
            </a>

        </div>

    </header>

    <main class="overflow-y-auto p-4 sm:p-6 lg:p-8 bg-gray-50 grid grid-cols-1 lg:grid-cols-3 gap-6">

        <div class="lg:col-span-2 space-y-6">

            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50 flex justify-between items-center">
                    <h3 class="font-bold text-gray-900">Items to Ship</h3>
                    <span class="text-xs font-medium bg-gray-200 text-gray-600 px-2 py-1 rounded-lg">
                        {{ $order->orderItems->sum('quantity') }} Items
                    </span>
                </div>

                <div class="divide-y divide-gray-100">
                    @foreach($order->orderItems as $item)
                    <div class="p-4 sm:p-6 flex flex-col sm:flex-row gap-4 sm:items-center">
                        <div class="w-20 h-20 sm:w-24 sm:h-24 bg-gray-100 rounded-xl overflow-hidden shrink-0 border border-gray-200">
                            @if($item->product->image)
                                <img src="{{ asset('storage/' . $item->product->image) }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-400">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </div>
                            @endif
                        </div>

                        <div class="flex-1 min-w-0">
                            <h4 class="font-bold text-gray-900 mb-1 truncate">{{ $item->product->name }}</h4>
                            <p class="text-sm text-gray-500 mb-3">{{ $item->product->category->name ?? 'Uncategorized' }}</p>

                            <div class="flex items-center justify-between sm:justify-start sm:gap-6">
                                <div class="text-xs font-bold bg-gray-100 px-3 py-1.5 rounded-lg text-gray-600 border border-gray-200">
                                    Qty: {{ $item->quantity }}
                                </div>
                                <div class="font-bold text-gray-900">
                                    Rp {{ number_format($item->price, 0, ',', '.') }}
                                </div>
                            </div>
                        </div>

                        <div class="hidden sm:block text-right">
                            <p class="text-xs text-gray-400 mb-1">Subtotal</p>
                            <p class="font-bold text-neutral-900">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6">
                <h3 class="font-bold text-gray-900 mb-4 border-b border-gray-100 pb-2">Earning Summary</h3>
                <div class="space-y-3">
                    <div class="flex justify-between text-sm text-gray-600">
                        <span>Total Product Value</span>
                        <span class="font-medium">Rp {{ number_format($order->store_total, 0, ',', '.') }}</span>
                    </div>
                    {{-- Jika ada biaya layanan/admin fee bisa ditaruh disini --}}

                    <div class="pt-3 border-t border-gray-100 flex justify-between items-center">
                        <span class="font-bold text-lg text-gray-900">Your Income</span>
                        <span class="font-bold text-xl text-green-600">Rp {{ number_format($order->store_total, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

        </div>

        <div class="space-y-6">

            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6">
                <h3 class="font-bold text-gray-400 mb-4 text-sm uppercase tracking-wider">Customer</h3>
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-12 h-12 rounded-full bg-black text-white flex items-center justify-center font-bold text-lg border-2 border-gray-100 shadow-sm">
                        {{ substr($order->user->name, 0, 1) }}
                    </div>
                    <div class="min-w-0">
                        <p class="font-bold text-gray-900 truncate">{{ $order->user->name }}</p>
                        <p class="text-sm text-gray-500 truncate">{{ $order->user->email }}</p>
                    </div>
                </div>

                <div class="border-t border-gray-100 pt-4">
                    <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2 flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        Shipping Address
                    </h4>
                    <p class="text-sm text-gray-600 leading-relaxed bg-gray-50 p-3 rounded-xl border border-gray-100">
                        {{ $order->shipping_address ?? 'No address provided by customer.' }}
                    </p>
                </div>
            </div>

            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6 sm:mb-8">
                <div class="w-full md:w-auto bg-white p-4 rounded-2xl border border-gray-200 shadow-sm">
                    <form action="{{ route('seller.orders.update-status', $order->id) }}" method="POST" class="flex flex-col sm:flex-row items-center gap-3">
                        @csrf
                        @method('PUT')

                        <div class="w-full sm:w-auto">
                            <label class="sr-only">Status</label>
                            <div class="relative">
                                <select name="status" class="w-full sm:w-48 appearance-none bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-black focus:border-black block p-2.5 pr-8 transition-colors cursor-pointer">
                                    <option value="pending" {{ $currentStatus == 'pending' ? 'selected' : '' }}>🟡 Pending</option>
                                    <option value="processing" {{ $currentStatus == 'processing' ? 'selected' : '' }}>🔵 Processing</option>
                                    <option value="completed" {{ $currentStatus == 'completed' ? 'selected' : '' }}>🟢 Completed</option>
                                    <option value="cancelled" {{ $currentStatus == 'cancelled' ? 'selected' : '' }}>🔴 Cancelled</option>
                                </select>
                            </div>
                        </div>

                        <button type="submit" class="w-full sm:w-auto bg-black text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:bg-gray-800 transition shadow-md flex justify-center items-center gap-2">
                            <span>Update Status</span>
                        </button>
                    </form>
                </div>
            </div>

            <button onclick="window.print()"s
             class="w-full py-3.5 border-2 border-dashed border-gray-300 rounded-2xl text-gray-500 font-bold hover:border-black hover:text-black hover:bg-gray-50 transition flex items-center justify-center gap-2 group">
                <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                Print Shipping Label
            </button>

        </div>

    </main>
</x-app-layout>