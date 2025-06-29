<?php

namespace App\Http\Controllers;

use App\Models\Warnet;
use Illuminate\Http\Request;

class WarnetController extends Controller
{
    public function index()
    {
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
    }

}
