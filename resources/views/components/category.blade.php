@php
    $bgImage = 'storage/products/default.png'; // Gambar default

    if (!empty($category->image)) {
        $bgImage = 'storage/' . $category->image;
    } elseif ($category->products()->exists()) {
        $firstProduct = $category->products()->inRandomOrder()->first();
        if ($firstProduct && $firstProduct->image) {
            $bgImage = 'storage/' . $firstProduct->image;
        }
    }
@endphp

<a href="{{ route('shop', ['category' => $category->slug]) }}"
class="group relative aspect-square flex items-center justify-center overflow-hidden hover:shadow-lg transition-all duration-300">

    <img src="{{ asset($bgImage) }}"
        alt="{{ $category->name }}"
        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500 mix-blend-multiply">

    <div class="absolute bottom-6 left-6">
        <p class="font-semibold text-gray-900 group-hover:text-white transition-colors">
            {{ $category->name }}
        </p>

        @if($category->total_sold > 0)
        <span class="text-xs text-gray-500 block mt-1">{{ $category->total_sold }} Terjual</span>
        @endif
    </div>
</a>