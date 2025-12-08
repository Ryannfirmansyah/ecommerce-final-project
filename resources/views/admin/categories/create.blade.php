<x-app-layout>
    <header class="bg-white border-b border-gray-200 px-4 py-3 sm:px-6 lg:px-8 md:py-4">
        <div class="flex flex-wrap items-center gap-2 text-xs sm:text-sm text-gray-500 mb-1 sm:mb-2">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-black">Dashboard</a>
            <span>›</span>
            <a href="{{ route('admin.categories.index') }}" class="hover:text-black">Categories</a>
            <span>›</span>
            <span class="text-black font-semibold">Add</span>
        </div>
        <h2 class="font-bold text-xl sm:text-2xl text-black">Add New Category</h2>
    </header>

    <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8 bg-gray-50">
        
        <div class="max-w-2xl mx-auto">
            <div class="bg-white rounded-2xl p-5 sm:p-8 border border-gray-200 shadow-lg">
                
                <form method="POST" action="{{ route('admin.categories.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-5 sm:mb-6">
                        <label class="block text-sm font-semibold text-black mb-2">Category Name</label>
                        <input type="text" name="name" value="{{ old('name') }}" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:border-black transition-colors text-sm sm:text-base" placeholder="Enter category name" required autofocus>
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div class="mb-6 sm:mb-8">
                        <label class="block text-sm font-semibold text-black mb-2">Description (Optional)</label>
                        <textarea name="description" rows="4" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:border-black transition-colors text-sm sm:text-base" placeholder="Enter category description">{{ old('description') }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    <div class="mb-6 sm:mb-8">
                        <label class="block text-sm font-semibold text-black mb-2">Image (Optional)</label>
                        
                        <label class="block">
                            <span class="sr-only">Choose profile photo</span>
                            <input type="file" name="image" accept="image/*" class="block w-full text-sm text-gray-500
                            file:mr-4 file:py-2.5 file:px-4 sm:file:py-3 sm:file:px-6
                            file:rounded-2xl file:border-0
                            file:text-xs sm:file:text-sm file:font-bold
                            file:bg-black file:text-white
                            hover:file:bg-gray-800
                            cursor-pointer focus:outline-none
                            "/>
                        </label>
                        <p class="mt-2 text-xs text-gray-500">PNG, JPG, or GIF (MAX. 2MB).</p>
                        <x-input-error :messages="$errors->get('image')" class="mt-2" />
                    </div>

                    <div class="flex flex-col-reverse sm:flex-row items-center gap-3 sm:gap-4">
                        
                        <a href="{{ route('admin.categories.index') }}" class="w-full sm:w-auto px-6 py-3 text-gray-500 font-semibold hover:text-black transition-colors text-center rounded-2xl hover:bg-gray-50">
                            Cancel
                        </a>

                        <button type="submit" class="w-full sm:flex-1 px-6 py-3 bg-black text-white font-semibold rounded-2xl hover:bg-gray-800 transition-all shadow-md hover:shadow-lg">
                            Create Category
                        </button>
                    </div>
                </form>

            </div>
        </div>

    </main>
</x-app-layout>