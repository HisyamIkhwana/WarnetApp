@extends('layouts.app')
@section('title', 'Dashboard Admin Warnet')
@section('content')
    <div class="flex items-center justify-between mb-8">
        <div>
            <h2 class="text-3xl font-bold text-white">Dashboard Admin Warnet</h2>
            <p class="text-gray-400 mt-1">Kelola dan monitor semua aktivitas warnet</p>
        </div>
        <div class="flex items-center space-x-4">
            <div class="text-right">
                <p class="text-sm text-gray-400">Waktu Sekarang</p>
                <p class="text-lg font-semibold text-white" id="current-time"></p>
            </div>
            <button id="refresh-time" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors">
                <i class="fas fa-sync-alt mr-2"></i>
                Refresh
            </button>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="stat-card p-6 rounded-xl text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm opacity-80">Total Komputer</p>
                    <p class="text-3xl font-bold">{{ $totalKomputer }}</p>
                </div>
                <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                    <i class="fas fa-desktop text-xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-gradient-to-r from-green-500 to-emerald-600 p-6 rounded-xl text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm opacity-80">Komputer Aktif</p>
                    <p class="text-3xl font-bold">{{ $komputerAktif }}</p>
                </div>
                <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                    <i class="fas fa-play text-xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-gradient-to-r from-blue-500 to-cyan-600 p-6 rounded-xl text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm opacity-80">Komputer Tersedia</p>
                    <p class="text-3xl font-bold">{{ $komputerTersedia }}</p>
                </div>
                <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                    <i class="fas fa-check text-xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-gradient-to-r from-orange-500 to-red-600 p-6 rounded-xl text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm opacity-80">Maintenance</p>
                    <p class="text-3xl font-bold">{{ $maintenance }}</p>
                </div>
                <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                    <i class="fas fa-tools text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Computer Grid -->
    <div class="bg-slate-800/50 backdrop-blur-sm rounded-xl p-6 mb-8">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-xl font-semibold text-white">Monitor Komputer Real-time</h3>
            <div class="flex space-x-2">
                <button class="px-3 py-1 bg-green-600 text-white rounded-lg text-sm">
                    <i class="fas fa-circle mr-1"></i>
                    Tersedia
                </button>
                <button class="px-3 py-1 bg-red-600 text-white rounded-lg text-sm">
                    <i class="fas fa-circle mr-1"></i>
                    Terpakai
                </button>
                <button class="px-3 py-1 bg-orange-600 text-white rounded-lg text-sm">
                    <i class="fas fa-circle mr-1"></i>
                    Maintenance
                </button>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-4">
            @foreach ($warnets as $warnet)
                @foreach ($warnet->komputers as $komputer)
                    <div class="computer-card bg-slate-700/50 rounded-lg p-4 border border-slate-600">
                        <div class="flex items-center justify-between mb-3">
                            <h4 class="text-white font-medium">{{ $komputer->merk }}</h4>
                            @if ($komputer->status == 'tersedia')
                                <span class="status-available text-white text-xs px-2 py-1 rounded-full">Tersedia</span>
                            @elseif ($komputer->status == 'terpakai')
                                <span class="status-in-use text-white text-xs px-2 py-1 rounded-full bg-red-600">Terpakai</span>
                            @elseif ($komputer->status == 'nonaktif')
                                <span class="status-maintenance text-white text-xs px-2 py-1 rounded-full bg-orange-600">Maintenance</span>
                            @endif
                        </div>
                        <div class="text-center mb-3">
                            <i class="fas fa-desktop text-4xl mb-2
                                @if ($komputer->status == 'tersedia') text-green-400
                                @elseif ($komputer->status == 'terpakai') text-red-600
                                @elseif ($komputer->status == 'nonaktif') text-orange-600
                                @endif
                            "></i>
                            <p class="text-sm text-gray-300">{{ $komputer->spesifikasi }}</p>
                            <p class="text-xs text-gray-400">Rp 5,000/jam</p>
                        </div>
                        @if ($komputer->status == 'tersedia')
                            <a href="{{ route('sesi.create', ['komputer_id' => $komputer->id]) }}" class="w-full inline-block bg-green-600 hover:bg-green-700 text-white py-2 rounded-lg text-center transition-colors">
                                <i class="fas fa-play mr-2"></i>
                                Mulai Sesi
                            </a>
                        @else
                            <button disabled class="w-full bg-gray-600 text-white py-2 rounded-lg cursor-not-allowed">
                                Tidak Tersedia
                            </button>
                        @endif
                    </div>
                @endforeach
            @endforeach
        </div>
    </div>

    <!-- Recent Sessions -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-slate-800/50 backdrop-blur-sm rounded-xl p-6">
            <h3 class="text-xl font-semibold text-white mb-4">Sesi Aktif</h3>
            <div class="space-y-3">
                @foreach ($warnets as $warnet)
                    @foreach ($warnet->komputers as $komputer)
                        @foreach ($komputer->sesis as $sesi)
                            <div class="p-3 bg-gray-700 rounded-lg">
                                <p class="text-white">Komputer: {{ $komputer->merk }}</p>
                                <p class="text-white">Waktu Mulai: {{ $sesi->waktu_mulai }}</p>
                                <p class="text-white">Durasi: {{ $sesi->durasi ?? 'N/A' }} menit</p>
                            </div>
                        @endforeach
                    @endforeach
                @endforeach
            </div>
        </div>
        <div class="bg-slate-800/50 backdrop-blur-sm rounded-xl p-6">
            <h3 class="text-xl font-semibold text-white mb-4">Statistik Hari Ini</h3>
            <div class="space-y-4">
                <div class="statistic-item flex justify-between text-white">
                    <span>Total Sesi</span>
                    <span>{{ $totalSesi }}</span>
                </div>
                <div class="statistic-item flex justify-between text-white">
                    <span>Sesi Selesai</span>
                    <span>{{ $sesiSelesai }}</span>
                </div>
                <div class="statistic-item flex justify-between text-white">
                    <span>Sesi Aktif</span>
                    <span>{{ $sesiAktif }}</span>
                </div>
                <div class="statistic-item flex justify-between text-white">
                    <span>Pendapatan</span>
                    <span>Rp {{ number_format($pendapatan, 0, ',', '.') }}</span>
                </div>
                <div class="statistic-item flex justify-between text-white">
                    <span>Waktu Penggunaan</span>
                    <span>{{ round($waktuPenggunaan, 2) }} jam</span>
                </div>
            </div>
        </div>
    </div>
    <script>
        function updateCurrentTime() {
            const now = new Date();
            const currentTimeElem = document.getElementById('current-time');
            if (currentTimeElem) {
                currentTimeElem.textContent = now.toLocaleTimeString();
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            updateCurrentTime();
            setInterval(updateCurrentTime, 1000);

            const refreshButton = document.getElementById('refresh-time');
            if (refreshButton) {
                refreshButton.addEventListener('click', updateCurrentTime);
            }
        });
    </script>
@endsection
