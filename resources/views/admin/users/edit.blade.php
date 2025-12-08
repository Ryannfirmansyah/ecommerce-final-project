<x-app-layout>
    <header class="bg-white border-b border-gray-200 px-4 py-3 sm:px-6 lg:px-8 md:py-4 shadow-sm">
        <div class="flex items-center justify-between">
            <div>
                <div class="flex flex-wrap items-center gap-2 text-xs sm:text-sm text-gray-500 mb-1 sm:mb-2">
                    <a href="{{ route('admin.dashboard') }}" class="hover:text-black">Dashboard</a>
                    <span>›</span>
                    <a href="{{ route('admin.users.index') }}" class="hover:text-black">Users</a>
                    <span>›</span>
                    <span class="text-black font-semibold">Edit</span>
                </div>
                <h2 class="font-bold text-xl sm:text-2xl text-black">Edit User</h2>
            </div>
        </div>
    </header>

    <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8 bg-gray-50">

        <div class="max-w-2xl mx-auto">
            <div class="bg-white rounded-2xl p-5 sm:p-8 border border-gray-200 shadow-lg">

                <form method="POST" action="{{ route('admin.users.update', $user) }}">
                    @csrf
                    @method('PUT')

                    <div class="flex justify-center mb-6 sm:mb-8">
                        <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-full bg-gray-200 flex items-center justify-center text-black font-bold text-2xl sm:text-3xl">
                            {{ substr($user->name, 0, 1) }}
                        </div>
                    </div>

                    <div class="mb-5 sm:mb-6">
                        <label class="block text-sm font-semibold text-black mb-2">Full Name</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:border-black transition-colors text-sm sm:text-base" required>
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div class="mb-5 sm:mb-6">
                        <label class="block text-sm font-semibold text-black mb-2">Email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:border-black transition-colors text-sm sm:text-base" required>
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    @if($user->role === 'seller')
                    <div class="mb-6 sm:mb-8">
                        <label class="block text-sm font-semibold text-black mb-2">Seller Status</label>
                        <div class="relative">
                            <select name="seller_status" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:border-black transition-colors appearance-none text-sm sm:text-base">
                                <option value="pending" {{ $user->seller_status === 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="approved" {{ $user->seller_status === 'approved' ? 'selected' : '' }}>Approved</option>
                                <option value="rejected" {{ $user->seller_status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                            </select>
                        </div>
                    </div>
                    @endif

                    <div class="flex flex-col-reverse sm:flex-row items-center gap-3 sm:gap-4 mt-8">

                        <a href="{{ route('admin.users.index') }}" class="w-full sm:w-auto px-6 py-3 text-gray-500 font-semibold hover:text-black transition-colors text-center rounded-2xl hover:bg-gray-50">
                            Cancel
                        </a>

                        <button type="submit" class="w-full sm:flex-1 px-6 py-3 bg-black text-white font-semibold rounded-2xl hover:bg-gray-800 transition-all shadow-md hover:shadow-lg">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>
</x-app-layout>