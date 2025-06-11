<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Pembelian;
use App\Models\DetailPembelianMaterial;
use App\Models\Proyek;
use Carbon\Carbon;


class PembelianController extends Controller
{
    public function index(Request $request)
    {
        $query = Pembelian::with('proyek')->orderBy('tanggal_permintaan', 'desc');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('proyek', function ($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%');
            });
        }

        $data = $query->get();

        return view('pembelian.index', compact('data'));
    }

    public function create()
    {
        $proyeks = Proyek::all();
        return view('pembelian.create', compact('proyeks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'proyek_id' => 'required|exists:proyeks,id',
            'lokasi' => 'required',
            'tanggal_permintaan' => 'required|date',
            'status' => 'required',
            'materials.nama_material.*' => 'required',
            'materials.satuan.*' => 'required',
            'materials.status.*' => 'required',
        ]);

        $pembelian = Pembelian::create([
            'proyek_id' => $request->proyek_id,
            'lokasi' => $request->lokasi,
            'tanggal_permintaan' => $request->tanggal_permintaan,
            'status' => $request->status,
        ]);

        foreach ($request->materials['nama_material'] as $i => $nama) {
            $satuan = $request->materials['satuan'][$i];

            DetailPembelianMaterial::create([
                'pembelian_id' => $pembelian->id,
                'nama_material' => $nama,
                'satuan' => $satuan,
                'status' => $request->materials['status'][$i] ?? null,
                'jumlah' => $satuan === 'meter' ? null : ($request->materials['jumlah'][$i] ?? null),
                'panjang' => $satuan === 'meter' ? ($request->materials['panjang'][$i] ?? null) : null,
                'lebar' => $satuan === 'meter' ? ($request->materials['lebar'][$i] ?? null) : null,
                'tinggi' => $satuan === 'meter' ? ($request->materials['tinggi'][$i] ?? null) : null,
            ]);
        }

        return redirect()->route('pembelian.index')->with('success', 'Data pembelian berhasil disimpan.');
    }

    public function edit($id)
    {
        $pembelian = Pembelian::with('materials')->findOrFail($id);
        $proyeks = Proyek::all();
        return view('pembelian.edit', compact('pembelian', 'proyeks'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'proyek_id' => 'required',
            'lokasi' => 'required',
            'tanggal_permintaan' => 'required|date',
            'status' => 'required',
        ]);

        $pembelian = Pembelian::findOrFail($id);
        $pembelian->update([
            'proyek_id' => $request->proyek_id,
            'lokasi' => $request->lokasi,
            'tanggal_permintaan' => $request->tanggal_permintaan,
            'status' => $request->status,
        ]);

        $pembelian->materials()->delete();

        if ($request->has('materials')) {
            $materials = $request->materials;
            $count = count($materials['nama_material']);

            for ($i = 0; $i < $count; $i++) {
                $pembelian->materials()->create([
                    'nama_material' => $materials['nama_material'][$i],
                    'jumlah' => $materials['satuan'][$i] === 'meter' ? null : ($materials['jumlah'][$i] ?? null),
                    'panjang' => $materials['satuan'][$i] === 'meter' ? ($materials['panjang'][$i] ?? null) : null,
                    'lebar'   => $materials['satuan'][$i] === 'meter' ? ($materials['lebar'][$i] ?? null) : null,
                    'tinggi'  => $materials['satuan'][$i] === 'meter' ? ($materials['tinggi'][$i] ?? null) : null,
                    'satuan' => $materials['satuan'][$i],
                    'status' => $materials['status'][$i] ?? null,
                ]);
            }
        }

        return redirect()->route('pembelian.index')->with('success', 'Data berhasil diperbarui.');
    }

    public function viewBahan($id, Request $request)
    {
        $week = max(1, (int) $request->get('week', 1));
        $proyek = Proyek::findOrFail($id);
        $startDate = Carbon::parse($proyek->tanggal_mulai);

        $startOfWeek = $startDate->copy()->addWeeks($week - 1)->startOfWeek(Carbon::MONDAY);
        $endOfWeek = $startOfWeek->copy()->endOfWeek(Carbon::SUNDAY);

        $pembelian = Pembelian::with('materials')
            ->where('proyek_id', $id)
            ->whereBetween('tanggal_permintaan', [$startOfWeek, $endOfWeek])
            ->orderBy('tanggal_permintaan')
            ->get()
            ->groupBy('tanggal_permintaan');

        return view('pembelian.view', [
            'week' => $week,
            'startOfWeek' => $startOfWeek,
            'endOfWeek' => $endOfWeek,
            'pembelianPerTanggal' => $pembelian,
            'proyekId' => $id
        ]);
    }

    public function destroy($id)
    {
        $pembelian = Pembelian::findOrFail($id);
        $pembelian->materials()->delete();
        $pembelian->delete();

        return redirect()->route('pembelian.index')->with('success', 'Data pembelian berhasil dihapus.');
    }

    // ✅ Tambahan: Validasi
public function validasi($id)
{
    $pembelian = Pembelian::with(['materials', 'proyek'])->findOrFail($id);
    $pembelian->status = 'Disetujui';
    $pembelian->save();

    // Ambil nomor WA dan detail proyek
    $proyek = $pembelian->proyek;
    $nomor_wa =  $proyek->nomer_control;

    // Format nomor WA
    if (str_starts_with($nomor_wa, '0')) {
        $nomor_wa = '62' . substr($nomor_wa, 1);
    } else {
        $nomor_wa = $nomor_wa;
    }

    // Susun pesan
    $pesan = "Pembelian Bahan Material ID : {$pembelian->id}, Nama proyek : {$proyek->nama}, pada tanggal " .
              \Carbon\Carbon::parse($pembelian->tanggal_permintaan)->format('d F Y') . " pembelian bahan material telah diterima\n";
    $pesan .= "Detail bahan material :\n";

    foreach ($pembelian->materials as $material) {
        $pesan .= "- {$material->nama_material} : {$material->jumlah} {$material->satuan}\n";
    }

    $pesan .= "Pengiriman akan dilakukan mohon ditunggu";

    Log::info("Pesan WA ke {$nomor_wa}:\n" . $pesan);

    // Arahkan ke WhatsApp Web
    $pesan_encoded = urlencode($pesan);
    $wa_link = "https://wa.me/{$nomor_wa}?text={$pesan_encoded}";
    return redirect()->back()->with('wa_link', $wa_link);
}


public function batalValidasi($id)
{
    $pembelian = Pembelian::findOrFail($id);
    $pembelian->status = 'Ditolak'; // Atau 'belum divalidasi' sesuai kebutuhan
    $pembelian->save();

    return redirect()->back()->with('info', 'Validasi dibatalkan.');
}


    public function indexPurchasing(Request $request)
{
    $query = Pembelian::with('proyek');

    if ($request->filled('search')) {
        $query->whereHas('proyek', function($q) use ($request) {
            $q->where('nama', 'like', '%' . $request->search . '%');
        });
    }

    $data = $query->get();

    return view('purchasing.pembelian-bahan.index', compact('data'));
}
}
