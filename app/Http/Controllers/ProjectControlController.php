<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proyek;

class ProjectControlController extends Controller
{
    public function dashboard()
    {
        $proyeks = Proyek::with('perkembangan')->get();
        return view('projectcontrol.dashboard', compact('proyeks'));
    }
        public function create()
    {
        return view('projectcontrol.proyek.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'lokasi' => 'required',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'nomer_control' => 'required',
        ]);

        Proyek::create($request->only('nama', 'lokasi', 'tanggal_mulai', 'tanggal_selesai', 'nomer_control'));

        return redirect()->route('projectcontrol.proyek.index')->with('success', 'Proyek berhasil ditambahkan.');
    }

     public function edit($id)
    {
        $proyek = Proyek::findOrFail($id);
        return view('projectcontrol.proyek.edit', compact('proyek'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'lokasi' => 'required',
            'nomer_control' => 'required|numeric|digits_between:8,15',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required',
        ]);

        $proyek = Proyek::findOrFail($id);
        $proyek->update($request->only('nama', 'lokasi', 'tanggal_mulai', 'tanggal_selesai', 'nomer_control'));

        return redirect()->route('projectcontrol.proyek.index')->with('success', 'Proyek berhasil diperbarui.');
    }
    public function destroy($id)
    {
        $proyek = Proyek::findOrFail($id);
        $proyek->delete();

        return redirect()->route('projectcontrol.proyek.index')->with('success', 'Proyek berhasil dihapus.');
    }
}
