<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Admin Panel') - Warnet App</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gradient-to-br from-slate-900 via-purple-900 to-slate-900 min-h-screen font-sans">
<div class="flex">
    <aside class="fixed inset-y-0 left-0 z-50 w-64 bg-slate-800 border-r border-slate-700 flex flex-col">
        <div class="flex items-center justify-center h-16 flex-shrink-0 bg-gradient-to-r from-purple-600 to-blue-600">
            <h1 class="text-xl font-bold text-white">
                <i class="fas fa-user-shield mr-2"></i>
                Admin Panel
            </h1>
        </div>

        <nav class="mt-8 flex-grow overflow-y-auto">
            <div class="px-4 space-y-2">
                <p class="px-4 pt-4 pb-2 text-xs font-semibold text-slate-500 uppercase">Utama</p>
                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 text-gray-300 hover:text-white hover:bg-slate-700 rounded-lg transition-colors duration-200">
                    <i class="fas fa-tachometer-alt mr-3 w-5 text-center"></i>
                    Dashboard
                </a>

                <p class="px-4 pt-4 pb-2 text-xs font-semibold text-slate-500 uppercase">Manajemen Warnet</p>
                <a href="{{ route('komputer.index') }}" class="flex items-center px-4 py-3 text-gray-300 hover:text-white hover:bg-slate-700 rounded-lg transition-colors duration-200">
                    <i class="fas fa-desktop mr-3 w-5 text-center"></i>
                    Komputer
                </a>
                <a href="{{ route('sesi.index') }}" class="flex items-center px-4 py-3 text-gray-300 hover:text-white hover:bg-slate-700 rounded-lg transition-colors duration-200">
                    <i class="fas fa-clock mr-3 w-5 text-center"></i>
                    Sesi Komputer
                </a>

                <p class="px-4 pt-4 pb-2 text-xs font-semibold text-slate-500 uppercase">Manajemen Kasir</p>
                <a href="{{ route('kasir.menu') }}" class="flex items-center px-4 py-3 text-gray-300 hover:text-white hover:bg-slate-700 rounded-lg transition-colors duration-200">
                    <i class="fas fa-utensils mr-3 w-5 text-center"></i>
                    Menu
                </a>
                <a href="{{ route('kasir.transaksi') }}" class="flex items-center px-4 py-3 text-gray-300 hover:text-white hover:bg-slate-700 rounded-lg transition-colors duration-200">
                    <i class="fas fa-file-invoice-dollar mr-3 w-5 text-center"></i>
                    Transaksi
                </a>
            </div>
        </nav>

        <div class="p-4 flex-shrink-0">
            {{-- Info Pengguna --}}
            <div class="flex items-center p-3 bg-slate-700/50 rounded-lg mb-3">
                <div class="w-10 h-10 bg-purple-600 rounded-full flex items-center justify-center mr-3 flex-shrink-0">
                    <i class="fas fa-user text-white"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-white truncate">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-gray-400 capitalize">{{ Auth::user()->role }}</p>
                </div>
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <a href="{{ route('logout') }}"
                   onclick="event.preventDefault(); this.closest('form').submit();"
                   class="flex items-center w-full px-4 py-3 text-red-400 hover:text-white hover:bg-red-600/80 rounded-lg transition-colors duration-200">
                    <i class="fas fa-sign-out-alt mr-3 w-5 text-center"></i>
                    <span>Logout</span>
                </a>
            </form>
        </div>
    </aside>

    <main class="ml-64 flex-1 p-8">
        @yield('content')
    </main>
</div>
@stack('scripts')
</body>
</html>