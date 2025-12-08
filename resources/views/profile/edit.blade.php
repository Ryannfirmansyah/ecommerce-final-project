<x-app-layout>
    <header class="bg-white border-b border-gray-200 px-4 py-3 sm:px-6 lg:px-8 md:py-4 shadow-sm sticky top-0 z-30">
        <div class="flex items-center gap-2 text-xs sm:text-sm text-gray-500 mb-1 sm:mb-2">
            <a href="{{ route('dashboard') }}" class="hover:text-black">Dashboard</a>
            <span>›</span>
            <span class="text-black font-semibold">Settings</span>
        </div>
        <h2 class="font-bold text-xl sm:text-2xl text-black">Account Settings</h2>
    </header>

    <main class="flex-1 bg-gray-50 p-4 sm:p-8 lg:p-12 overflow-y-auto">
        <div class="max-w-7xl mx-auto">
            
            <div class="flex flex-col lg:flex-row gap-8" x-data="{ activeTab: 'profile' }">
                
                <aside class="w-full lg:w-72 shrink-0 lg:sticky lg:top-24 self-start space-y-1">
                    <p class="px-4 text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Account</p>
                    
                    <button @click="activeTab = 'profile'" 
                        :class="activeTab === 'profile' ? 'bg-white shadow-sm text-black ring-1 ring-black/5 font-semibold' : 'text-gray-500 hover:bg-gray-100 hover:text-gray-900'"
                        class="w-full flex items-center gap-3 px-4 py-3 rounded-xl transition-all text-sm text-left">
                        <svg class="w-5 h-5" :class="activeTab === 'profile' ? 'text-black' : 'text-gray-400'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        Public Profile
                    </button>

                    <button @click="activeTab = 'password'" 
                        :class="activeTab === 'password' ? 'bg-white shadow-sm text-black ring-1 ring-black/5 font-semibold' : 'text-gray-500 hover:bg-gray-100 hover:text-gray-900'"
                        class="w-full flex items-center gap-3 px-4 py-3 rounded-xl transition-all text-sm text-left">
                        <svg class="w-5 h-5" :class="activeTab === 'password' ? 'text-black' : 'text-gray-400'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        Security & Password
                    </button>

                    <div class="pt-4 mt-4 border-t border-gray-200">
                        <p class="px-4 text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Danger Zone</p>
                        <button @click="activeTab = 'danger'" 
                            :class="activeTab === 'danger' ? 'bg-red-50 text-red-600 ring-1 ring-red-100 font-semibold' : 'text-gray-500 hover:bg-red-50 hover:text-red-600'"
                            class="w-full flex items-center gap-3 px-4 py-3 rounded-xl transition-all text-sm text-left">
                            <svg class="w-5 h-5" :class="activeTab === 'danger' ? 'text-red-500' : 'text-gray-400'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            Delete Account
                        </button>
                    </div>
                </aside>

                <div class="flex-1 min-w-0">

                    <div x-show="activeTab === 'profile'" 
                         x-transition:enter="transition ease-out duration-300 transform" 
                         x-transition:enter-start="opacity-0 translate-x-4" 
                         x-transition:enter-end="opacity-100 translate-x-0">
                        
                        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                            <div class="p-6 sm:p-8 border-b border-gray-100">
                                <h3 class="text-lg font-bold text-gray-900">Profile Information</h3>
                                <p class="text-sm text-gray-500 mt-1">Update your account's profile information and email address.</p>
                            </div>
                            
                            <div class="p-6 sm:p-8">
                                <div class="flex items-center gap-6 mb-8">
                                    <div class="w-20 h-20 rounded-full bg-gray-900 text-white flex items-center justify-center text-2xl font-bold shadow-md">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-gray-900 text-lg">{{ $user->name }}</h4>
                                        <p class="text-sm text-gray-500">{{ $user->email }}</p>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 mt-2 capitalize">
                                            {{ $user->role }}
                                        </span>
                                    </div>
                                </div>

                                <form id="send-verification" method="post" action="{{ route('verification.send') }}">@csrf</form>

                                <form method="post" action="{{ route('profile.update') }}" class="space-y-6 max-w-xl">
                                    @csrf
                                    @method('patch')

                                    <div>
                                        <x-input-label for="name" :value="__('Display Name')" class="text-gray-700 font-semibold mb-2" />
                                        <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name"
                                            class="w-full rounded-xl border-gray-300 focus:border-black focus:ring-black transition py-2.5 bg-gray-50 focus:bg-white" />
                                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                                    </div>

                                    <div>
                                        <x-input-label for="email" :value="__('Email Address')" class="text-gray-700 font-semibold mb-2" />
                                        <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required autocomplete="username"
                                            class="w-full rounded-xl border-gray-300 focus:border-black focus:ring-black transition py-2.5 bg-gray-50 focus:bg-white" />
                                        <x-input-error class="mt-2" :messages="$errors->get('email')" />

                                        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                                            <div class="mt-3 p-4 bg-yellow-50 rounded-xl text-sm text-yellow-800 border border-yellow-100 flex items-start gap-3">
                                                <svg class="w-5 h-5 text-yellow-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                                <div>
                                                    <p class="font-medium">Your email is unverified.</p>
                                                    <button form="send-verification" class="underline hover:text-black mt-1">Click here to re-send the verification email.</button>
                                                </div>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="flex items-center gap-4 pt-4">
                                        <button type="submit" class="px-6 py-2.5 bg-black text-white font-bold rounded-xl hover:bg-gray-800 transition shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                            Save Changes
                                        </button>
                                        @if (session('status') === 'profile-updated')
                                            <span x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-green-600 font-medium flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                                Saved.
                                            </span>
                                        @endif
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div x-show="activeTab === 'password'" style="display: none;" 
                         x-transition:enter="transition ease-out duration-300 transform" 
                         x-transition:enter-start="opacity-0 translate-x-4" 
                         x-transition:enter-end="opacity-100 translate-x-0">
                        
                        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                            <div class="p-6 sm:p-8 border-b border-gray-100">
                                <h3 class="text-lg font-bold text-gray-900">Change Password</h3>
                                <p class="text-sm text-gray-500 mt-1">Ensure your account is using a long, random password to stay secure.</p>
                            </div>

                            <div class="p-6 sm:p-8">
                                <form method="post" action="{{ route('password.update') }}" class="space-y-6 max-w-xl">
                                    @csrf
                                    @method('put')

                                    <div x-data="{ show: false }">
                                        <x-input-label for="current_password" :value="__('Current Password')" class="text-gray-700 font-semibold mb-2" />
                                        <div class="relative">
                                            <input id="current_password" name="current_password" :type="show ? 'text' : 'password'" autocomplete="current-password"
                                                class="w-full rounded-xl border-gray-300 focus:border-black focus:ring-black transition py-2.5 pr-10 bg-gray-50 focus:bg-white" />
                                            <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-black">
                                                <svg x-show="!show" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                                <svg x-show="show" style="display: none;" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" /></svg>
                                            </button>
                                        </div>
                                        <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
                                    </div>

                                    <div x-data="{ show: false }">
                                        <x-input-label for="password" :value="__('New Password')" class="text-gray-700 font-semibold mb-2" />
                                        <div class="relative">
                                            <input id="password" name="password" :type="show ? 'text' : 'password'" autocomplete="new-password"
                                                class="w-full rounded-xl border-gray-300 focus:border-black focus:ring-black transition py-2.5 pr-10 bg-gray-50 focus:bg-white" />
                                            <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-black">
                                                <svg x-show="!show" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                                <svg x-show="show" style="display: none;" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" /></svg>
                                            </button>
                                        </div>
                                        <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
                                    </div>

                                    <div x-data="{ show: false }">
                                        <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-gray-700 font-semibold mb-2" />
                                        <div class="relative">
                                            <input id="password_confirmation" name="password_confirmation" :type="show ? 'text' : 'password'" autocomplete="new-password"
                                                class="w-full rounded-xl border-gray-300 focus:border-black focus:ring-black transition py-2.5 pr-10 bg-gray-50 focus:bg-white" />
                                            <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-black">
                                                <svg x-show="!show" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                                <svg x-show="show" style="display: none;" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" /></svg>
                                            </button>
                                        </div>
                                        <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
                                    </div>

                                    <div class="flex items-center gap-4 pt-4">
                                        <button type="submit" class="px-6 py-2.5 bg-black text-white font-bold rounded-xl hover:bg-gray-800 transition shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                            Update Password
                                        </button>
                                        @if (session('status') === 'password-updated')
                                            <span x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-green-600 font-medium flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                                Saved.
                                            </span>
                                        @endif
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div x-show="activeTab === 'danger'" style="display: none;" 
                         x-transition:enter="transition ease-out duration-300 transform" 
                         x-transition:enter-start="opacity-0 translate-x-4" 
                         x-transition:enter-end="opacity-100 translate-x-0">
                        
                        <div class="bg-white rounded-2xl border border-red-100 shadow-sm overflow-hidden">
                            <div class="p-6 sm:p-8 border-b border-red-50 bg-red-50/30">
                                <h3 class="text-lg font-bold text-red-600">Delete Account</h3>
                                <p class="text-sm text-red-500 mt-1">Permanently delete your account and all associated data.</p>
                            </div>

                            <div class="p-6 sm:p-8">
                                <div class="bg-red-50 rounded-xl p-4 mb-6 border border-red-100 flex items-start gap-3">
                                    <svg class="w-5 h-5 text-red-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                    <p class="text-sm text-red-700">
                                        Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.
                                    </p>
                                </div>

                                <div x-data="{ open: false }">
                                    <button @click="open = true" class="px-6 py-2.5 bg-red-600 text-white font-bold rounded-xl hover:bg-red-700 transition shadow-md hover:shadow-lg">
                                        Delete Account
                                    </button>

                                    <div x-show="open" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto">
                                        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                            <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" @click="open = false"></div>
                                            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
                                            <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full p-6">
                                                <h2 class="text-xl font-bold text-gray-900 mb-2">Are you sure?</h2>
                                                <p class="text-sm text-gray-500 mb-6">
                                                    Please enter your password to confirm you would like to permanently delete your account. This action cannot be undone.
                                                </p>

                                                <form method="post" action="{{ route('profile.destroy') }}">
                                                    @csrf
                                                    @method('delete')
                                                    
                                                    <div class="mb-6">
                                                        <input id="password" name="password" type="password" class="w-full rounded-xl border-gray-300 focus:border-red-500 focus:ring-red-500" placeholder="Enter your password" />
                                                        <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
                                                    </div>

                                                    <div class="flex justify-end gap-3">
                                                        <button type="button" @click="open = false" class="px-4 py-2 border border-gray-300 rounded-xl text-gray-700 hover:bg-gray-50 font-medium">Cancel</button>
                                                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-xl hover:bg-red-700 font-bold shadow-md">Yes, Delete</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </main>
</x-app-layout>