<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proyek;

class PurchasingController extends Controller
{
    public function index()
    {
        $proyeks = Proyek::with('perkembangan')->get();
        return view('purchasing.dashboard', compact('proyeks'));
    }
}