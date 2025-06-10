<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pembelian;
use App\Models\DetailPembelianMaterial;
use App\Models\Proyek;
use Carbon\Carbon;

class PurchasingPembelianController extends Controller
{
    public function index(Request $request)
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

    public function edit($id)
    {
        $pembelian = Pembelian::with('materials')->findOrFail($id);
        $proyeks = Proyek::all();
        return view('purchasing.pembelian-bahan.edit', compact('pembelian','proyeks'));
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

        return view('purchasing.pembelian-bahan.view', [
            'week' => $week,
            'startOfWeek' => $startOfWeek,
            'endOfWeek' => $endOfWeek,
            'pembelianPerTanggal' => $pembelian,
            'proyekId' => $id
        ]);
    }
}