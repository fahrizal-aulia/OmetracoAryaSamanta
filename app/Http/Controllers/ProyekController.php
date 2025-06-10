<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proyek;
use App\Models\Perkembangan;

class ProyekController extends Controller
{
    public function index(Request $request)
    {
        $query = Proyek::query();

        if ($request->filled('search')) {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('tanggal_mulai')) {
            $query->where('tanggal_mulai', '>=', $request->tanggal_mulai);
        }

        if ($request->filled('tanggal_selesai')) {
            $query->where('tanggal_selesai', '<=', $request->tanggal_selesai);
        }

        $proyeks = $query->orderBy('tanggal_mulai')->get();

        return view('proyek.index', compact('proyeks'));
    }

    // Menambahkan method untuk menampilkan data ke dashboard
    public function dashboard(Request $request)
    {
        // Mengambil data proyek, misalnya yang memiliki deadline terdekat
        $proyeks = Proyek::orderBy('tanggal_selesai')->take(5)->get(); // Ambil 5 proyek dengan deadline terdekat

        return view('dashboard', compact('proyeks'));  // Mengirimkan data proyek ke view dashboard
    }

    public function create()
    {
        return view('proyek.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'lokasi' => 'required',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
        ]);

        Proyek::create($request->only('nama', 'lokasi', 'tanggal_mulai', 'tanggal_selesai'));

        return redirect()->route('proyek.index')->with('success', 'Proyek berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $proyek = Proyek::findOrFail($id);
        return view('proyek.edit', compact('proyek'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'lokasi' => 'required',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
        ]);

        $proyek = Proyek::findOrFail($id);
        $proyek->update($request->only('nama', 'lokasi', 'tanggal_mulai', 'tanggal_selesai'));

        return redirect()->route('proyek.index')->with('success', 'Proyek berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $proyek = Proyek::findOrFail($id);
        $proyek->delete();

        return redirect()->route('proyek.index')->with('success', 'Proyek berhasil dihapus.');
    }
    
    public function indexOwner(Request $request)
{
    $query = Proyek::query();

    if ($request->filled('search')) {
        $query->where('nama', 'like', '%' . $request->search . '%');
    }

    if ($request->filled('tanggal_mulai')) {
        $query->where('tanggal_mulai', '>=', $request->tanggal_mulai);
    }

    if ($request->filled('tanggal_selesai')) {
        $query->where('tanggal_selesai', '<=', $request->tanggal_selesai);
    }

    $proyeks = $query->orderBy('tanggal_mulai')->get();

    return view('owner.proyek.index', compact('proyeks'));
}

public function indexPurchasing(Request $request)
{
    $query = Proyek::query();

    if ($request->filled('search')) {
        $query->where('nama', 'like', '%' . $request->search . '%');
    }

    if ($request->filled('tanggal_mulai')) {
        $query->where('tanggal_mulai', '>=', $request->tanggal_mulai);
    }

    if ($request->filled('tanggal_selesai')) {
        $query->where('tanggal_selesai', '<=', $request->tanggal_selesai);
    }

    $proyeks = $query->orderBy('tanggal_mulai')->get();

    return view('purchasing.proyek.index', compact('proyeks'));
}
public function indexProjectControl()
{
    $proyeks = Proyek::all(); // Atau logika lain yang kamu perlukan
    return view('projectcontrol.proyek.index', compact('proyeks'));
}
}
