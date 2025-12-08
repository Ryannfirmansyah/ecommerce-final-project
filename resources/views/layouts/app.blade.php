<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories - NexusPlace Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="font-['Poppins'] bg-slate-300">


    <div x-data="{ sidebarOpen: false }" class="flex w-full h-screen overflow-hidden">

        <div x-show="sidebarOpen"
                 @click="sidebarOpen = false"
                 x-transition:enter="transition-opacity ease-linear duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition-opacity ease-linear duration-300"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm z-40 md:hidden"
        ></div>

        @include('layouts.navigation')

        <div class="min-h-screen flex-1 bg-slate-100 flex flex-col overflow-hidden">
            <!-- Topbar -->
            <header class="bg-white border-b border-gray-200 p-4 flex items-center justify-between md:hidden z-30">
                <div class="flex items-center gap-3">
                    <button @click="sidebarOpen = true" class="text-gray-500 hover:text-black focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                    <span class="font-bold text-lg">NexusPlace</span>
                </div>
            </header>

            <!-- Page Content -->
            {{ $slot }}
        </div>
    </div>

    <x-toast/>
</body>
</html>
