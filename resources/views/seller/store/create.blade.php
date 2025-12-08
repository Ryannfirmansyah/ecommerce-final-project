<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Setup Your Store
        </h2>
    </x-slot>

    <div class="min-h-screen bg-gray-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8">

        <div class="sm:mx-auto sm:w-full sm:max-w-md text-center mb-8">
            <div class="mx-auto h-16 w-16 bg-neutral-900 rounded-2xl flex items-center justify-center shadow-lg transform rotate-3 mb-4">
                <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
            </div>
            <h2 class="text-3xl font-extrabold text-gray-900">Setup Your Store</h2>
            <p class="mt-2 text-sm text-gray-600">
                Let's get your business up and running.
            </p>
        </div>

        <div class="sm:mx-auto sm:w-full sm:max-w-[600px]">
            <div class="bg-white py-8 px-4 shadow-xl shadow-gray-200/50 sm:rounded-3xl sm:px-10 border border-gray-100">

                <form method="POST" action="{{ route('seller.store.store') }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <div>
                        <x-input-label for="name" :value="__('Store Name')" class="text-gray-700 font-bold mb-1" />
                        <div class="relative rounded-xl shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                            </div>
                            <input id="name" type="text" name="name" :value="old('name')" required autofocus
                                class="block w-full pl-10 pr-3 py-3 border-gray-300 rounded-xl focus:ring-black focus:border-black placeholder-gray-400 transition sm:text-sm"
                                placeholder="e.g. My Awesome Shop" />
                        </div>
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="description" :value="__('About Your Store')" class="text-gray-700 font-bold mb-1" />
                        <textarea id="description" name="description" rows="4"
                                class="block w-full border-gray-300 rounded-xl focus:ring-black focus:border-black placeholder-gray-400 transition sm:text-sm"
                                placeholder="Tell customers what you sell and your story...">{{ old('description') }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="image" :value="__('Store Logo / Branding')" class="text-gray-700 font-bold mb-1" />

                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-2xl hover:bg-gray-50 transition group cursor-pointer relative">
                            <div class="space-y-1 text-center">
                                <div class="mx-auto h-12 w-12 text-gray-400 group-hover:text-black transition">
                                    <svg class="h-12 w-12" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </div>
                                <div class="flex text-sm text-gray-600 justify-center">
                                    <label for="image" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none">
                                        <span class="text-black underline decoration-2 decoration-black/20 hover:decoration-black">Upload a file</span>
                                        <input id="image" name="image" type="file" class="sr-only" accept="image/*">
                                    </label>
                                    <p class="pl-1">or drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500">
                                    PNG, JPG, GIF up to 2MB
                                </p>
                            </div>
                        </div>
                        <x-input-error :messages="$errors->get('image')" class="mt-2" />
                    </div>

                    <div class="relative py-2">
                        <div class="absolute inset-0 flex items-center" aria-hidden="true">
                            <div class="w-full border-t border-gray-200"></div>
                        </div>
                    </div>

                    <div>
                        <button type="submit" class="w-full flex justify-center py-3.5 px-4 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-neutral-900 hover:bg-black focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black transition transform hover:-translate-y-0.5">
                            Launch My Store
                        </button>
                        <p class="mt-4 text-center text-xs text-gray-500">
                            By creating a store, you agree to our <a href="#" class="underline">Terms of Service</a>.
                        </p>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>