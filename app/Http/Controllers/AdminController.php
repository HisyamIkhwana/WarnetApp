<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Komputer;
use App\Models\Sesi;
use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Http\Request;

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
            'transaksiTerakhir'
        ));
    }
}