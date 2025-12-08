<aside class="w-64 bg-white border-r border-gray-200 flex flex-col mb-2">
    <!-- Logo -->
    <div class="p-6 border-b border-gray-200">
        <h1 class="font-bold text-2xl text-black">{{ Auth::user()->store->name ?? 'My Store' }}</h1>
        <p class="text-xs text-gray-500 mt-1">Seller Dashboard</p>
    </div>

    <nav class="flex-1 p-4 space-y-2">
        <x-aside-link :href="route('seller.dashboard')" :active="request()->routeIs('seller.dashboard')">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
            </svg>
            <span class="font-semibold">Dashboard</span>
        </x-aside-link>

        <x-aside-link :href="route('seller.products.index')" :active="request()->routeIs('seller.products.index')">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
            </svg>
            <span class="font-medium">My Products</span>
        </x-aside-link>

        <x-aside-link :href="route('seller.orders.index')" :active="request()->routeIs('seller.orders.index')">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
            </svg>
            <span class="font-medium">Orders</span>
        </x-aside-link>

        <x-aside-link :href="route('seller.store.edit')" :active="request()->routeIs('seller.store.edit')">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
            </svg>
            <span class="font-medium">Store Settings</span>
        </x-aside-link>

        <x-aside-link :href="route('home')" :active="false">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            <span class="font-medium">Browse Products</span>
        </x-aside-link>
    </nav>

    <!-- Quick Actions -->
    <div class="p-4 border-t border-gray-200">
        <a href="{{ route('seller.products.create') }}" class="flex items-center justify-center gap-2 px-4 py-3 bg-black text-white rounded-2xl font-semibold hover:bg-gray-800 transition-all">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Add Product
        </a>
    </div>

    <!-- User Profile -->
    <div class="p-4 border-t border-gray-200">
        <div class="flex items-center gap-3 px-4 py-3 rounded-2xl bg-gray-100">
            <div class="w-10 h-10 rounded-full bg-black flex items-center justify-center text-white font-bold">
                {{ substr(Auth::user()->name, 0, 1) }}
            </div>
            <div class="flex-1 min-w-0">
                <p class="font-semibold text-sm truncate text-black">{{ Auth::user()->name }}</p>
                <p class="text-xs text-gray-500">Seller Account</p>
            </div>
        </div>
    </div>
</aside>
