<x-app-layout>
    <header class="bg-white border-b border-gray-200 px-4 py-3 sm:px-6 lg:px-8 md:py-4">
        <div class="flex items-center gap-2 text-xs sm:text-sm text-gray-500 mb-1 sm:mb-2">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-black">Dashboard</a>
        </div>
        <h2 class="font-bold text-xl sm:text-2xl text-black">Welcome Admin!</h2>
    </header>

    <main class="flex-1 p-6 md:p-12 overflow-y-auto">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-12">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <p class="text-xs text-gray-400 font-bold uppercase mb-2">Total Users</p>
                <h3 class="text-3xl font-serif font-bold">{{ $stats['total_users'] }}</h3>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <p class="text-xs text-gray-400 font-bold uppercase mb-2">Total Sellers</p>
                <h3 class="text-3xl font-serif font-bold">{{ $stats['total_sellers'] }}</h3>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <p class="text-xs text-gray-400 font-bold uppercase mb-2">Pending Sellers</p>
                <h3 class="text-3xl font-serif font-bold text-yellow-500">
                    {{ $stats['pending_count'] }}
                </h3>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <p class="text-xs text-gray-400 font-bold uppercase mb-2">Total Orders</p>
                <h3 class="text-3xl font-serif font-bold">{{ $stats['total_orders'] }}</h3>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-50 flex justify-between items-center">
                <h3 class="font-bold text-lg">New Sellers (Pending)</h3>
                <a href="{{ route('admin.sellers', ['status' => 'pending']) }}" class="text-xs font-bold text-blue-600 hover:underline">View All &rarr;</a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-50/50">
                        <tr>
                            <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase">Name</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase">Email</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase">Registered</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        {{-- Kita loop variabel $pendingSellers (List User), bukan $stats (Array angka) --}}
                        @forelse($pendingSellers as $seller)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4 font-bold text-sm">{{ $seller->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $seller->email }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $seller->created_at->diffForHumans() }}</td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end gap-2">
                                    <form action="{{ route('admin.sellers.approve', $seller->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="px-4 py-1.5 bg-neutral-900 text-white text-xs font-bold rounded-full hover:bg-green-600 transition shadow-sm">
                                            Approve
                                        </button>
                                    </form>

                                    <form action="{{ route('admin.sellers.reject', $seller->id) }}" method="POST" onsubmit="return confirm('Reject seller ini?');">
                                        @csrf
                                        <button type="submit" class="px-4 py-1.5 border border-red-200 text-red-500 text-xs font-bold rounded-full hover:bg-red-50 transition">
                                            Reject
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-10 text-center text-gray-400 text-sm">
                                No pending sellers at the moment.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</x-app-layout>