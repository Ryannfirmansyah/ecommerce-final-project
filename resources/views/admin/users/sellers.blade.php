<x-app-layout>
    <header class="bg-white border-b border-gray-200 px-4 py-3 sm:px-6 lg:px-8 md:py-4">
        <div class="flex items-center gap-2 text-xs sm:text-sm text-gray-500 mb-1 sm:mb-2">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-black">Dashboard</a>
            <span>›</span>
            <span class="text-black font-semibold">Sellers</span>
        </div>
        <h2 class="font-bold text-xl sm:text-2xl text-black">Sellers Management</h2>
    </header>

    <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8 bg-gray-50">

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-6 sm:mb-8">
            <div class="bg-white rounded-2xl p-5 sm:p-6 border-2 border-green-600 shadow-sm">
                <h3 class="font-bold text-2xl sm:text-3xl text-green-600">{{ $approvedSellers }}</h3>
                <p class="text-xs sm:text-sm text-gray-500 mt-1">Verified Sellers</p>
            </div>
            <div class="bg-white rounded-2xl p-5 sm:p-6 border-2 border-amber-400 shadow-sm">
                <h3 class="font-bold text-2xl sm:text-3xl text-amber-400">{{ $pendingSellers }}</h3>
                <p class="text-xs sm:text-sm text-gray-500 mt-1">Pending Approval</p>
            </div>
            <div class="bg-white rounded-2xl p-5 sm:p-6 border-2 border-red-600 shadow-sm">
                <h3 class="font-bold text-2xl sm:text-3xl text-red-600">{{ $rejectedSellers }}</h3>
                <p class="text-xs sm:text-sm text-gray-500 mt-1">Rejected Sellers</p>
            </div>
            <div class="bg-white rounded-2xl p-5 sm:p-6 border-2 border-blue-900 shadow-sm">
                <h3 class="font-bold text-2xl sm:text-3xl text-black">{{ $totalSellers }}</h3>
                <p class="text-xs sm:text-sm text-gray-500 mt-1">Total Sellers</p>
            </div>
        </div>

        <div class="w-full mb-6 flex flex-col md:flex-row items-start md:items-center gap-4">

            <x-search-bar
                :action="route('admin.sellers')"
                placeholder="Search sellers..."
                class="w-full md:flex-1 relative !mb-0"
            />

            <div class="w-full md:w-auto overflow-x-auto pb-2 md:pb-0">
                <div class="flex items-center gap-2 bg-gray-50 p-1.5 sm:p-2 rounded-2xl border border-gray-200 min-w-max">
                    <a href="{{ request()->fullUrlWithQuery(['status' => null]) }}"
                    class="px-3 sm:px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold transition-all whitespace-nowrap
                    {{ request('status') == null ? 'bg-black text-white shadow-md' : 'text-gray-600 hover:bg-gray-200' }}">
                        All
                    </a>

                    <a href="{{ request()->fullUrlWithQuery(['status' => 'pending']) }}"
                    class="px-3 sm:px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold transition-all whitespace-nowrap
                    {{ request('status') == 'pending' ? 'bg-black text-white shadow-md' : 'text-gray-600 hover:bg-gray-200' }}">
                        Pending
                    </a>

                    <a href="{{ request()->fullUrlWithQuery(['status' => 'approved']) }}"
                    class="px-3 sm:px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold transition-all whitespace-nowrap
                    {{ request('status') == 'approved' ? 'bg-black text-white shadow-md' : 'text-gray-600 hover:bg-gray-200' }}">
                        Approved
                    </a>

                    <a href="{{ request()->fullUrlWithQuery(['status' => 'rejected']) }}"
                    class="px-3 sm:px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold transition-all whitespace-nowrap
                    {{ request('status') == 'rejected' ? 'bg-black text-white shadow-md' : 'text-gray-600 hover:bg-gray-200' }}">
                        Rejected
                    </a>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full min-w-[900px]"> <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Store Name</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Owner</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Verification</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($sellers as $seller)
                            <tr class="bg-white hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <p class="font-semibold text-sm text-black">{{ $seller->store->name ?? 'No Store' }}</p>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <p class="text-sm text-gray-600">{{ $seller->name }}</p>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <p class="text-sm text-gray-600">{{ $seller->email }}</p>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold
                                        {{ $seller->seller_status == 'approved' ? 'bg-green-100 text-green-800' : '' }}
                                        {{ $seller->seller_status == 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                        {{ $seller->seller_status == 'rejected' ? 'bg-red-100 text-red-800' : '' }}
                                    ">
                                        {{ ucfirst($seller->seller_status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <div class="flex justify-center gap-2">
                                        @if($seller->seller_status == 'pending')
                                            <x-modal-confirm
                                                :action="route('admin.sellers.approve', $seller)"
                                                title="Approve Seller?"
                                                message="Are you sure you want to approve {{ $seller->name }}? They will be able to start selling immediately."
                                                confirm-text="Approve"
                                            >
                                                <x-slot name="trigger">
                                                    <button type="button" class="px-3 py-1.5 bg-black text-white text-xs font-semibold rounded-xl hover:bg-gray-800 transition-colors shadow-sm">
                                                        Approve
                                                    </button>
                                                </x-slot>
                                            </x-modal-confirm>

                                            <x-modal-confirm
                                                :action="route('admin.sellers.reject', $seller)"
                                                title="Reject Seller?"
                                                message="Are you sure you want to reject {{ $seller->name }}? This action cannot be undone easily."
                                                confirm-text="Reject"
                                            >
                                                <x-slot name="trigger">
                                                    <button type="button" class="px-3 py-1.5 border border-red-200 text-red-600 text-xs font-semibold rounded-xl hover:bg-red-50 transition-colors">
                                                        Reject
                                                    </button>
                                                </x-slot>
                                            </x-modal-confirm>
                                        @else
                                            <a href="{{ route('admin.users.edit', $seller) }}" class="px-3 py-1.5 bg-gray-100 text-gray-700 text-xs font-semibold rounded-xl hover:bg-gray-200 transition-colors border border-gray-200">
                                                View Details
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-12 h-12 mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                        <p>No sellers found matching criteria.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-6">
            {{ $sellers->links('vendor.pagination.custom') }}
        </div>

    </main>
</x-app-layout>