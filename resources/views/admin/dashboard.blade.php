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
        <div class="stat-card p-6 rounded-xl text-white bg-gradient-to-br from-purple-600 to-blue-500">
            <i class="fas fa-dollar-sign text-3xl opacity-50 absolute right-6 top-6"></i>
            <p class="text-sm opacity-80">Total Pendapatan Hari Ini</p>
            <p class="text-3xl font-bold">Rp {{ number_format($totalPendapatanHariIni, 0, ',', '.') }}</p>
        </div>
        <div class="stat-card p-6 rounded-xl text-white bg-gradient-to-br from-purple-600 to-blue-500">
             <i class="fas fa-receipt text-3xl opacity-50 absolute right-6 top-6"></i>
            <p class="text-sm opacity-80">Total Transaksi Hari Ini</p>
            <p class="text-3xl font-bold">{{ $totalTransaksiHariIni }}</p>
        </div>
        <div class="stat-card p-6 rounded-xl text-white bg-gradient-to-br from-purple-600 to-blue-500">
             <i class="fas fa-desktop text-3xl opacity-50 absolute right-6 top-6"></i>
            <p class="text-sm opacity-80">Komputer Aktif</p>
            <p class="text-3xl font-bold">{{ $komputerAktif }} / {{ $totalKomputer }}</p>
        </div>
        <div class="stat-card p-6 rounded-xl text-white bg-gradient-to-br from-purple-600 to-blue-500">
             <i class="fas fa-utensils text-3xl opacity-50 absolute right-6 top-6"></i>
            <p class="text-sm opacity-80">Jumlah Menu</p>
            <p class="text-3xl font-bold">{{ $totalProduk }}</p>
        </div>
    </div>
    
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
        <div class="xl:col-span-2 flex flex-col gap-8">
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

             <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <a href="{{ route('komputer.index') }}" class="block p-6 bg-slate-800/50 rounded-xl hover:bg-slate-700/50 transition-colors">
                    <i class="fas fa-clock text-2xl text-purple-400 mb-2"></i>
                    <h4 class="font-bold text-white">Manajemen Komputer</h4>
                    <p class="text-sm text-slate-400">Kelola dan tambah Komputer.</p>
                </a>
                 <a href="{{ route('kasir.menu') }}" class="block p-6 bg-slate-800/50 rounded-xl hover:bg-slate-700/50 transition-colors">
                    <i class="fas fa-book-open text-2xl text-purple-400 mb-2"></i>
                    <h4 class="font-bold text-white">Manajemen Menu</h4>
                    <p class="text-sm text-slate-400">Tambah atau ubah produk warung.</p>
                </a>
            </div>
        </div>

        <div class="xl:col-span-1 bg-slate-800/50 backdrop-blur-sm rounded-xl p-6">
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
    </div>
</div>
@endsection