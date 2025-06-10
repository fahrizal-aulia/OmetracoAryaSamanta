<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PerkembanganProyek;
use App\Models\Proyek;
use App\Models\DokumentasiFoto;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ProjectControlPerkembanganProyekController extends Controller
{
    public function index()
    {
        $perkembangans = PerkembanganProyek::latest()->get();
        $proyeks = Proyek::all();
        return view('projectcontrol.perkembangan.index', compact('perkembangans','proyeks'));
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

        return redirect()->route('projectcontrol.perkembangan.index')->with('success', 'Data perkembangan berhasil disimpan.');
    }

    public function edit($id)
    {
        $proyek = Proyek::findOrFail($id);
        return view('projectcontrol.perkembangan.update', compact('proyek'));
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
        // $dokumentasi = DokumentasiFoto::with('fotos')->where('proyek_id', $id)->get();

        return view('projectcontrol.perkembangan.view', compact(
            'proyek', 'labels', 'struktur', 'arsitektur', 'tambah_kurang', 'total', 'dokumentasi'
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

        return view('projectcontrol.perkembangan.view', compact('proyek', 'labels', 'struktur', 'arsitektur', 'tambah_kurang', 'total', 'dokumentasi'));
    }

    // Form upload foto dengan parameter proyek_id
    public function upload($proyek_id)
    {
        $proyek = Proyek::findOrFail($proyek_id);
        return view('projectcontrol.perkembangan.upload', compact('proyek', 'proyek_id'));
    }

    // Simpan banyak foto dokumentasi sekaligus
    public function storeUploadFoto(Request $request, $proyek_id)
{
    Log::info("Masuk ke storeUploadFoto, proyek_id: $proyek_id");

    $request->validate([
        'minggu_ke' => 'required|integer|min:1',
        'photos.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'captions.*' => 'nullable|string|max:255',
    ]);

    $mingguKe = $request->input('minggu_ke');
    $photos = $request->file('photos');
    $captions = $request->input('captions');

    Log::info("Minggu ke: $mingguKe");
    Log::info("Jumlah foto: " . ($photos ? count($photos) : 0));

    if ($photos) {
        foreach ($photos as $index => $photo) {
            if ($photo) {
                $path = $photo->store('dokumentasi', 'public');
                Log::info("Foto ke-$index disimpan di: $path");

                DokumentasiFoto::create([
                    'proyek_id' => $proyek_id,
                    'minggu_ke' => $mingguKe,
                    'file_path' => $path,
                    'caption' => $captions[$index] ?? null,
                ]);

                Log::info("Data foto ke-$index berhasil disimpan ke database");
            } else {
                Log::warning("Foto ke-$index kosong");
            }
        }
    } else {
        Log::warning("Tidak ada foto ditemukan di request");
    }

    return redirect()
        ->route('projectcontrol.perkembangan.view', $proyek_id)
        ->with('success', 'Foto dan keterangan berhasil diunggah!');
}
}
