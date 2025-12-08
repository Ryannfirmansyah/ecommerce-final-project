<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Store
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

            <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-8 gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Store Settings</h2>
                    <p class="text-sm text-gray-500">Manage your store profile and branding.</p>
                </div>
                @if (session('success'))
                    <div x-data="{ show: true }" x-show="show" class="flex items-center gap-2 bg-green-50 text-green-700 px-4 py-2 rounded-xl border border-green-200 text-sm shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>{{ session('success') }}</span>
                        <button @click="show = false" class="ml-2 text-green-500 hover:text-green-800">&times;</button>
                    </div>
                @endif
            </div>

            <form method="POST" action="{{ route('seller.store.update') }}" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                @csrf
                @method('PUT')

                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
                        <h3 class="text-lg font-bold text-gray-900 mb-6 border-b border-gray-100 pb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                            Store Information
                        </h3>

                        <div class="space-y-6">
                            <div>
                                <x-input-label for="name" :value="__('Store Name')" class="text-gray-700 font-bold mb-1" />
                                <x-text-input id="name" class="block w-full rounded-xl border-gray-300 focus:border-black focus:ring-black transition py-3"
                                            type="text" name="name" :value="old('name', $store->name)" required autofocus />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="description" :value="__('Store Description')" class="text-gray-700 font-bold mb-1" />
                                <textarea id="description" name="description" rows="5"
                                        class="block w-full p-2 rounded-xl border-gray-300 focus:border-black focus:ring-black transition shadow-sm"
                                        placeholder="Tell your customers about your shop...">{{ old('description', $store->description) }}</textarea>
                                <x-input-error :messages="$errors->get('description')" class="mt-2" />
                                <p class="text-xs text-gray-400 mt-2 text-right">Keep it short and catchy.</p>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-4">
                        <a href="{{ route('seller.dashboard') }}" class="px-5 py-3 bg-white border border-gray-300 rounded-xl text-sm font-bold text-gray-700 hover:bg-gray-50 transition shadow-sm">
                            Cancel
                        </a>
                        <button type="submit" class="px-6 py-3 bg-neutral-900 hover:bg-black text-white text-sm font-bold rounded-xl shadow-lg hover:shadow-xl transition transform hover:-translate-y-0.5">
                            Save Changes
                        </button>
                    </div>
                </div>

                <div class="lg:col-span-1">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sticky top-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-6 border-b border-gray-100 pb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            Store Branding
                        </h3>

                        <div class="space-y-6">
                            <div class="flex flex-col items-center">
                                <div class="w-32 h-32 rounded-full border-4 border-gray-50 shadow-md overflow-hidden relative group">
                                    @if($store->image)
                                        <img src="{{ Storage::url($store->image) }}" alt="{{ $store->name }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full bg-gray-100 flex items-center justify-center text-gray-400">
                                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        </div>
                                    @endif
                                </div>
                                <p class="text-xs text-gray-400 mt-3 font-medium uppercase tracking-wider">Current Logo</p>
                            </div>

                            <div>
                                <x-input-label for="image" :value="__('Update Logo')" class="text-gray-700 font-bold mb-1" />

                                <input id="image" type="file" name="image" accept="image/*"
                                    class="block w-full text-sm text-gray-500
                                    file:mr-4 file:py-2.5 file:px-4
                                    file:rounded-xl file:border-0
                                    file:text-sm file:font-bold
                                    file:bg-black file:text-white
                                    hover:file:bg-gray-800
                                    cursor-pointer bg-gray-50 rounded-xl" />

                                <p class="mt-2 text-xs text-gray-500">
                                    Recommended size: 500x500px. <br> Max file size: 2MB (JPG, PNG).
                                </p>
                                <x-input-error :messages="$errors->get('image')" class="mt-2" />
                            </div>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>
</x-app-layout>