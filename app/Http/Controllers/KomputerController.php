<?php

namespace App\Http\Controllers;

use App\Models\Komputer;
use App\Models\Warnet;
use Illuminate\Http\Request;

class KomputerController extends Controller
{
    public function index()
    {
        $komputers = Komputer::latest()->paginate(10);
        return view('komputer.index', compact('komputers'));
    }

    public function create()
    {
        $warnets = Warnet::all();
        return view('komputer.create', compact('warnets'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'warnet_id' => 'required|exists:warnets,id',
            'merk' => 'required|string|max:255',
            'spesifikasi' => 'required|string|max:255',
            'status' => 'required|boolean',
        ]);

        Komputer::create($validated);

        return redirect()->route('komputer.index')->with('success', 'Komputer berhasil ditambahkan.');
    }

    public function edit(Komputer $komputer)
    {
        $warnets = Warnet::all();
        return view('komputer.edit', compact('komputer', 'warnets'));
    }

    public function update(Request $request, Komputer $komputer)
    {
        $validated = $request->validate([
            'warnet_id' => 'required|exists:warnets,id',
            'merk' => 'required|string|max:255',
            'spesifikasi' => 'required|string|max:255',
            'status' => 'required|boolean',
        ]);

        $komputer->update($validated);

        return redirect()->route('komputer.index')->with('success', 'Komputer berhasil diperbarui.');
    }

    public function destroy(Komputer $komputer)
    {
        $komputer->delete();
        return redirect()->route('komputer.index')->with('success', 'Komputer berhasil dihapus.');
    }
}