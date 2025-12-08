<x-app-layout>   
    <header class="bg-white border-b border-gray-200 px-4 py-3 sm:px-6 lg:px-8 md:py-4">
        <div class="flex items-center gap-2 text-xs sm:text-sm text-gray-500 mb-1 sm:mb-2">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-black">Dashboard</a>
            <span>›</span>
            <span class="text-black font-semibold">Users</span>
        </div>
        <h2 class="font-bold text-xl sm:text-2xl text-black">Users Management</h2>
    </header>

    <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8 bg-gray-50">
        
        <div class="mb-6 flex flex-col md:flex-row items-start md:items-center gap-4">
            
            <x-search-bar 
                :action="route('admin.users.index')"
                placeholder="Search users..." 
                class="w-full md:flex-1 relative !mb-0"   
            />
            
            <div class="w-full md:w-auto overflow-x-auto pb-2 md:pb-0">
                <div class="flex items-center gap-2 bg-gray-50 p-1.5 sm:p-2 rounded-2xl border border-gray-200 min-w-max">
                    {{-- Tombol ALL --}}
                    <a href="{{ request()->fullUrlWithQuery(['role' => null]) }}" 
                    class="px-3 sm:px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold transition-all whitespace-nowrap
                    {{ request('role') == null ? 'bg-black text-white shadow-md' : 'text-gray-600 hover:bg-gray-200' }}">
                        All
                    </a>

                    {{-- Tombol BUYER --}}
                    <a href="{{ request()->fullUrlWithQuery(['role' => 'buyer']) }}" 
                    class="px-3 sm:px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold transition-all whitespace-nowrap
                    {{ request('role') == 'buyer' ? 'bg-black text-white shadow-md' : 'text-gray-600 hover:bg-gray-200' }}">
                        Buyer
                    </a>

                    {{-- Tombol SELLER --}}
                    <a href="{{ request()->fullUrlWithQuery(['role' => 'seller']) }}" 
                    class="px-3 sm:px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold transition-all whitespace-nowrap
                    {{ request('role') == 'seller' ? 'bg-black text-white shadow-md' : 'text-gray-600 hover:bg-gray-200' }}">
                        Seller
                    </a>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full min-w-[800px]"> <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Profile</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Name</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Role</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($users as $user)
                            <tr class="hover:bg-gray-50 transition-colors group">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-black font-bold border border-gray-200">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <p class="font-semibold text-sm text-gray-900">{{ $user->name }}</p>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <p class="text-sm text-gray-500">{{ $user->email }}</p>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium capitalize
                                        {{ $user->role == 'admin' ? 'bg-purple-100 text-purple-800' : '' }}
                                        {{ $user->role == 'seller' ? 'bg-blue-100 text-blue-800' : '' }}
                                        {{ $user->role == 'buyer' ? 'bg-gray-100 text-gray-800' : '' }}
                                    ">
                                        {{ $user->role }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <span class="w-1.5 h-1.5 rounded-full bg-green-600"></span>
                                        Active
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-2 transition-opacity">
                                        <a href="{{ route('admin.users.edit', $user) }}" class="p-2 text-gray-500 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Edit User">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        </a>
                                        
                                        <x-modal-confirm 
                                            :action="route('admin.users.destroy', $user)"
                                            title="Delete User?"
                                            message="Are you sure you want to delete {{ $user->name }}? This action cannot be undone."
                                            confirm-text="Yes, Delete"
                                        >
                                            <x-slot name="trigger">
                                                <button type="button" class="p-2 text-gray-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Delete User">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                </button>
                                            </x-slot>
                                        </x-modal-confirm>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center text-gray-500">
                                        <svg class="w-12 h-12 mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                        <p class="text-base font-medium">No users found</p>
                                        <p class="text-sm">Try adjusting your search or filters.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-6">
            {{ $users->links('vendor.pagination.custom') }}
        </div>

    </main>
</x-app-layout>