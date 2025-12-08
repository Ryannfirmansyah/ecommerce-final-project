<x-default-layout>
    <div class="min-h-screen flex font-['Poppins']">
        <div class="hidden lg:block lg:w-1/2 relative bg-gray-900 overflow-hidden">
            <img src="https://images.unsplash.com/photo-1441986300917-64674bd600d8?q=80&w=2670&auto=format&fit=crop"
                alt="Store Interior"
                class="absolute inset-0 w-full h-full object-cover opacity-50">

            <div class="relative z-10 flex flex-col justify-between h-full p-16 text-white">
                <a href="{{route('home')}}" class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-black font-bold text-xl">N</div>
                    <span class="text-xl font-bold tracking-tight">NexusPlace</span>
                </a>

                <div class="max-w-lg mb-12">
                    <h3 class="text-4xl font-serif font-bold leading-tight mb-4">
                        "Join the marketplace where quality meets convenience."
                    </h3>
                    <p class="text-lg text-gray-300">
                        Whether you are buying your dream furniture or selling your best creations, NexusPlace is your home.
                    </p>
                </div>
            </div>
        </div>

        <div class="w-full lg:w-1/2 flex flex-col justify-center px-8 sm:px-12 lg:px-24 py-12 bg-white">

            <div class="lg:hidden mb-8">
                <a href="/" class="flex items-center gap-2">
                    <div class="w-10 h-10 bg-black rounded-full flex items-center justify-center text-white font-bold text-xl">N</div>
                    <span class="text-xl font-bold tracking-tight">NexusPlace</span>
                </a>
            </div>

            <div class="max-w-md w-full mx-auto">
                <div class="mb-8">
                    <h2 class="text-3xl font-bold text-gray-900 mb-2">Create an account</h2>
                    <p class="text-gray-500 text-sm">Join NexusPlace to start buying and selling today.</p>
                </div>

                <form method="POST" action="{{ route('register') }}" class="space-y-5">
                    @csrf

                    <div>
                        <label for="name" class="block text-sm font-semibold text-gray-700 mb-1.5">Full Name</label>
                        <input id="name" type="text" name="name" :value="old('name')" required autofocus autocomplete="name"
                            class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-200 focus:border-black focus:ring-black focus:bg-white transition-all duration-200"
                            placeholder="John Doe">
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-1.5">Email</label>
                        <input id="email" type="email" name="email" :value="old('email')" required autocomplete="username"
                            class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-200 focus:border-black focus:ring-black focus:bg-white transition-all duration-200"
                            placeholder="name@example.com">
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-3">I want to join as</label>

                        <div class="grid grid-cols-2 gap-4" x-data="{ role: '{{ old('role', 'buyer') }}' }">

                            <label class="cursor-pointer relative">
                                <input type="radio" name="role" value="buyer" class="peer sr-only" x-model="role">
                                <div class="p-4 rounded-xl border-2 transition-all duration-200 text-center
                                            peer-checked:border-black peer-checked:bg-black peer-checked:text-white
                                            border-gray-200 bg-white hover:border-gray-300 text-gray-600">
                                    <div class="flex flex-col items-center gap-2">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                                        <span class="font-bold text-sm">Buyer</span>
                                    </div>
                                </div>
                            </label>

                            <label class="cursor-pointer relative">
                                <input type="radio" name="role" value="seller" class="peer sr-only" x-model="role">
                                <div class="p-4 rounded-xl border-2 transition-all duration-200 text-center
                                            peer-checked:border-black peer-checked:bg-black peer-checked:text-white
                                            border-gray-200 bg-white hover:border-gray-300 text-gray-600">
                                    <div class="flex flex-col items-center gap-2">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                        <span class="font-bold text-sm">Seller</span>
                                    </div>
                                </div>
                            </label>

                            <div x-show="role === 'seller'"
                                x-transition:enter="transition ease-out duration-300"
                                x-transition:enter-start="opacity-0 -translate-y-2"
                                x-transition:enter-end="opacity-100 translate-y-0"
                                class="col-span-2 mt-1 flex items-start gap-3 p-3 bg-blue-50 border border-blue-100 rounded-xl text-blue-800 text-xs leading-relaxed">
                                <svg class="w-5 h-5 text-blue-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <p>
                                    <strong>Seller Account:</strong> Requires admin approval. You cannot set up your store until your account is verified.
                                </p>
                            </div>

                        </div>
                        <x-input-error :messages="$errors->get('role')" class="mt-2" />
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div x-data="{ show: false }">
                            <label for="password" class="block text-sm font-semibold text-gray-700 mb-1.5">Password</label>
                            <div class="relative">
                                <input id="password" :type="show ? 'text' : 'password'" name="password" required autocomplete="new-password"
                                    class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-200 focus:border-black focus:ring-black focus:bg-white transition-all duration-200 pr-10"
                                    placeholder="••••••••">
                                <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-black">
                                    <svg x-show="!show" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                    <svg x-show="show" style="display: none;" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" /></svg>
                                </button>
                            </div>
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-1.5">Confirm</label>
                            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                                class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-200 focus:border-black focus:ring-black focus:bg-white transition-all duration-200"
                                placeholder="••••••••">
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                        </div>
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="w-full py-3.5 px-4 bg-black hover:bg-gray-800 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black">
                            Create Account
                        </button>
                    </div>

                    <p class="text-center text-sm text-gray-600">
                        Already have an account?
                        <a href="{{ route('login') }}" class="font-bold text-black hover:underline">Log in</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</x-default-layout>