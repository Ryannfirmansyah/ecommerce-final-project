<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Write a Review
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            @if (session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Product Info -->
                    <div class="flex items-center mb-6 pb-6 border-b border-gray-200">
                        @if($orderItem->product->image)
                            <img src="{{ asset('storage/' . $orderItem->product->image) }}" alt="{{ $orderItem->product->name }}" class="w-20 h-20 rounded object-cover">
                        @else
                            <div class="w-20 h-20 bg-gray-200 rounded"></div>
                        @endif
                        <div class="ml-4">
                            <h3 class="font-semibold text-gray-900">{{ $orderItem->product->name }}</h3>
                            <p class="text-sm text-gray-600">{{ $orderItem->product->category->name }}</p>
                            <p class="text-sm text-gray-600">by {{ $orderItem->product->store->name }}</p>
                        </div>
                    </div>

                    <!-- Review Form -->
                    <form method="POST" action="{{ route('buyer.orders.submit-review', [$order, $orderItem->product_id]) }}">
                        @csrf

                        <!-- Rating -->
                        <div>
                            <x-input-label for="rating" :value="__('Rating')" />
                            <div class="flex items-center space-x-2 mt-2">
                                @for($i = 1; $i <= 5; $i++)
                                    <label class="cursor-pointer">
                                        <input type="radio" name="rating" value="{{ $i }}" class="sr-only peer" {{ old('rating') == $i ? 'checked' : '' }} required>
                                        <svg class="w-8 h-8 text-gray-300 peer-checked:text-yellow-400 hover:text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                    </label>
                                @endfor
                            </div>
                            <x-input-error :messages="$errors->get('rating')" class="mt-2" />
                        </div>

                        <!-- Comment -->
                        <div class="mt-4">
                            <x-input-label for="comment" :value="__('Comment (Optional)')" />
                            <textarea id="comment" name="comment" rows="4" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" placeholder="Share your experience with this product...">{{ old('comment') }}</textarea>
                            <x-input-error :messages="$errors->get('comment')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-6 space-x-3">
                            <a href="{{ route('buyer.orders.show', $order) }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400">
                                Cancel
                            </a>
                            <x-primary-button>
                                Submit Review
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>