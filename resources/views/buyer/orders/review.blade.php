<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Review Product
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <!-- Product Info -->
                    <div class="mb-6 flex items-center gap-4 pb-6 border-b">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" 
                                 alt="{{ $product->name }}" 
                                 class="h-20 w-20 rounded object-cover">
                        @endif
                        <div>
                            <h3 class="text-lg font-semibold">{{ $product->name }}</h3>
                            <p class="text-sm text-gray-600">Order #{{ $order->id }}</p>
                        </div>
                    </div>

                    <!-- Review Form -->
                    <form action="{{ route('buyer.orders.review.submit', ['order' => $order, 'product' => $product]) }}" 
                          method="POST">
                        @csrf
                        
                        <!-- Rating Section - FIXED BUG #3 -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-3">
                                Rating <span class="text-red-500">*</span>
                            </label>
                            
                            <div class="flex items-center gap-2" id="star-rating">
                                @for($i = 5; $i >= 1; $i--)
                                    <label class="cursor-pointer star-label">
                                        <input type="radio" 
                                               name="rating" 
                                               value="{{ $i }}" 
                                               class="sr-only star-input"
                                               onchange="updateStars({{ $i }})"
                                               required>
                                        <svg class="w-8 h-8 text-gray-300 transition-colors duration-200 star-icon" 
                                             data-star="{{ $i }}"
                                             fill="currentColor" 
                                             viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    </label>
                                @endfor
                            </div>
                            <p class="mt-2 text-xs text-gray-500">Klik bintang untuk memberikan rating (1-5)</p>
                            
                            @error('rating')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Comment Section -->
                        <div class="mb-6">
                            <label for="comment" class="block text-sm font-medium text-gray-700 mb-2">
                                Review / Komentar <span class="text-red-500">*</span>
                            </label>
                            <textarea name="comment" 
                                      id="comment" 
                                      rows="5" 
                                      class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                      placeholder="Bagikan pengalaman Anda tentang produk ini..."
                                      required>{{ old('comment') }}</textarea>
                            <p class="mt-1 text-xs text-gray-500">Minimal 10 karakter</p>
                            
                            @error('comment')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex gap-4">
                            <button type="submit" 
                                    class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded transition">
                                Submit Review
                            </button>
                            <a href="{{ route('buyer.orders.show', $order) }}" 
                               class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-2 px-6 rounded transition">
                                Cancel
                            </a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <!-- FIXED BUG #3: JavaScript for Star Rating Visual Feedback -->
    <script>
        let selectedRating = 0;

        function updateStars(rating) {
            selectedRating = rating;
            const stars = document.querySelectorAll('.star-icon');
            
            stars.forEach((star, index) => {
                const starValue = parseInt(star.getAttribute('data-star'));
                
                if (starValue <= rating) {
                    // Selected stars: yellow/gold
                    star.classList.remove('text-gray-300');
                    star.classList.add('text-yellow-400');
                } else {
                    // Unselected stars: gray
                    star.classList.remove('text-yellow-400');
                    star.classList.add('text-gray-300');
                }
            });
        }

        // Hover effect (optional but nice UX)
        document.querySelectorAll('.star-label').forEach((label) => {
            label.addEventListener('mouseenter', function() {
                const input = this.querySelector('input');
                const value = parseInt(input.value);
                previewStars(value);
            });
        });

        document.getElementById('star-rating').addEventListener('mouseleave', function() {
            if (selectedRating > 0) {
                updateStars(selectedRating);
            } else {
                resetStars();
            }
        });

        function previewStars(rating) {
            const stars = document.querySelectorAll('.star-icon');
            stars.forEach((star) => {
                const starValue = parseInt(star.getAttribute('data-star'));
                if (starValue <= rating) {
                    star.classList.remove('text-gray-300');
                    star.classList.add('text-yellow-400');
                } else {
                    star.classList.remove('text-yellow-400');
                    star.classList.add('text-gray-300');
                }
            });
        }

        function resetStars() {
            const stars = document.querySelectorAll('.star-icon');
            stars.forEach((star) => {
                star.classList.remove('text-yellow-400');
                star.classList.add('text-gray-300');
            });
        }
    </script>
</x-app-layout>