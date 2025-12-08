@props(['product', 'badge' => null])

<div class="group font-['Poppins'] hover:cursor-pointer">

    <div class="relative w-full aspect-square bg-red-50 rounded-none overflow-hidden mb-4 flex items-center justify-center transition-all duration-300 group-hover:shadow-lg">

        @if($badge)
            @php
                $badgeColor = match(strtolower($badge)) {
                    'hot' => 'bg-orange-500', // Warna Orange sesuai gambar
                    'best' => 'bg-red-600', // Warna Merah Diskon
                    default => 'bg-black'
                };
            @endphp
            <div class="absolute top-4 left-4 {{ $badgeColor }} text-white text-[10px] font-bold px-2.5 py-1 uppercase tracking-wider">
                {{ $badge }}
            </div>
        @endif

        <img
            src="{{ asset('storage/' . $product->image) }}"
            alt="{{ $product->name }}"
            class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110 mix-blend-multiply"
        >

    </div>

    <div class="text-left transition-all duration-300">
        <p class="text-gray-500 text-xs uppercase tracking-widest mb-1 line-clamp-1">{{ $product->category->name ?? 'Furniture' }}</p>
        <h3 class="text-gray-900 font-medium text-lg mb-1 group-hover:text-rose-500 line-clamp-1 transition-colors">{{ $product->name }}</h3>
        <p class="text-gray-900 font-bold">
            {{ "Rp " . number_format($product->price, 0, ',', '.') }}
        </p>
    </div>
</div>