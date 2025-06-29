<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Komputer;
use App\Models\Sesi;
use App\Models\Transaksi;
use App\Models\ItemPesanan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /**
     * Menampilkan halaman dashboard admin dengan data statistik.
     */
    public function dashboard()
    {
        // --- Statistik Warnet ---
            $totalKomputer = Komputer::count();
            $komputerAktif = Sesi::where('waktu_selesai', '>', Carbon::now())->count();

            // Asumsi tarif warnet, Anda bisa mengubahnya atau mengambil dari database
            $tarifPerJamWarnet = 5000;
            
            // Pendapatan warnet hari ini
            $pendapatanWarnetHariIni = Sesi::whereDate('created_at', Carbon::today())->get()->sum(function ($sesi) use ($tarifPerJamWarnet) {
                // Durasi dalam jam
                $durasiDalamJam = $sesi->durasi / 60;
                return $durasiDalamJam * $tarifPerJamWarnet;
            });

            // --- Statistik Warung (Kasir) ---
            $totalProduk = Produk::count();
            $pendapatanWarungHariIni = Transaksi::whereDate('created_at', Carbon::today())->sum('jumlah_bayar');

            // --- Statistik Gabungan ---
            $totalPendapatanHariIni = $pendapatanWarnetHariIni + $pendapatanWarungHariIni;
            $totalTransaksiHariIni = Sesi::whereDate('created_at', Carbon::today())->count() + Transaksi::whereDate('created_at', Carbon::today())->count();
            
            // --- Data untuk Tabel ---
            $komputers = Komputer::with('sesiAktif')->get();
            $transaksiTerakhir = Transaksi::with('pesanan.items.produk')->latest()->take(5)->get();

	        // Data baru: Sesi yang sedang berjalan
	        $sesiBerjalan = Sesi::where('waktu_selesai', '>', Carbon::now())
	                              ->with('komputer')
	                              ->latest('waktu_mulai')
	                              ->get();
	
	        // Data baru: Produk terlaris hari ini
	        $produkTerlaris = ItemPesanan::whereDate('item_pesanans.created_at', Carbon::today())
	            ->join('produks', 'item_pesanans.produk_id', '=', 'produks.id')
	            ->select('produks.nama', DB::raw('SUM(item_pesanans.jumlah) as total_terjual'))
	            ->groupBy('produks.nama')
	            ->orderByDesc('total_terjual')
	            ->take(5)
	            ->get();


            // Mengirim semua data ke view
            return view('admin.dashboard', compact(
                'totalKomputer',
                'komputerAktif',
                'totalProduk',
                'totalPendapatanHariIni',
                'totalTransaksiHariIni',
                'pendapatanWarnetHariIni',
                'pendapatanWarungHariIni',
                'komputers',
                'transaksiTerakhir',
                'sesiBerjalan',
                'produkTerlaris'
            ));
    }
}
