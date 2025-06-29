<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Warnet;
use App\Models\Pesanan;
use App\Models\Produk;
use App\Models\Komputer;
use App\Models\Sesi;
use App\Models\Transaksi;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $role = Auth::user()->role;

        if ($role == 'admin') {
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
            return view('admin.dashboard'); 

        } elseif ($role == 'warnet') {
            $warnets = Warnet::with(['komputers' => function ($query) {
                $query->with(['sesis' => function ($query) {
                    $query->where('waktu_mulai', '<=', now())
                          ->where('waktu_selesai', '>=', now());
                }]);
            }])->get();
    
            // Calculate komputer stats
            $totalKomputer = 0;
            $komputerAktif = 0;
            $komputerTersedia = 0;
            $maintenance = 0;
            foreach ($warnets as $warnet) {
                foreach ($warnet->komputers as $komputer) {
                    $totalKomputer++;
                    $status = $komputer->status;
                    if ($status === 'terpakai') {
                        $komputerAktif++;
                    } elseif ($status === 'tersedia') {
                        $komputerTersedia++;
                    } elseif ($status === 'nonaktif') {
                        $maintenance++;
                    }
                }
            }
    
            // Calculate sesi stats for today
            $totalSesi = \App\Models\Sesi::whereDate('waktu_mulai', now()->toDateString())->count();
            $sesiSelesai = \App\Models\Sesi::whereDate('waktu_selesai', now()->toDateString())->count();
            $sesiAktif = \App\Models\Sesi::where('waktu_mulai', '<=', now())
                ->where('waktu_selesai', '>=', now())
                ->count();
    
            // Calculate pendapatan and waktu penggunaan (assuming Rp 5000 per hour)
            $pendapatan = \App\Models\Sesi::whereDate('waktu_mulai', now()->toDateString())
                ->get()
                ->sum(function ($sesi) {
                    $durationHours = $sesi->durasi / 60; // durasi is in minutes
                    return $durationHours * 5000;
                });
    
            $waktuPenggunaan = \App\Models\Sesi::whereDate('waktu_mulai', now()->toDateString())
                ->get()
                ->sum('durasi') / 60; // convert minutes to hours
    
            return view('warnet.index', compact(
                'warnets',
                'totalKomputer',
                'komputerAktif',
                'komputerTersedia',
                'maintenance',
                'totalSesi',
                'sesiSelesai',
                'sesiAktif',
                'pendapatan',
                'waktuPenggunaan'
            ));
            return view('warnet.index');

        } elseif ($role == 'kasir') {
            $produks = Produk::orderBy('nama')->get();

            $pesananAktif = Pesanan::with('items.produk')
                                    ->where('status', 'selesai')
                                    ->whereDoesntHave('transaksi')
                                    ->latest()
                                    ->get();

            return view('kasir.index', compact('produks', 'pesananAktif'));
            return view('kasir.index');
        } else {
            // Jika role tidak dikenal, logout saja untuk keamanan
            Auth::logout();
            return redirect('/login');
        }
    }
}