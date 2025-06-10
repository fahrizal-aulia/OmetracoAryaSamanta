<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proyek;

class OwnerDashboardController extends Controller
{
    public function index()
    {
        $proyeks = Proyek::all(); // Ambil semua data proyek
    return view('owner.dashboard', compact('proyeks'));
    }
}
