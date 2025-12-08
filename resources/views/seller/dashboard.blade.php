<x-app-layout>
    <header class="bg-white border-b border-gray-200 px-4 py-3 sm:px-6 lg:px-8 md:py-4">
        <div class="flex items-center gap-2 text-xs sm:text-sm text-gray-500 mb-1 sm:mb-2">
            <a href="{{ route('seller.dashboard') }}" class="hover:text-black">Dashboard</a>
        </div>
        <h2 class="font-bold text-xl sm:text-2xl text-black">Welcome, <span class="text-gray-500">{{ $store ? $store->name : Auth::user()->name }}</span></h2>
    </header>

    <main class="flex-1 p-4 md:p-8 lg:p-12 overflow-y-auto ">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-6 md:mb-12">

            <div class="bg-white p-5 md:p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between h-full">
                <div>
                    <p class="text-xs text-gray-400 font-bold uppercase tracking-wider mb-2">Total Revenue</p>
                    <h3 class="text-2xl md:text-3xl font-serif font-bold text-neutral-900 truncate">
                        Rp {{ number_format($stats['revenue'], 0, ',', '.') }}
                    </h3>
                </div>
                <div class="mt-4 flex items-center gap-2 text-sm text-green-600 bg-green-50 w-fit px-2 py-1 rounded-lg">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>Total Earnings</span>
                </div>
            </div>

            <div class="bg-white p-5 md:p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between relative overflow-hidden h-full">
                <div>
                    <p class="text-xs text-gray-400 font-bold uppercase tracking-wider mb-2">Pending Orders</p>
                    <h3 class="text-3xl md:text-4xl font-serif font-bold text-neutral-900">{{ $stats['pending_orders'] }}</h3>
                </div>

                @if($stats['pending_orders'] > 0)
                    <a href="{{ route('seller.orders.index', ['status' => 'pending']) }}" class="mt-4 flex items-center gap-2 text-sm text-orange-600 bg-orange-50 w-fit px-2 py-1 rounded-lg animate-pulse">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>Need Action</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                @else
                    <div class="mt-4 text-sm text-gray-400">All caught up!</div>
                @endif
            </div>

            <div class="bg-white p-5 md:p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between h-full">
                <div>
                    <p class="text-xs text-gray-400 font-bold uppercase tracking-wider mb-2">Completed Orders</p>
                    <h3 class="text-3xl md:text-4xl font-serif font-bold text-neutral-900">{{ $stats['total_orders'] }}</h3>
                </div>
                <div class="mt-4 flex items-center gap-2 text-sm text-blue-600 bg-blue-50 w-fit px-2 py-1 rounded-lg">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                    <span>Successfully Delivered</span>
                </div>
            </div>

            <div class="bg-white p-5 md:p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between h-full">
                <div>
                    <p class="text-xs text-gray-400 font-bold uppercase tracking-wider mb-2">Active Products</p>
                    <h3 class="text-3xl md:text-4xl font-serif font-bold text-neutral-900">{{ $stats['total_products'] }}</h3>
                </div>
                <div class="mt-4 flex items-center gap-2 text-sm text-gray-600">
                    <span>In your catalog</span>
                </div>
            </div>

        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-8">
            <div class="px-6 py-5 border-b border-gray-50 flex justify-between items-center">
                <h3 class="font-bold text-lg">Recent Orders</h3>
                {{-- Ensure route exists --}}
                <a href="{{ route('seller.orders.index') }}" class="text-xs font-bold text-gray-400 hover:text-black">VIEW ALL</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left min-w-[800px]">
                    <thead class="bg-gray-50/50">
                        <tr>
                            <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Order Info</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Customer</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Total</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($recentOrders as $order)
                        <tr class="hover:bg-gray-50/50 transition">
                            {{-- Order Info --}}
                            <td class="px-6 py-4">
                                <div class="flex flex-col">
                                    <span class="font-bold text-sm text-neutral-900">{{ $order->order_number }}</span>
                                    <span class="text-xs text-gray-400">{{ $order->created_at->diffForHumans() }}</span>
                                </div>
                            </td>

                            {{-- Customer --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center text-xs font-bold text-gray-500">
                                        {{ substr($order->user->name, 0, 1) }}
                                    </div>
                                    <span class="text-sm font-medium text-gray-700">{{ $order->user->name }}</span>
                                </div>
                            </td>

                            {{-- Status --}}
                            <td class="px-6 py-4">
                                @php

                                    $statusClass = $statusClasses[$order->status] ?? 'bg-gray-50 text-gray-700';
                                @endphp
                                <span class="text-xs font-bold px-3 py-1 rounded-full border {{ $statusClass }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>

                            {{-- Total --}}
                            <td class="px-6 py-4 text-sm font-bold text-neutral-900">
                                Rp {{ number_format($order->store_total ?? 0, 0, ',', '.') }}
                            </td>

                            {{-- Action --}}
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('seller.orders.show', $order->id) }}" class="inline-flex items-center justify-center w-8 h-8 rounded-full hover:bg-black hover:text-white transition text-gray-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-gray-400 text-sm">
                                <div class="flex flex-col items-center justify-center gap-2">
                                    <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                                    <span>No orders yet.</span>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</x-app-layout>