<?php

namespace App\Http\Controllers;

use App\Models\Sesi;
use App\Models\Komputer;
use Illuminate\Http\Request;

class SesiController extends Controller
{
    public function index()
    {
        $sessi = Sesi::all();
        return view('sesi.index', compact('sessi'));
    }

    public function create()
    {
        $komputers = Komputer::all();
        return view('sesi.create', compact('komputers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'komputer_id' => 'required|exists:komputers,id',
            'durasi' => 'required|integer|min:1',
        ]);

        $waktu_mulai = now();
        $durasi = (int) $validated['durasi'];
        $waktu_selesai = $waktu_mulai->copy()->addHours($durasi);

        $sesiData = [
            'komputer_id' => $validated['komputer_id'],
            'waktu_mulai' => $waktu_mulai,
            'waktu_selesai' => $waktu_selesai,
        ];

        Sesi::create($sesiData);

        return redirect()->route('sesi.index')->with('success', 'Sesi berhasil ditambahkan.');
    }

    public function edit(Sesi $sesi)
    {
        $komputers = Komputer::all();
        return view('sesi.edit', compact('sesi', 'komputers'));
    }

    public function update(Request $request, Sesi $sesi)
    {
        $validated = $request->validate([
            'komputer_id' => 'required|exists:komputers,id',
            'waktu_mulai' => 'required|date',
            'waktu_selesai' => 'nullable|date|after_or_equal:waktu_mulai',
        ]);

        $sesi->update($validated);

        return redirect()->route('sesi.index')->with('success', 'Sesi berhasil diperbarui.');
    }

    public function destroy(Sesi $sesi)
    {
        $sesi->delete();
        return redirect()->route('sesi.index')->with('success', 'Sesi berhasil dihapus.');
    }
}