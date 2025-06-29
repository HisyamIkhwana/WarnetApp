@extends('layouts.admin') {{-- Menggunakan layout admin warnet utama --}}
@section('title', 'Admin Dashboard')

@section('content')
<div>
    <div class="flex items-center justify-between mb-8">
        <div>
            <h2 class="text-3xl font-bold text-white">Admin Dashboard</h2>
            <p class="text-gray-400 mt-1">Ringkasan aktivitas warnet dan penjualan warung.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="stat-card p-6 rounded-xl text-white bg-gradient-to-br from-green-600 to-teal-500">
            <i class="fas fa-desktop text-3xl opacity-50 absolute right-6 top-6"></i>
            <p class="text-sm opacity-80">Pendapatan Warnet (Hari Ini)</p>
            <p class="text-3xl font-bold">Rp {{ number_format($pendapatanWarnetHariIni, 0, ',', '.') }}</p>
        </div>
        <div class="stat-card p-6 rounded-xl text-white bg-gradient-to-br from-blue-600 to-indigo-500">
             <i class="fas fa-utensils text-3xl opacity-50 absolute right-6 top-6"></i>
            <p class="text-sm opacity-80">Pendapatan Warung (Hari Ini)</p>
            <p class="text-3xl font-bold">Rp {{ number_format($pendapatanWarungHariIni, 0, ',', '.') }}</p>
        </div>
        <div class="stat-card p-6 rounded-xl text-white bg-gradient-to-br from-purple-600 to-blue-500">
             <i class="fas fa-receipt text-3xl opacity-50 absolute right-6 top-6"></i>
            <p class="text-sm opacity-80">Total Transaksi Hari Ini</p>
            <p class="text-3xl font-bold">{{ $totalTransaksiHariIni }}</p>
        </div>
        <div class="stat-card p-6 rounded-xl text-white bg-gradient-to-br from-orange-500 to-red-500">
             <i class="fas fa-users text-3xl opacity-50 absolute right-6 top-6"></i>
            <p class="text-sm opacity-80">Komputer Aktif</p>
            <p class="text-3xl font-bold">{{ $komputerAktif }} / {{ $totalKomputer }}</p>
        </div>
    </div>
    
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
        <div class="xl:col-span-2 flex flex-col gap-8">
            <!-- Monitor Komputer -->
            <div class="bg-slate-800/50 backdrop-blur-sm rounded-xl p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-semibold text-white">Monitor Komputer</h3>
                    <a href="{{ route('komputer.index') }}" class="text-sm text-indigo-400 hover:underline">Lihat Semua</a>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
                    @foreach ($komputers as $komputer)
                        <div class="text-center p-4 rounded-lg
                            @if($komputer->sesiAktif) bg-red-500/20 border-2 border-red-500
                            @elseif($komputer->status == 'nonaktif') bg-orange-500/20 border-2 border-orange-500
                            @else bg-green-500/20 border-2 border-green-500 @endif">
                            <i class="fas fa-desktop text-4xl mb-2 text-white"></i>
                            <p class="font-bold text-white">{{ $komputer->merk }}</p>
                            @if($komputer->sesiAktif)
                                <span class="text-xs text-red-300">Terpakai</span>
                            @elseif($komputer->status == 'nonaktif')
                                <span class="text-xs text-orange-300">Maintenance</span>
                            @else
                                <span class="text-xs text-green-300">Tersedia</span>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Sesi Berjalan -->
            <div class="bg-slate-800/50 backdrop-blur-sm rounded-xl p-6">
                <h3 class="text-xl font-semibold text-white mb-6">Sesi Sedang Berjalan</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm text-left text-slate-300">
                        <thead class="text-xs text-slate-400 uppercase bg-slate-900/50">
                            <tr>
                                <th scope="col" class="px-6 py-3">Komputer</th>
                                <th scope="col" class="px-6 py-3">Waktu Mulai</th>
                                <th scope="col" class="px-6 py-3">Waktu Selesai</th>
                                <th scope="col" class="px-6 py-3">Sisa Waktu</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($sesiBerjalan as $sesi)
                                <tr class="border-b border-slate-700">
                                    <td class="px-6 py-4 font-medium text-white">{{ $sesi->komputer->merk }}</td>
                                    <td class="px-6 py-4">{{ $sesi->waktu_mulai->format('H:i') }}</td>
                                    <td class="px-6 py-4">{{ $sesi->waktu_selesai->format('H:i') }}</td>
                                    <td class="px-6 py-4 text-orange-400 font-bold">{{ $sesi->waktu_selesai->diffForHumans(null, true) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-8 text-slate-500">Tidak ada sesi yang sedang berjalan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="xl:col-span-1 flex flex-col gap-8">
            <!-- Transaksi Terakhir -->
            <div class="bg-slate-800/50 backdrop-blur-sm rounded-xl p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-semibold text-white">Transaksi Terakhir</h3>
                    <a href="{{ route('kasir.transaksi') }}" class="text-sm text-indigo-400 hover:underline">Lihat Semua</a>
                </div>
                <div class="space-y-4">
                    @forelse($transaksiTerakhir as $transaksi)
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-full bg-slate-700 flex items-center justify-center">
                                <i class="fas fa-receipt text-purple-400"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-white">Pesanan #{{ $transaksi->pesanan_id }}</p>
                                <p class="text-sm text-green-400 font-bold">Rp {{ number_format($transaksi->jumlah_bayar, 0, ',', '.') }}</p>
                            </div>
                            <div class="ml-auto text-right">
                                <p class="text-xs text-slate-400">{{ $transaksi->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-slate-500 pt-8">Belum ada transaksi.</p>
                    @endforelse
                </div>
            </div>

            <!-- Produk Terlaris -->
            <div class="bg-slate-800/50 backdrop-blur-sm rounded-xl p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-semibold text-white">Produk Terlaris (Hari Ini)</h3>
                    <a href="{{ route('kasir.menu') }}" class="text-sm text-indigo-400 hover:underline">Lihat Menu</a>
                </div>
                <div class="space-y-4">
                    @forelse($produkTerlaris as $produk)
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-full bg-slate-700 flex items-center justify-center">
                                <i class="fas fa-star text-yellow-400"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-white">{{ $produk->nama }}</p>
                            </div>
                            <div class="ml-auto text-right">
                                <p class="font-bold text-slate-300">{{ $produk->total_terjual }} <span class="text-xs text-slate-400">terjual</span></p>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-slate-500 pt-8">Belum ada produk yang terjual hari ini.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
