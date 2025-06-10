<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PerkembanganProyek;
use App\Models\Perkembangan;
use App\Models\Proyek;
use App\Http\Controllers\GrafikProyekController;
use App\Http\Controllers\DokumentasiFotoController;
use App\Models\DokumentasiFoto;
use App\Models\Foto;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class OwnerPerkembanganProyekController extends Controller
{
    public function index()
{
    $proyeks = Proyek::all(); // Atau filter sesuai role owner

    return view('owner.perkembangan.index', compact('proyeks'));
}
public function show($id)
{
    $proyek = Proyek::findOrFail($id);
     $perkembangan = PerkembanganProyek::where('proyek_id', $id)
        ->orderBy('tanggal_mulai')
        ->get();

    $labels = $perkembangan->map(function ($item) {
        return "Minggu " . $item->minggu_ke . "\n" .
               \Carbon\Carbon::parse($item->tanggal_mulai)->format('d M') . " - " .
               \Carbon\Carbon::parse($item->tanggal_selesai)->format('d M');
    })->toArray();
    $struktur = $perkembangan->pluck('struktur')->toArray();
    $arsitektur = $perkembangan->pluck('arsitektur')->toArray();
    $tambah_kurang = $perkembangan->pluck('tambah_kurang')->toArray();
    $total = $perkembangan->pluck('total_progres')->toArray();

    // $dokumentasi = DokumentasiFoto::where('proyek_id', $id)->get();
    $dokumentasi = DokumentasiFoto::where('proyek_id', $id)
            ->orderBy('minggu_ke')
            ->get()
            ->groupBy('minggu_ke');

    return view('owner.perkembangan.view', compact(
        'proyek', 'labels', 'struktur', 'arsitektur', 'tambah_kurang', 'total', 'dokumentasi'
    ));
}

}
