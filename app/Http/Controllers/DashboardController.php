<?php

// app/Http/Controllers/DashboardController.php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Proyek;

class DashboardController extends Controller
{
    public function index()
    {
        $proyeks = Proyek::with('perkembangan')->get();

        return view('dashboard', [
            'proyeks' => $proyeks
        ]);
    }
    public function projectControl()
{
    return view('projectcontrol.dashboard');
}

}
