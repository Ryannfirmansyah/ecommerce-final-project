<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My Dashboard - NexusPlace</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #FFFFFF; }
        .font-serif { font-family: 'Playfair Display', serif; }
        .nav-item.active { background-color: #F5F5F5; color: #1A1A1A; font-weight: 600; }
        .nav-item { color: #888888; transition: all 0.2s; }
        .nav-item:hover { color: #1A1A1A; background-color: #FAFAFA; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="antialiased">

    <div class="min-h-screen flex flex-col md:flex-row max-w-[1440px] mx-auto">

        <!-- 1. SIDE MENU (Kiri) -->
        <aside class="w-full md:w-64 flex-shrink-0 p-6 md:py-12 md:border-r border-gray-100">
            <!-- Logo Area -->
            <div class="mb-10 px-4">
                <a href="{{ route('home') }}" class="text-xl font-bold tracking-tight">NexusPlace.</a>
                <p class="text-xs text-gray-400 mt-1">Buyer Dashboard</p>
            </div>

            <!-- Profile Snippet -->
            <div class="flex items-center gap-3 px-4 mb-10">
                <div class="w-10 h-10 rounded-full bg-neutral-900 text-white flex items-center justify-center font-bold text-sm">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div class="overflow-hidden">
                    <p class="text-sm font-bold text-neutral-900 truncate">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-gray-400 truncate">{{ Auth::user()->email }}</p>
                </div>
            </div>

            <!-- Navigation Menu -->
            <nav class="space-y-1">
                <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }} flex items-center gap-3 px-4 py-3 rounded-xl text-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                    Overview
                </a>
                <a href="{{ route('buyer.orders.index') }}" class="nav-item {{ request()->routeIs('buyer.orders.*') ? 'active' : '' }} flex items-center gap-3 px-4 py-3 rounded-xl text-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                    My Orders
                </a>
                <a href="{{ route('buyer.cart.index') }}" class="nav-item {{ request()->routeIs('buyer.cart.*') ? 'active' : '' }} flex items-center gap-3 px-4 py-3 rounded-xl text-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    My Cart
                </a>
                <a href="{{ route('profile.edit') }}" class="nav-item {{ request()->routeIs('profile.edit') ? 'active' : '' }} flex items-center gap-3 px-4 py-3 rounded-xl text-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    Settings
                </a>
            </nav>

            <div class="mt-10 px-4">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center gap-2 text-sm font-bold text-red-600 hover:text-red-700 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        Sign Out
                    </button>
                </form>
            </div>
        </aside>

        <!-- 2. MAIN CONTENT (Tengah) -->
        <main class="flex-1 p-6 md:p-12">
            <!-- Header Content -->
            <div class="flex justify-between items-end mb-10">
                <div>
                    <h1 class="text-3xl font-serif font-bold text-neutral-900 mb-2">Hello, {{ explode(' ', Auth::user()->name)[0] }}</h1>
                    <p class="text-gray-500 text-sm">Welcome back to your dashboard.</p>
                </div>
                <a href="{{ route('home') }}" class="hidden md:flex items-center gap-2 text-sm font-bold border border-gray-200 px-4 py-2 rounded-full hover:bg-black hover:text-white transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Back to Shop
                </a>
            </div>

            <!-- Stats Overview -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
                <div class="bg-rose-500 p-6 rounded-2xl">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Total Orders</p>
                    <div class="flex items-end justify-between">
                        <h3 class="text-4xl font-serif font-bold">{{ $orders->count() }}</h3>
                        <div class="p-2 bg-white rounded-full text-gray-400"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg></div>
                    </div>
                </div>
                <div class="bg-rose-500 p-6 rounded-2xl">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Pending</p>
                    <div class="flex items-end justify-between">
                        <h3 class="text-4xl font-serif font-bold">{{ $orders->where('status', 'pending')->count() }}</h3>
                        <div class="p-2 bg-white rounded-full text-yellow-500"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></div>
                    </div>
                </div>
                <div class="bg-rose-500 p-6 rounded-2xl">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">In Cart</p>
                    <div class="flex items-end justify-between">
                        <h3 class="text-4xl font-serif font-bold">{{ \App\Models\Cart::where('user_id', auth()->id())->sum('quantity') }}</h3>
                        <div class="p-2 bg-white rounded-full text-blue-500"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg></div>
                    </div>
                </div>
            </div>

            <!-- Recent Orders (List Vertical) -->
            <div class="mb-12">
                <h3 class="text-lg font-bold mb-6">Recent Orders</h3>
                <div class="space-y-4">
                    @forelse($orders as $order)
                    <div class="bg-white border border-gray-100 rounded-2xl p-5 hover:shadow-lg hover:shadow-gray-100/50 transition-all flex flex-col md:flex-row items-center justify-between gap-4">
                        <div class="flex items-center gap-4 w-full md:w-auto">
                            <div class="w-12 h-12 bg-gray-50 rounded-xl flex items-center justify-center flex-shrink-0">
                                <span class="font-bold text-gray-400">#</span>
                            </div>
                            <div>
                                <p class="font-bold text-neutral-900">Order #{{ $order->order_number }}</p>
                                <p class="text-xs text-gray-400">{{ $order->created_at->format('d M, Y') }}</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-6 w-full md:w-auto justify-between md:justify-end">
                            <!-- Status Badge Pill -->
                            @if($order->status == 'completed')
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-green-50 text-green-600 border border-green-100">Completed</span>
                            @elseif($order->status == 'pending')
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-yellow-50 text-yellow-600 border border-yellow-100">Processing</span>
                            @else
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-gray-50 text-gray-600 border border-gray-100">{{ ucfirst($order->status) }}</span>
                            @endif

                            <p class="font-bold text-sm">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>

                            <a href="{{ route('buyer.orders.show', $order) }}" class="p-2 border border-gray-200 rounded-full hover:bg-black hover:text-white transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </a>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-12 bg-gray-50 rounded-2xl border border-dashed border-gray-200">
                        <p class="text-gray-400 text-sm">No recent orders found.</p>
                        <a href="{{ route('home') }}" class="text-black font-bold text-sm underline mt-2 inline-block">Start Shopping</a>
                    </div>
                    @endforelse
                </div>
            </div>

        </main>
    </div>

</body>
</html>