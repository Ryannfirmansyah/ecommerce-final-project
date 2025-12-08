@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex items-center justify-center">
        
        {{-- Container Utama (Pill Abu-abu) --}}
        <div class="inline-flex items-center bg-gray-100 px-2 py-1.5 rounded-full shadow-sm gap-1">

            {{-- 1. PREVIOUS BUTTON (Selalu Muncul) --}}
            @if ($paginator->onFirstPage())
                <span aria-disabled="true" aria-label="{{ __('pagination.previous') }}">
                    <span class="flex items-center justify-center w-8 h-8 text-gray-300 cursor-default" aria-hidden="true">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </span>
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="flex items-center justify-center w-8 h-8 text-gray-500 hover:text-gray-800 transition-colors duration-200" aria-label="{{ __('pagination.previous') }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
            @endif

            {{-- 2. MOBILE VIEW: Teks "Page X of Y" (Hanya muncul di layar kecil) --}}
            <div class="flex sm:hidden items-center px-2">
                <span class="text-xs font-semibold text-gray-500">
                    {{ $paginator->currentPage() }} <span class="text-gray-300 mx-1">/</span> {{ $paginator->lastPage() }}
                </span>
            </div>

            {{-- 3. DESKTOP VIEW: Deretan Angka (Disembunyikan di layar kecil, muncul di sm ke atas) --}}
            <div class="hidden sm:flex items-center">
                @foreach ($elements as $element)
                    {{-- "Three Dots" Separator --}}
                    @if (is_string($element))
                        <span aria-disabled="true">
                            <span class="flex items-center justify-center w-8 h-8 text-gray-400 font-medium tracking-widest">{{ $element }}</span>
                        </span>
                    @endif

                    {{-- Array Of Links --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                {{-- ACTIVE STATE --}}
                                <span aria-current="page">
                                    <span class="flex items-center justify-center w-8 h-8 bg-gray-950 text-white rounded-lg font-medium shadow-md shadow-gray-700/30 mx-0.5">
                                        {{ $page }}
                                    </span>
                                </span>
                            @else
                                {{-- INACTIVE STATE --}}
                                <a href="{{ $url }}" class="flex items-center justify-center w-8 h-8 text-gray-500 hover:text-gray-900 hover:bg-gray-200/50 rounded-lg transition-colors duration-200 mx-0.5 font-medium" aria-label="{{ __('Go to page :page', ['page' => $page]) }}">
                                    {{ $page }}
                                </a>
                            @endif
                        @endforeach
                    @endif
                @endforeach
            </div>

            {{-- 4. NEXT BUTTON (Selalu Muncul) --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="flex items-center justify-center w-8 h-8 text-gray-500 hover:text-gray-800 transition-colors duration-200" aria-label="{{ __('pagination.next') }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            @else
                <span aria-disabled="true" aria-label="{{ __('pagination.next') }}">
                    <span class="flex items-center justify-center w-8 h-8 text-gray-300 cursor-default" aria-hidden="true">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </span>
                </span>
            @endif

        </div>
    </nav>
@endif