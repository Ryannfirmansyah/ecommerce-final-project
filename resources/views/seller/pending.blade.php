<x-default-layout>
    <div class="min-h-screen flex items-center justify-center p-4 font-['Poppins']">

        <div class="max-w-md w-full bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">

            <div class="h-32 bg-cover bg-center relative" style="background-image: url('https://images.unsplash.com/photo-1497366216548-37526070297c?auto=format&fit=crop&q=80&w=1000');">
                <div class="absolute inset-0 bg-black/40 backdrop-blur-[2px]"></div>

                <div class="absolute top-6 left-6 flex items-center gap-2">
                    <div class="w-8 h-8 bg-white rounded-full flex items-center justify-center text-black font-bold text-lg">N</div>
                    <span class="text-white font-bold text-lg">NexusPlace</span>
                </div>
            </div>

            <div class="px-8 pb-8 -mt-12 relative z-10 text-center">

                @if(auth()->user()->seller_status === 'pending')

                    <div class="w-24 h-24 bg-white rounded-full mx-auto shadow-lg flex items-center justify-center mb-6">
                        <div class="w-20 h-20 bg-yellow-50 rounded-full flex items-center justify-center animate-pulse">
                            <svg class="w-10 h-10 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>

                    <h2 class="text-2xl font-bold text-gray-900 mb-2">Review in Progress</h2>
                    <p class="text-gray-500 text-sm leading-relaxed mb-6">
                        Thanks for signing up, <span class="font-semibold text-black">{{ auth()->user()->name }}</span>! <br>
                        We are currently reviewing your seller application. This process usually takes 24-48 hours.
                    </p>

                    <div class="bg-yellow-50 rounded-xl p-4 text-left border border-yellow-100 mb-8">
                        <p class="text-xs font-bold text-yellow-800 uppercase tracking-wider mb-2">Application Details</p>
                        <div class="flex justify-between text-sm mb-1">
                            <span class="text-gray-500">Email:</span>
                            <span class="font-medium text-gray-900">{{ auth()->user()->email }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Status:</span>
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-200 text-yellow-800">
                                Pending Verification
                            </span>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full py-3 bg-black hover:bg-gray-800 text-white font-bold rounded-xl transition shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                            Sign Out & Wait
                        </button>
                    </form>

                @elseif(auth()->user()->seller_status === 'rejected')

                    <div class="w-24 h-24 bg-white rounded-full mx-auto shadow-lg flex items-center justify-center mb-6">
                        <div class="w-20 h-20 bg-red-50 rounded-full flex items-center justify-center">
                            <svg class="w-10 h-10 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </div>
                    </div>

                    <h2 class="text-2xl font-bold text-gray-900 mb-2">Application Rejected</h2>
                    <p class="text-gray-500 text-sm leading-relaxed mb-8">
                        We're sorry, but your application to become a seller has been declined by our administrators.
                    </p>

                    <div class="space-y-3">
                        <form method="POST" action="{{ route('seller.delete-account') }}" onsubmit="return confirm('Are you sure you want to delete your account?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full py-3 bg-red-600 hover:bg-red-700 text-white font-bold rounded-xl transition shadow-md">
                                Delete Account
                            </button>
                        </form>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full py-3 bg-white border border-gray-200 text-gray-700 font-bold rounded-xl hover:bg-gray-50 transition">
                                Sign Out
                            </button>
                        </form>
                    </div>

                @endif

            </div>
        </div>

        <div class="absolute bottom-6 text-center w-full">
            <p class="text-xs text-gray-400">© {{ date('Y') }} NexusPlace Inc. All rights reserved.</p>
        </div>

    </div>
</x-default-layout>