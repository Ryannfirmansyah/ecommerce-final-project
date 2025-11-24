<x-guest-layout>
    <div class="mb-4 text-center">
        @if(auth()->user()->seller_status === 'pending')
            <!-- Status Pending -->
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6">
                <svg class="mx-auto h-12 w-12 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                
                <h2 class="mt-4 text-xl font-semibold text-gray-900">
                    Akun Sedang Ditinjau
                </h2>
                
                <p class="mt-2 text-sm text-gray-600">
                    Terima kasih telah mendaftar sebagai Seller!
                </p>
                
                <p class="mt-2 text-sm text-gray-600">
                    Akun Anda sedang dalam proses verifikasi oleh Admin. 
                    Silakan tunggu konfirmasi melalui email atau coba login kembali nanti.
                </p>

                <div class="mt-6 space-y-2">
                    <p class="text-xs text-gray-500">
                        <strong>Nama:</strong> {{ auth()->user()->name }}
                    </p>
                    <p class="text-xs text-gray-500">
                        <strong>Email:</strong> {{ auth()->user()->email }}
                    </p>
                    <p class="text-xs text-gray-500">
                        <strong>Status:</strong> 
                        <span class="inline-flex items-center px-2 py-1 text-xs font-medium text-yellow-800 bg-yellow-100 rounded">
                            Pending
                        </span>
                    </p>
                </div>

                <div class="mt-6">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-primary-button type="submit" class="w-full justify-center">
                            Logout
                        </x-primary-button>
                    </form>
                </div>
            </div>

        @elseif(auth()->user()->seller_status === 'rejected')
            <!-- Status Rejected -->
            <div class="bg-red-50 border border-red-200 rounded-lg p-6">
                <svg class="mx-auto h-12 w-12 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                
                <h2 class="mt-4 text-xl font-semibold text-gray-900">
                    Pendaftaran Ditolak
                </h2>
                
                <p class="mt-2 text-sm text-gray-600">
                    Maaf, pendaftaran Anda sebagai Seller telah ditolak oleh Admin.
                </p>

                <p class="mt-2 text-sm text-gray-600">
                    Anda dapat menghapus akun ini atau hubungi Admin untuk informasi lebih lanjut.
                </p>

                <div class="mt-6 space-x-3">
                    <form method="POST" action="{{ route('seller.delete-account') }}" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun ini?')">
                        @csrf
                        @method('DELETE')
                        <x-danger-button type="submit">
                            Hapus Akun
                        </x-danger-button>
                    </form>

                    <form method="POST" action="{{ route('logout') }}" class="inline-block">
                        @csrf
                        <x-secondary-button type="submit">
                            Logout
                        </x-secondary-button>
                    </form>
                </div>
            </div>
        @endif
    </div>
</x-guest-layout>