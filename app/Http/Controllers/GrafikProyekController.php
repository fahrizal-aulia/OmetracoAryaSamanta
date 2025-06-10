<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PerkembanganProyek;

class GrafikProyekController extends Controller
{
    public function index($proyek_id)
    {
        $data = PerkembanganProyek::where('proyek_id', $proyek_id)
                    ->orderBy('tanggal')
                    ->get();

        $labels = $data->pluck('tanggal')->map(function ($date) {
            return \Carbon\Carbon::parse($date)->format('d M');
        });

        return view('grafik', [
            'labels' => $labels,
            'struktur' => $data->pluck('struktur'),
            'arsitektur' => $data->pluck('arsitektur'),
            'tambah_kurang' => $data->pluck('tambah_kurang'),
            'total_progres' => $data->pluck('total_progres'),
        ]);
    }
    public function tambahPerkembangan($id)
{
    $proyek = Proyek::findOrFail($id);
    return view('perkembangan.tambah', compact('proyek'));
}

public function simpanPerkembangan(Request $request, $id)
{
    $validated = $request->validate([
        'minggu_ke' => 'required|integer',
        'tanggal_mulai' => 'required|date',
        'tanggal_selesai' => 'required|date',
        'struktur' => 'required|numeric',
        'arsitektur' => 'required|numeric',
        'tambah_kurang' => 'required|numeric',
        'total_progres' => 'required|numeric',
    ]);

    PerkembanganProyek::create([
        'proyek_id' => $id,
        'minggu_ke' => $validated['minggu_ke'],
        'tanggal_mulai' => $validated['tanggal_mulai'],
        'tanggal_selesai' => $validated['tanggal_selesai'],
        'struktur' => $validated['struktur'],
        'arsitektur' => $validated['arsitektur'],
        'tambah_kurang' => $validated['tambah_kurang'],
        'total_progres' => $validated['total_progres'],
    ]);
    return redirect()->route('perkembangan.view', $id)->with('success', 'Data perkembangan berhasil disimpan.');
}

public function lihatPerkembangan($id)
{
    $perkembangan = Perkembangan::where('proyek_id', $id)->orderBy('minggu_ke')->get();

    $labels = $perkembangan->pluck('minggu_ke');
    $struktur = $perkembangan->pluck('struktur');
    $arsitektur = $perkembangan->pluck('arsitektur');
    $tambah_kurang = $perkembangan->pluck('tambah_kurang');
   $total = $perkembangan->pluck('total_progres')->toArray();

    return view('perkembangan.view', compact('labels', 'struktur', 'arsitektur', 'tambah_kurang', 'total_progres'));
}
}
