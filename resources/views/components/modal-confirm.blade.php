@props([
    'action',                       // URL Route untuk delete (Wajib)
    'title' => 'Delete Item?',      // Judul Modal
    'message' => 'Are you sure you want to delete this? This action cannot be undone.', // Pesan Warning
    'confirmText' => 'Yes, Delete', // Teks Tombol Merah
])

<div x-data="{ open: false }" class="inline-block">
    
    <div @click="open = true" class="cursor-pointer">
        {{ $trigger }}
    </div>

    <div 
        x-show="open" 
        style="display: none;"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm z-50 transition-opacity"
        aria-hidden="true"
    ></div>

    <div 
        x-show="open" 
        style="display: none;"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        class="fixed inset-0 z-50 flex items-center justify-center p-4 overflow-x-hidden overflow-y-auto"
    >
        <div class="relative w-full max-w-md transform overflow-hidden rounded-2xl bg-white p-6 text-left shadow-xl transition-all font-['Poppins']" @click.away="open = false">
            
            <div class="flex items-center justify-center mb-6">
                <div class="w-16 h-16 rounded-full bg-red-100 flex items-center justify-center animate-pulse">
                    <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
            </div>

            <div class="text-center">
                <h3 class="text-lg font-bold leading-6 text-gray-900" id="modal-title">
                    {{ $title }}
                </h3>
                <div class="mt-2">
                    <p class="text-sm text-wrap text-gray-500">
                        {{ $message }}
                    </p>
                </div>
            </div>

            <div class="mt-8 flex items-center justify-center gap-4">
                
                <button 
                    type="button" 
                    class="inline-flex justify-center rounded-xl border border-gray-300 bg-white px-5 py-2.5 text-sm font-semibold text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none transition-colors w-full"
                    @click="open = false"
                >
                    Cancel
                </button>

                <form method="POST" action="{{ $action }}" class="w-full">
                    @csrf
                    @method('DELETE')
                    <button 
                        type="submit" 
                        class="w-full justify-center rounded-xl bg-red-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-red-500 transition-colors"
                    >
                        {{ $confirmText }}
                    </button>
                </form>

            </div>
        </div>
    </div>
</div>