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

class PerkembanganProyekController extends Controller
{
    public function index()
    {
        $perkembangans = PerkembanganProyek::latest()->get(); 
        $proyeks = Proyek::all();
        return view('perkembangan.index', compact('perkembangans','proyeks'));
    }

    public function store(Request $request, $id)
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

    return redirect()->route('perkembangan.index')->with('success', 'Data perkembangan berhasil disimpan.');
}

    public function edit($id)
    {
        $proyek = Proyek::findOrFail($id);
        return view('perkembangan.update', compact('proyek'));
    }

    public function showPerkembanganProyek($id)
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
    
    $dokumentasi = DokumentasiFoto::where('proyek_id', $id)->get();

    return view('perkembangan.view', compact(
        'proyek', 'labels', 'struktur', 'arsitektur', 'tambah_kurang', 'total_progres', 'dokumentasi'
    ));
}


public function view($id)
{
    $proyek = Proyek::findOrFail($id);

$data = PerkembanganProyek::where('proyek_id', $id)
        ->orderBy('tanggal_mulai')
        ->get();

   $labels = $data->map(function ($item) {
    return "Minggu " . $item->minggu_ke . "\n" .
        \Carbon\Carbon::parse($item->tanggal_mulai)->format('d M') . " - " .
        \Carbon\Carbon::parse($item->tanggal_selesai)->format('d M');
})->toArray();

    $struktur = $data->pluck('struktur');
    $arsitektur = $data->pluck('arsitektur');
    $tambah_kurang = $data->pluck('tambah_kurang');
    $total = $data->pluck('total_progres');

$dokumentasi = DokumentasiFoto::where('proyek_id', $id)
                    ->orderBy('minggu_ke')
                    ->get()
                    ->groupBy('minggu_ke');
    return view('perkembangan.view', compact('labels', 'struktur', 'arsitektur', 'tambah_kurang', 'total','dokumentasi'));
}
public function upload()
{
    return view('perkembangan.upload');
}

public function storeUploadFoto(Request $request)
{
    $request->validate([
        'photos.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'captions.*' => 'nullable|string|max:255',
        'weekly_note' => 'nullable|string',
    ]);

    $data = [];

    if ($request->hasFile('photos')) {
        foreach ($request->file('photos') as $index => $photo) {
            if ($photo) {
                $path = $photo->store('public/photos');
                $data[] = [
                    'photo_path' => Storage::url($path),
                    'caption' => $request->captions[$index] ?? '',
                ];
            }
        }
    }

    $output = [
        'weekly_note' => $request->weekly_note,
        'photos' => $data,
    ];

    Storage::put('public/photo_upload_data.json', json_encode($output, JSON_PRETTY_PRINT));

    return back()->with('success', 'Foto dan keterangan berhasil diunggah!');
}
}