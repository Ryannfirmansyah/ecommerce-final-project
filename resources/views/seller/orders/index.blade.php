<x-app-layout>
    <header class="bg-white border-b border-gray-200 px-4 py-3 sm:px-6 lg:px-8 md:py-4 shadow-sm">
        <div class="flex items-center justify-between">
            <div>
                <div class="flex items-center gap-2 text-xs sm:text-sm text-gray-500 mb-1 sm:mb-2">
                    <a href="{{ route('seller.dashboard') }}" class="hover:text-black">Dashboard</a>
                    <span>›</span>
                    <span class="text-black font-semibold">Orders</span>
                </div>
                <h2 class="font-bold text-xl sm:text-2xl text-black">Incoming Orders</h2>
            </div>
        </div>
    </header>

    <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8 bg-gray-50">

        <div class="mb-6 flex flex-col md:flex-row items-start md:items-center gap-4">
            <x-search-bar 
                :action="route('seller.orders.index')"
                placeholder="Search by order number..." 
                class="w-full md:flex-1 relative !mb-0"  
            />

            <div class="w-full md:w-auto overflow-x-auto pb-2 md:pb-0">
                <div class="flex items-center gap-2 bg-gray-50 p-1.5 sm:p-2 rounded-2xl border border-gray-200 min-w-max">
                    
                    {{-- Tombol ALL --}}
                    <a href="{{ request()->fullUrlWithQuery(['status' => null]) }}" 
                    class="px-3 sm:px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold transition-all whitespace-nowrap
                    {{ request('status') == null ? 'bg-black text-white shadow-md' : 'text-gray-600 hover:bg-gray-200' }}">
                        All
                    </a>

                    {{-- Tombol PENDING --}}
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'pending']) }}" 
                    class="px-3 sm:px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold transition-all whitespace-nowrap flex items-center gap-2
                    {{ request('status') == 'pending' ? 'bg-yellow-500 text-white shadow-md' : 'text-gray-600 hover:bg-yellow-50 hover:text-yellow-600' }}">
                        {{-- Dot Indikator (Opsional) --}}
                        <span class="w-2 h-2 rounded-full {{ request('status') == 'pending' ? 'bg-white' : 'bg-yellow-500' }}"></span>
                        Pending
                    </a>

                    {{-- Tombol PROCESSING --}}
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'processing']) }}" 
                    class="px-3 sm:px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold transition-all whitespace-nowrap flex items-center gap-2
                    {{ request('status') == 'processing' ? 'bg-blue-600 text-white shadow-md' : 'text-gray-600 hover:bg-blue-50 hover:text-blue-600' }}">
                        <span class="w-2 h-2 rounded-full {{ request('status') == 'processing' ? 'bg-white' : 'bg-blue-600' }}"></span>
                        Processing
                    </a>

                    {{-- Tombol COMPLETED --}}
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'completed']) }}" 
                    class="px-3 sm:px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold transition-all whitespace-nowrap flex items-center gap-2
                    {{ request('status') == 'completed' ? 'bg-green-600 text-white shadow-md' : 'text-gray-600 hover:bg-green-50 hover:text-green-600' }}">
                        <span class="w-2 h-2 rounded-full {{ request('status') == 'completed' ? 'bg-white' : 'bg-green-600' }}"></span>
                        Completed
                    </a>

                    {{-- Tombol CANCELLED --}}
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'cancelled']) }}" 
                    class="px-3 sm:px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold transition-all whitespace-nowrap flex items-center gap-2
                    {{ request('status') == 'cancelled' ? 'bg-red-600 text-white shadow-md' : 'text-gray-600 hover:bg-red-50 hover:text-red-600' }}">
                        <span class="w-2 h-2 rounded-full {{ request('status') == 'cancelled' ? 'bg-white' : 'bg-red-600' }}"></span>
                        Cancelled
                    </a>

                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left min-w-[900px]">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="pl-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Order #</th>
                            <th class="pl-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Customer</th>
                            <th class="pl-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Items</th>
                            <th class="pl-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Earnings</th>
                            <th class="pl-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="pl-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider text-right">Action</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-200">
                        @forelse ($orders as $order)
                            <tr class="hover:bg-gray-50 transition-colors group">
                                {{-- 1. Order Number --}}
                                <td class="pl-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-bold text-gray-900">#{{ $order->order_number }}</div>
                                </td>

                                {{-- 2. Customer Info --}}
                                <td class="pl-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <div class="h-8 w-8 rounded-full bg-gray-100 flex items-center justify-center text-xs font-bold text-gray-500 border border-gray-200">
                                            {{ substr($order->user->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">{{ $order->user->name }}</div>
                                            <div class="text-xs text-gray-500">{{ $order->user->email }}</div>
                                        </div>
                                    </div>
                                </td>

                                {{-- 3. Items Ordered --}}
                                <td class="pl-6 py-4">
                                    <div class="flex flex-col gap-1 max-w-xs">
                                        @foreach($order->orderItems as $item)
                                            <div class="text-sm text-gray-600 flex justify-between items-center gap-2">
                                                <span class="truncate">{{ $item->product->name }}</span>
                                                <span class="text-xs font-bold bg-gray-100 pl-2 py-0.5 rounded text-gray-800 shrink-0 border border-gray-200">x{{ $item->quantity }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </td>

                                {{-- 4. Store Earnings --}}
                                <td class="pl-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-bold text-green-600">
                                        Rp {{ number_format($order->store_total, 0, ',', '.') }}
                                    </div>
                                </td>

                                {{-- 5. Status --}}
                                <td class="pl-6 py-4 whitespace-nowrap">
                                    <span class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full border {{ $statusClasses[$order->orderItems()->first()->status] ?? 'bg-gray-50 text-gray-700 border-gray-100' }}">
                                        {{ucfirst($order->orderItems()->first()->status)}}
                                    </span>
                                </td>

                                {{-- 6. Date --}}
                                <td class="pl-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <div>{{ $order->created_at->format('d M Y') }}</div>
                                    <div class="text-xs text-gray-400">{{ $order->created_at->format('H:i') }}</div>
                                </td>

                                {{-- 7. Actions --}}
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('seller.orders.show', $order->id) }}" class="inline-flex items-center gap-1 px-3 py-1.5 bg-white border border-gray-200 text-gray-700 text-xs font-semibold rounded-lg hover:bg-gray-50 hover:border-gray-300 transition-all shadow-sm">
                                        Manage
                                        <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-16 text-center text-gray-500 bg-gray-50">
                                    <div class="flex flex-col items-center justify-center gap-3">
                                        <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center border border-gray-100 shadow-sm">
                                            <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-900">No orders found</p>
                                            <p class="text-xs text-gray-500 mt-1">Orders will appear here when customers purchase your items.</p>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination Links --}}
        <div class="mt-6">
            {{ $orders->links('vendor.pagination.custom') }}
        </div>

    </main>
</x-app-layout>