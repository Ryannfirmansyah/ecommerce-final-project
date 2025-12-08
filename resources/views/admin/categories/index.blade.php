<x-app-layout>

    <header class="bg-white border-b border-gray-200 px-4 py-3 sm:px-6 lg:px-8 md:py-4">
        <div class="flex items-center justify-between">
            <div>
                <div class="flex items-center gap-2 text-xs sm:text-sm text-gray-500 mb-1 sm:mb-2">
                    <a href="{{ route('admin.dashboard') }}" class="hover:text-black">Dashboard</a>
                    <span>›</span>
                    <span class="text-black font-semibold">Categories</span>
                </div>
                <h2 class="font-bold text-xl sm:text-2xl text-black">Categories</h2>
            </div>
            
            <a href="{{ route('admin.categories.create') }}" class="flex items-center justify-center bg-black text-white hover:bg-gray-800 transition-colors shadow-lg
                w-10 h-10 rounded-full sm:w-auto sm:h-auto sm:rounded-2xl sm:px-6 sm:py-3 sm:gap-2">
                
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                
                <span class="hidden sm:inline font-semibold">Add Category</span>
            </a>
        </div>
    </header>

    <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8 bg-gray-50">
        
        {{-- Search Bar --}}
        <div class="mb-6">
            <x-search-bar 
                :action="route('admin.categories.index')"
                placeholder="Search categories..." 
                class="w-full !mb-0"
            />
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">
            @forelse($categories as $category)
                <div class="bg-white rounded-2xl p-5 sm:p-6 border border-gray-200 hover:shadow-lg transition-all flex flex-col h-full">
                    
                    <div class="flex items-start justify-between mb-4">
                        <div class="w-12 h-12 sm:w-14 sm:h-14 bg-gray-50 rounded-2xl flex items-center justify-center">
                            @if($category->image) 
                                <img src="{{ asset('storage/' . $category->image) }}" class="w-8 h-8 object-contain opacity-60">
                            @else
                                <svg class="w-6 h-6 sm:w-7 sm:h-7 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                                </svg>
                            @endif
                        </div>
                        <span class="bg-gray-100 text-gray-600 text-xs font-bold px-2.5 py-1 rounded-lg">
                            {{ $category->products_count ?? 0 }}
                        </span>
                    </div>
                    
                    <div class="flex-1">
                        <h3 class="font-bold text-lg text-black mb-1 line-clamp-1" title="{{ $category->name }}">
                            {{ $category->name }}
                        </h3>
                        <p class="text-xs text-gray-400 mb-4 line-clamp-2 min-h-[2.5em]">
                            {{ $category->description ?? 'No description available.' }}
                        </p>
                    </div>
                    
                    <div class="flex items-center gap-2 mt-auto pt-4 border-t border-gray-50">
                        <a href="{{ route('admin.categories.edit', $category) }}" class="flex-1 py-2 bg-black text-white text-xs sm:text-sm font-semibold rounded-xl hover:bg-gray-800 text-center transition-colors">
                            Edit
                        </a>
                        
                        <x-modal-confirm 
                            :action="route('admin.categories.destroy', $category)"
                            title="Delete Category?"
                            message="Are you sure you want to delete {{ $category->name }}?"
                            confirm-text="Delete"
                        >
                            <x-slot name="trigger">
                                <button type="button" class="p-2 text-red-500 hover:bg-red-50 rounded-xl border border-transparent hover:border-red-100 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </x-slot>
                        </x-modal-confirm>
                    </div>
                </div>
            @empty
                <div class="col-span-full flex flex-col items-center justify-center py-16 bg-white rounded-3xl border border-gray-100 border-dashed">
                    <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"/>
                        </svg>
                    </div>
                    <p class="text-gray-500 font-medium mb-1">No categories found</p>
                    <p class="text-xs text-gray-400 mb-6">Try adjusting your search or create a new one.</p>
                    
                    <a href="{{ route('admin.categories.create') }}" class="px-6 py-2.5 bg-black text-white text-sm font-semibold rounded-full hover:bg-gray-800 transition-shadow shadow-md hover:shadow-lg">
                        Create First Category
                    </a>
                </div>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $categories->links('vendor.pagination.custom') }}
        </div>

    </main>

</x-app-layout>