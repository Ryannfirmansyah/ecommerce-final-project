@if(false)

<x-app-layout>
    <!-- Topbar -->
    <header class="bg-white border-b border-gray-200 px-8 py-4 shadow-lg">
        <div class="flex flex-col justify-between">
            <div class="flex items-center gap-2 text-sm text-gray-500 mb-2">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-black">Dashboard</a>
                <span>›</span>
                <span class="text-black font-semibold">Products</span>
            </div>
            <div class="w-full flex justify-between">
                <h2 class="font-bold text-2xl text-black">Products Management</h2>
                <a href="{{ route('seller.products.create') }}" class="px-5 py-2.5 bg-black text-white rounded-xl text-sm font-semibold hover:bg-gray-800 transition shadow-sm">
                    + Add New Product
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content Area -->
    <main class="flex-1 overflow-y-auto p-8 bg-slate-50">

        {{-- Search Bar --}}
        <div class="mb-6">
            <form method="GET" action="{{ route('seller.products.index') }}">
                <div class="relative">
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ request('search') }}" 
                        placeholder="Search product by name or store..." 
                        class="w-full px-4 py-3 pl-12 bg-white border border-gray-200 rounded-2xl focus:outline-none focus:border-black transition-colors shadow-lg"
                    >
                    <svg class="w-5 h-5 text-gray-400 absolute left-4 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
            </form>

        </div>

        {{-- Products Table --}}
        <div class="bg-white rounded-2xl border border-gray-200 shadow-lg overflow-hidden">
            <table class="w-full text-left">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Product</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Price & Stock</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Store / Seller</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Category</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($products as $product)
                    <tr class="hover:bg-gray-50 transition-colors">
                        {{-- Product Info --}}
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-4">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" class="w-12 h-12 rounded-lg object-cover bg-gray-100 border border-gray-200" alt="{{ $product->name }}">
                                @else
                                    <div class="w-12 h-12 rounded-lg bg-gray-100 border border-gray-200 flex items-center justify-center text-gray-400">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    </div>
                                @endif
                                <div>
                                    <h3 class="font-semibold text-black text-sm">{{ $product->name }}</h3>
                                </div>
                            </div>
                        </td>

                        {{-- Price & Stock --}}
                        <td class="px-6 py-4">
                            <p class="font-bold text-black text-sm">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                            <p class="text-xs text-gray-500">Stock: {{ $product->stock }}</p>
                        </td>

                        {{-- Store Info --}}
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <div class="w-6 h-6 rounded-full bg-black text-white flex items-center justify-center text-xs font-bold">
                                    {{ substr($product->store->name ?? '?', 0, 1) }}
                                </div>
                                <span class="text-sm text-gray-700">{{ $product->store->name ?? 'Deleted Store' }}</span>
                            </div>
                        </td>

                        {{-- Category --}}
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 bg-gray-100 text-gray-600 rounded-full text-xs font-medium">
                                {{ $product->category->name ?? 'Uncategorized' }}
                            </span>
                        </td>

                        {{-- Action (Delete Only) --}}
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <a href="{{ route('seller.products.edit', $product) }}" class="flex items-center gap-2 px-3 py-2 bg-white border border-blue-200 text-blue-600 rounded-xl hover:bg-blue-50 hover:border-blue-300 transition-all text-xs font-bold shadow-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    Edit
                                </a>
                                
                                <form action="{{ route('seller.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus paksa produk ini? Tindakan ini tidak dapat dibatalkan.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="flex items-center gap-2 px-3 py-2 bg-white border border-red-200 text-red-600 rounded-xl hover:bg-red-50 hover:border-red-300 transition-all text-xs font-bold shadow-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-gray-500 bg-gray-50">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                                <p>No products found matching your search.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-6">
            {{ $products->links() }}
        </div>
    </main>

</x-app-layout>

