<div class="flex flex-col md:grid md:grid-cols-12 gap-6 items-center">

    {{-- 1. Gambar & Judul --}}
    <div class="col-span-6 flex items-start gap-4 w-full">
        {{-- Gambar --}}
        <div class="w-24 h-24 bg-gray-100 rounded-xl overflow-hidden shrink-0 border border-gray-200">
            <img src="{{ asset('storage/' . $item->product->image) }}"
                alt="{{ $item->product->name }}"
                class="w-full h-full object-cover">
        </div>

        {{-- Detail --}}
        <div>
            <a href="{{ route('products.show', $item->product) }}"><h3 class="font-bold text-lg text-gray-900 line-clamp-2">{{ $item->product->name }}</h3></a>
            <p class="text-sm text-gray-500 mt-1">Price: Rp {{ number_format($item->product->price, 0, ',', '.') }}</p>

            {{-- Stock Warning Logic --}}
            @if($item->quantity > $item->product->stock)
                <p class="text-xs text-red-500 font-bold mt-2">
                    Stok Kurang! Tersisa: {{ $item->product->stock }}
                </p>
            @endif
        </div>
    </div>

    {{-- 2. Quantity Selector --}}
    <div class="col-span-3 flex justify-center w-full md:w-auto">
        <div class="flex items-center border border-gray-300 rounded-full px-4 py-1.5 gap-4">
            {{-- Form Decrease --}}
            <form action="{{ route('buyer.cart.update', $item->id) }}" method="POST">
                @csrf @method('PUT')
                <input type="hidden" name="quantity" value="{{ $item->quantity - 1 }}">
                <button type="submit" class="text-gray-500 hover:text-black font-bold text-lg leading-none pb-1" {{ $item->quantity <= 1 ? 'disabled' : '' }}>-</button>
            </form>

            <span class="font-medium text-gray-900 text-sm">{{ $item->quantity }}</span>

            {{-- Form Increase --}}
            <form action="{{ route('buyer.cart.update', $item->id) }}" method="POST">
                @csrf @method('PUT')
                <input type="hidden" name="quantity" value="{{ $item->quantity + 1 }}">
                <button type="submit" class="text-gray-500 hover:text-black font-bold text-lg leading-none pb-1">+</button>
            </form>
        </div>
    </div>

    {{-- 3. Total Price & Delete --}}
    <div class="col-span-3 w-full md:w-auto flex flex-row md:flex-col justify-between md:justify-center items-center md:items-end gap-2">
        {{-- Subtotal Item --}}
        <div class="font-bold text-lg text-gray-900">
            Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}
        </div>

        {{-- Delete Button --}}
        <form action="{{ route('buyer.cart.destroy', $item->id) }}" method="POST">
            @csrf @method('DELETE')
            <button type="submit" class="text-xs text-gray-400 hover:text-red-500 flex items-center gap-1 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
                Remove
            </button>
        </form>
    </div>

</div>