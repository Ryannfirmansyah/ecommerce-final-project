
<x-default-layout>
    <div class="min-h-screen flex font-['Poppins']">

        <div class="w-full lg:w-1/2 flex flex-col justify-center px-8 sm:px-12 lg:px-24 py-12 bg-white">

            <div class="lg:hidden mb-8">
                <a href="{{route('home')}}" class="flex items-center gap-2">
                    <div class="w-10 h-10 bg-black rounded-full flex items-center justify-center text-white font-bold text-xl">N</div>
                    <span class="text-xl font-bold tracking-tight">NexusPlace</span>
                </a>
            </div>

            <div class="max-w-md w-full mx-auto">
                <div class="mb-10">
                    <h2 class="text-4xl font-bold text-gray-900 mb-3">Welcome back</h2>
                    <p class="text-gray-500">Welcome back! Please enter your details.</p>
                </div>

                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                        <input id="email" type="email" name="email" :value="old('email')" required autofocus
                            class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-200 focus:border-black focus:ring-black focus:bg-white transition-all duration-200"
                            placeholder="Enter your email">
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div x-data="{ show: false }">
                        <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                        <div class="relative">
                            <input id="password" :type="show ? 'text' : 'password'" name="password" required autocomplete="current-password"
                                class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-200 focus:border-black focus:ring-black focus:bg-white transition-all duration-200 pr-10"
                                placeholder="••••••••">

                            <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-black transition-colors">
                                <svg x-show="!show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                <svg x-show="show" style="display: none;" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" /></svg>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-between">
                        <label for="remember_me" class="inline-flex items-center">
                            <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-black shadow-sm focus:ring-black" name="remember">
                            <span class="ml-2 text-sm text-gray-600">{{ __('Remember for 30 days') }}</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a class="text-sm font-semibold text-black hover:underline underline-offset-4" href="{{ route('password.request') }}">
                                {{ __('Forgot password') }}
                            </a>
                        @endif
                    </div>

                    <button type="submit" class="w-full py-3.5 px-4 bg-black hover:bg-gray-800 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black">
                        Sign in
                    </button>
                </form>

                <div class="mt-8 text-center">
                    <p class="text-sm text-gray-500">
                        Don't have an account?
                        <a href="{{ route('register') }}" class="font-bold text-black hover:underline">Sign up for free</a>
                    </p>
                </div>
            </div>
        </div>

        <div class="hidden lg:block lg:w-1/2 relative bg-black overflow-hidden">
            <img src="{{asset('storage/hero/ultraman-nexus.jpg')}}"
                 alt="Interior Design"
                 class="absolute inset-0 w-full h-full object-cover opacity-60">

            <div class="relative z-10 flex flex-col justify-between h-full p-16 text-white">
                <a href="{{route('home')}}" class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-black font-bold text-xl">N</div>
                    <span class="text-xl font-bold tracking-tight">NexusPlace</span>
                </a>

                <div class="max-w-lg">
                    <h3 class="text-4xl font-serif font-bold leading-tight mb-4">
                        "Design is not just what it looks like and feels like. Design is how it works."
                    </h3>
                    <div class="flex items-center gap-4 mt-8">
                        <div class="flex -space-x-4">
                            <img class="w-10 h-10 rounded-full border-2 border-white" src="https://ui-avatars.com/api/?name=Alex&background=random" alt="">
                            <img class="w-10 h-10 rounded-full border-2 border-white" src="https://ui-avatars.com/api/?name=Sarah&background=random" alt="">
                            <img class="w-10 h-10 rounded-full border-2 border-white" src="https://ui-avatars.com/api/?name=John&background=random" alt="">
                        </div>
                        <div class="text-sm font-medium">
                            <span class="block">Join 10k+ users</span>
                            <span class="text-gray-300">Start selling & buying today.</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-default-layout>