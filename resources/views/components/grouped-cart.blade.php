@php
    $store = $items->first()->product->store;
@endphp

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

    {{-- HEADER TOKO --}}
    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50 flex items-center gap-3">
        <div class="p-1.5 bg-white rounded-lg border border-gray-200">
            <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
        </div>
        <span class="font-bold text-gray-900">{{ $store->name }}</span>
    </div>

    {{-- BODY LIST PRODUK --}}
    <div class="p-6 space-y-8">
        @foreach($items as $item)
            @include('components.cart-item', ['item'=>$item])
        @endforeach
    </div>
</div>