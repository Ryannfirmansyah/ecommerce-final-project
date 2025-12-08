@props([
    'action', 
    'placeholder' => 'Search...' 
])

<div {{ $attributes->merge(['class' => 'mb-6']) }}>
    <form method="GET" action="{{ $action }}">
        
        {{-- Hidden Inputs untuk menjaga filter lain --}}
        @foreach(request()->except(['search', 'page']) as $key => $value)
            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
        @endforeach

        <div class="relative">
            <input 
                type="text" 
                name="search" 
                value="{{ request('search') }}" 
                placeholder="{{ $placeholder }}" 
                class="w-full px-4 py-3 pl-12 bg-white border border-gray-200 rounded-2xl focus:outline-none focus:border-black transition-colors shadow-sm"
                autocomplete="off"
            >
            
            <button 
                type="submit" 
                class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-black transition-colors focus:outline-none"
                title="Search"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </button>
            
        </div>
    </form>
</div>