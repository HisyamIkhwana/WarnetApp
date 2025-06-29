<?php

namespace App\Http\Controllers;

use App\Models\Sesi;
use App\Models\Komputer;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SesiController extends Controller
{
    public function index()
    {
        $sesis = Sesi::with('komputer')->latest()->get();
        $komputers = Komputer::orderBy('merk')->get();
        return view('sesi.index', compact('sesis', 'komputers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'komputer_id' => [
                'required',
                'exists:komputers,id',
                Rule::unique('sesis')->where(function ($query) {
                    return $query->where('waktu_selesai', '>', now());
                })
            ],
            'durasi' => 'required|integer|min:1',
            'redirect_to' => 'nullable|string' // Validasi untuk redirect
        ], [
            'komputer_id.unique' => 'Komputer ini sudah memiliki sesi yang aktif.'
        ]);

        $waktu_mulai = now();
        // Cast durasi to integer to prevent type error
        $waktu_selesai = now()->addHours((int)$validated['durasi']);

        Sesi::create([
            'komputer_id' => $validated['komputer_id'],
            'waktu_mulai' => $waktu_mulai,
            'waktu_selesai' => $waktu_selesai,
            'durasi' => $validated['durasi'],
        ]);

        $komputer = Komputer::find($validated['komputer_id']);
        if($komputer) {
            $komputer->status = 'terpakai';
            $komputer->save();
        }

        // Redirect dinamis
        $redirectRoute = $validated['redirect_to'] ?? 'sesi.index';
        return redirect()->route($redirectRoute)->with('success', 'Sesi baru berhasil dimulai!');
    }

    /**
     * Memperbarui data sesi yang ada.
     */
    public function update(Request $request, Sesi $sesi)
    {
        $validated = $request->validate([
            'komputer_id' => 'required|exists:komputers,id',
            'durasi' => 'required|integer|min:1',
        ]);
        
        // Cast durasi to integer and recalculate end time
        $waktu_selesai = \Carbon\Carbon::parse($sesi->waktu_mulai)->addHours((int)$validated['durasi']);

        $sesi->update([
            'komputer_id' => $validated['komputer_id'],
            'durasi' => $validated['durasi'],
            'waktu_selesai' => $waktu_selesai,
        ]);

        return redirect()->route('sesi.index')->with('success', 'Sesi berhasil diperbarui.');
    }

    /**
     * Menghapus data sesi.
     */
    public function destroy(Sesi $sesi)
    {     
        // Kembalikan status komputer menjadi 'tersedia' jika sesi masih aktif
        if (now()->lt($sesi->waktu_selesai)) {
            $komputer = Komputer::find($sesi->komputer_id);
            if($komputer) {
                $komputer->status = 'tersedia';
                $komputer->save();
            }
        }
        
        $sesi->delete();

        return redirect()->route('sesi.index')->with('success', 'Sesi berhasil dihapus.');
    }
}