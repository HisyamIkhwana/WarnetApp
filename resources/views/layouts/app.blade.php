<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title') - Admin Warnet</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="https://cdn.tailwindcss.com"></script> 
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"  rel="stylesheet">
</head>
<body class="bg-gradient-to-br from-slate-900 via-purple-900 to-slate-900 min-h-screen font-sans">
    <nav class="mt-8 flex-grow">
        <div class="px-4 space-y-2">
            </div>
    </nav>
    <!-- Sidebar -->
    <aside class="fixed inset-y-0 left-0 z-50 w-64 bg-slate-800/95 backdrop-blur-lg border-r border-slate-700">
        <div class="flex items-center justify-center h-16 bg-gradient-to-r from-purple-600 to-blue-600">
            <h1 class="text-xl font-bold text-white">
                <i class="fas fa-desktop mr-2"></i>
                Admin Warnet
            </h1>
        </div>
        <nav class="mt-8">
            <div class="px-4 space-y-2">
                <a href="{{ route('warnet.index') }}" class="flex items-center px-4 py-3 text-gray-300 hover:text-white hover:bg-slate-700 rounded-lg transition-colors duration-200">
                    <i class="fas fa-tachometer-alt mr-3"></i>
                    Dashboard
                </a>
                <a href="{{ route('komputer.index') }}" class="flex items-center px-4 py-3 text-gray-300 hover:text-white hover:bg-slate-700 rounded-lg transition-colors duration-200">
                    <i class="fas fa-desktop mr-3"></i>
                    Komputer
                </a>
                <a href="{{ route('sesi.index') }}" class="flex items-center px-4 py-3 text-gray-300 hover:text-white hover:bg-slate-700 rounded-lg transition-colors duration-200">
                    <i class="fas fa-clock mr-3"></i>
                    Sesi Komputer
                </a>
            </div>
        </nav>
        <div class="absolute bottom-4 left-4 right-4">
            <div class="px-4 mb-4">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a href="{{ route('logout') }}"
                       onclick="event.preventDefault(); this.closest('form').submit();"
                       class="flex items-center px-4 py-3 text-red-400 hover:text-white hover:bg-red-600 rounded-lg transition-colors duration-200">
                        <i class="fas fa-sign-out-alt mr-3"></i>
                        Logout
                    </a>
                </form>
            </div>
            <div class="flex items-center p-4 bg-slate-700 rounded-lg">
                <div class="w-10 h-10 bg-purple-600 rounded-full flex items-center justify-center mr-3">
                    <i class="fas fa-user text-white"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-white">Admin Warnet</p>
                    <p class="text-xs text-gray-400">Online</p>
                </div>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <main id="main-content" class="ml-64 p-8">
        @yield('content')
    </main>
    @stack('scripts') 
</body>
</html>