<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proyek;

class ProjectControlProyekController extends Controller
{
   public function index(Request $request)
{
    // Filter opsional dari form pencarian
    $query = Proyek::query();

    if ($request->filled('search')) {
        $query->where('nama', 'like', '%' . $request->search . '%');
    }

    if ($request->filled('tanggal_mulai')) {
        $query->whereDate('tanggal_mulai', '>=', $request->tanggal_mulai);
    }

    if ($request->filled('tanggal_selesai')) {
        $query->whereDate('tanggal_selesai', '<=', $request->tanggal_selesai);
    }

    $proyeks = $query->get();

    return view('projectcontrol.proyek.index', compact('proyeks'));
}
}
