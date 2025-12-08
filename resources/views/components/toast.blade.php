@props(['timeout' => 4000]) {{-- Default hilang dalam 4 detik --}}

@php
    $messages = [
        'success' => [
            'bg' => 'bg-black text-white',
            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>'
        ],
        'error' => [
            'bg' => 'bg-red-600 text-white',
            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>'
        ],
        'info' => [
            'bg' => 'bg-blue-600 text-white',
            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>'
        ],
        'warning' => [
            'bg' => 'bg-yellow-500 text-white',
            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>'
        ]
    ];
@endphp

<div class="fixed top-20 right-6 z-50 flex flex-col gap-2 pointer-events-none">
    @foreach ($messages as $type => $style)
        @if (session()->has($type))
            <div x-data="{ show: true }"
                 x-show="show"
                 x-init="setTimeout(() => show = false, {{ $timeout }})"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                 x-transition:leave-end="opacity-0 translate-y-2 scale-95"
                 class="pointer-events-auto flex items-center gap-3 px-6 py-4 rounded-2xl shadow-2xl {{ $style['bg'] }} min-w-[300px] max-w-md cursor-pointer"
                 @click="show = false"
            >
                <div class="shrink-0 p-1 bg-white/20 rounded-full">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        {!! $style['icon'] !!}
                    </svg>
                </div>

                <div class="flex-1">
                    <p class="font-bold text-sm capitalize">{{ $type }}</p>
                    <p class="text-sm font-medium opacity-90">{{ session($type) }}</p>
                </div>

                <button @click="show = false" class="opacity-70 hover:opacity-100 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        @endif
    @endforeach
</div>