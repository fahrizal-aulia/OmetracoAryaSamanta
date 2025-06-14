<?php

namespace App\Http\Controllers;

use App\Models\Penyewaan;
use App\Models\AlatPenyewaan;
use Illuminate\Http\Request;
use App\Models\Proyek;
use Carbon\Carbon;

class ProjectControlPenyewaanController extends Controller
{
    // Menampilkan semua penyewaan, sudah digrouping berdasarkan nama proyek + bulan tahun
    public function index(Request $request)
    {
        $keyword = $request->input('cari');

        $query = Penyewaan::with('alatPenyewaan')
            ->orderBy('nama_proyek')
            ->orderBy('tanggal_permintaan');

        // Filter berdasarkan keyword jika ada
        if ($keyword) {
            $query->where('nama_proyek', 'like', "%{$keyword}%");
        }

        $penyewaans = $query->get()->groupBy(function ($item) {
            return $item->nama_proyek . '|' . Carbon::parse($item->tanggal_permintaan)->format('Y-m');
        });

        return view('projectcontrol.penyewaan.index', compact('penyewaans'));
    }

    // Tampilkan form tambah penyewaan
    public function create()
    {
        $proyeks = Proyek::all();
        return view('projectcontrol.penyewaan.create', compact('proyeks'));
    }

    // Simpan data penyewaan
    public function store(Request $request)
    {
        $request->validate([
            'nama_proyek' => 'required',
            'lokasi' => 'required',
            'tanggal_permintaan' => 'required|date',
            'status' => 'required|in:disetujui,ditolak,menunggu',

            // Validasi array alat
            'nama_alat' => 'required|array',
            'mulai_jam' => 'required|array',
            'selesai_jam' => 'required|array',
            'total_jam_kerja' => 'required|array',
            'jumlah_alat' => 'required|array',
            'satuan' => 'required|array',
            'volume_docket' => 'nullable|array',
            'kumulatif' => 'nullable|array',
        ]);

        // Simpan penyewaan utama
        $penyewaan = Penyewaan::create([
            'nama_proyek' => $request->nama_proyek,
            'lokasi' => $request->lokasi,
            'tanggal_permintaan' => $request->tanggal_permintaan,
            'status' => $request->status,
        ]);

        // Simpan alat-alat
        foreach ($request->nama_alat as $i => $nama) {
            AlatPenyewaan::create([
                'penyewaan_id' => $penyewaan->id,
                'nama_alat' => $nama,
                'mulai_jam' => $request->mulai_jam[$i],
                'selesai_jam' => $request->selesai_jam[$i],
                'total_jam_kerja' => $request->total_jam_kerja[$i],
                'jumlah_alat' => $request->jumlah_alat[$i],
                'satuan' => $request->satuan[$i],
                'volume_docket' => $request->volume_docket[$i] ?? null,
                'kumulatif' => $request->kumulatif[$i] ?? null,
            ]);
        }

        return redirect()->route('projectcontrol.penyewaan.index')->with('success', 'Data penyewaan berhasil ditambahkan.');
    }

    // Tampilkan detail penyewaan dengan filter bulan (jika ada)
    public function show(Request $request, $id)
    {
        $penyewaan = Penyewaan::findOrFail($id);

        $defaultBulan = Carbon::parse($penyewaan->tanggal_permintaan)->format('Y-m');
        $bulan = $request->input('bulan', $defaultBulan);

        $tanggalAwal = Carbon::parse($bulan)->startOfMonth();
        $tanggalAkhir = Carbon::parse($bulan)->endOfMonth();

        // Tampilkan alat hanya jika bulan penyewaan sama dengan filter bulan
        $alatPenyewaan = ($tanggalAwal->month == Carbon::parse($penyewaan->tanggal_permintaan)->month
            && $tanggalAwal->year == Carbon::parse($penyewaan->tanggal_permintaan)->year)
            ? $penyewaan->alatPenyewaan
            : collect();

        $penyewaan->setRelation('alatPenyewaan', $alatPenyewaan);

        return view('projectcontrol.penyewaan.view', compact('penyewaan'));
    }

    // Tampilkan form edit penyewaan
    public function edit($id)
    {
        $penyewaan = Penyewaan::with('alatPenyewaan')->findOrFail($id);
        $proyeks = Proyek::all();
        $alatList = $penyewaan->alatPenyewaan ?? collect();

        return view('projectcontrol.penyewaan.edit', compact('penyewaan', 'proyeks', 'alatList'));
    }

    // Update data penyewaan
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_proyek' => 'required',
            'lokasi' => 'required',
            'tanggal_permintaan' => 'required|date',
        ]);

        $penyewaan = Penyewaan::findOrFail($id);

        // Update data utama
        $penyewaan->update([
            'nama_proyek' => $request->nama_proyek,
            'lokasi' => $request->lokasi,
            'tanggal_permintaan' => $request->tanggal_permintaan,
        ]);

        // Update status hanya jika status dikirim bukan 'tetap'
        if (in_array($request->status, ['disetujui', 'ditolak'])) {
            $penyewaan->status = $request->status;
            $penyewaan->save();
        }

        return redirect()->route('projectcontrol.penyewaan.index')->with('success', 'Penyewaan berhasil diperbarui.');
    }

    // Hapus penyewaan dan alat terkait
    public function destroy($id)
    {
        $penyewaan = Penyewaan::findOrFail($id);
        $penyewaan->delete();
        return redirect()->route('projectcontrol.penyewaan.index')->with('success', 'Data penyewaan berhasil dihapus.');
    }
}