@else
<x-app-layout>
    <header class="bg-white border-b border-gray-200 px-4 py-3 sm:px-6 lg:px-8 md:py-4 shadow-sm">
        <div class="flex sm:items-center justify-between gap-3">
            <div>
                <div class="flex items-center gap-2 text-xs sm:text-sm text-gray-500 mb-1 sm:mb-2">
                    <a href="{{ route('seller.dashboard') }}" class="hover:text-black">Dashboard</a>
                    <span>›</span>
                    <span class="text-black font-semibold">Products</span>
                </div>
                <h2 class="font-bold text-xl sm:text-2xl text-black">My Products</h2>
            </div>
            
            <a href="{{ route('seller.products.create') }}" class="flex items-center justify-center bg-black text-white hover:bg-gray-800 transition-colors shadow-lg w-10 h-10 rounded-full sm:w-auto sm:h-auto sm:rounded-2xl sm:px-5 sm:py-3 sm:gap-2 self-end sm:self-auto">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span class="hidden sm:inline font-semibold">Add Product</span>
            </a>
        </div>
    </header>

    <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8 bg-gray-50">

        {{-- Search Bar --}}
        <div class="mb-6">
            <x-search-bar 
                :action="route('seller.products.index')"
                placeholder="Search products..." 
                class="w-full !mb-0"
            />
        </div>

        {{-- Products Table --}}
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left min-w-[900px]">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Product</th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Price & Stock</th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Store</th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Category</th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($products as $product)
                        <tr class="hover:bg-gray-50 transition-colors group">
                            {{-- Product Info --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-4">
                                    <div class="shrink-0">
                                        @if($product->image)
                                            <img src="{{ asset('storage/' . $product->image) }}" class="w-12 h-12 rounded-lg object-cover bg-gray-100 border border-gray-200" alt="{{ $product->name }}">
                                        @else
                                            <div class="w-12 h-12 rounded-lg bg-gray-100 border border-gray-200 flex items-center justify-center text-gray-400">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <h3 class="font-semibold text-black text-sm line-clamp-1" title="{{ $product->name }}">{{ $product->name }}</h3>
                                    </div>
                                </div>
                            </td>

                            {{-- Price & Stock --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                <p class="font-bold text-black text-sm">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                <p class="text-xs text-gray-500">Stock: {{ $product->stock }}</p>
                            </td>

                            {{-- Store Info --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 rounded-full bg-black text-white flex items-center justify-center text-xs font-bold shrink-0">
                                        {{ substr($product->store->name ?? '?', 0, 1) }}
                                    </div>
                                    <span class="text-sm text-gray-700 truncate max-w-[150px]">{{ $product->store->name ?? 'Deleted Store' }}</span>
                                </div>
                            </td>

                            {{-- Category --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 bg-gray-100 text-gray-600 rounded-full text-xs font-medium">
                                    {{ $product->category->name ?? 'Uncategorized' }}
                                </span>
                            </td>

                            {{-- Actions --}}
                            <td class="px-6 py-4 text-center whitespace-nowrap">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('seller.products.edit', $product) }}" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors border border-transparent hover:border-blue-100" title="Edit">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>
                                    
                                    <x-modal-confirm 
                                        :action="route('seller.products.destroy', $product)"
                                        title="Delete Product?"
                                        message="Are you sure you want to delete {{ $product->name }}? This cannot be undone."
                                        confirm-text="Delete"
                                    >
                                        <x-slot name="trigger">
                                            <button type="button" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors border border-transparent hover:border-red-100" title="Delete">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </x-slot>
                                    </x-modal-confirm>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-16 text-center text-gray-500 bg-gray-50">
                                <div class="flex flex-col items-center justify-center gap-2">
                                    <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                                    <p class="font-medium text-gray-600">No products found</p>
                                    <p class="text-xs text-gray-400 mt-1">Get started by adding your first product.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination --}}
        <div class="mt-6">
            {{ $products->links('vendor.pagination.custom') }}
        </div>
    </main>

</x-app-layout>
@endif