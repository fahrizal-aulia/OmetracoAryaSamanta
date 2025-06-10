<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProjectControlController;
use App\Http\Controllers\ProjectControlProyekController;
use App\Http\Controllers\ProjectControlKontraktorController;
use App\Http\Controllers\ProjectControlPerkembanganProyekController;
use App\Http\Controllers\ProjectControlPembelianController;
use App\Http\Controllers\ProjectControlPenyewaanController;
use App\Http\Controllers\OwnerDashboardController;
use App\Http\Controllers\OwnerPerkembanganProyekController;
use App\Http\Controllers\PurchasingController;
use App\Http\Controllers\PurchasingPembelianController;
use App\Http\Controllers\PurchasingPenyewaanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProyekController;
use App\Http\Controllers\KontraktorController;
use App\Http\Controllers\PerkembanganProyekController;
use App\Http\Controllers\DokumentasiFotoController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\PenyewaanController;
use App\Http\Controllers\GrafikProyekController;

Route::get('/', function () {
    return view('welcome');
});

// ======================
// USER AUTH ROUTES
// ======================
Route::get('/login', [AuthController::class, 'showLogin'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/admin/login', [AuthController::class, 'showAdminLogin'])->name('admin.login.form');
Route::post('/admin/login', [AuthController::class, 'adminLogin'])->name('admin.login');
Route::post('/admin/logout', [AuthController::class, 'adminLogout'])->name('admin.logout');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register.form');
Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::resource('users', UserController::class);

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [ProyekController::class, 'dashboard'])->name('dashboard');
    Route::get('/project-control/dashboard', [ProjectControlController::class, 'dashboard'])->name('dashboard.projectControl');

    // Halaman statis/dummy
    Route::view('/data-proyek', 'pages.data-proyek')->name('data.proyek');
    Route::view('/data-kontraktor', 'pages.data-kontraktor')->name('data.kontraktor');
    Route::get('/perkembangan-proyek', [PerkembanganProyekController::class, 'index'])->name('perkembangan.proyek');
    Route::view('/pembelian-material', 'pages.pembelian')->name('pembelian.material');
    Route::view('/penyewaan-alat', 'pages.penyewaan')->name('penyewaan.alat');

    // Profile
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

    // Owner
    Route::middleware(['auth'])->group(function () {
    Route::get('/owner/dashboard', [OwnerDashboardController::class, 'index'])->name('owner.dashboard');
    Route::get('/owner/proyek', [ProyekController::class, 'indexOwner'])->name('owner.proyek.index');
    Route::prefix('owner')->name('owner.')->group(function () {
    Route::get('/perkembangan-proyek', [OwnerPerkembanganProyekController::class, 'index'])->name('perkembangan.index');
    Route::get('/perkembangan-proyek/{id}', [OwnerPerkembanganProyekController::class, 'show'])->name('perkembangan.view');
    });
    });

    // Purchasing
    Route::get('/purchasing/dashboard', [PurchasingController::class, 'index'])->name('purchasing.dashboard');
    Route::get('/purchasing/proyek', [ProyekController::class, 'indexPurchasing'])->name('purchasing.proyek.index');
    Route::get('/purchasing/pembelian-bahan', [PurchasingPembelianController::class, 'index'])->name('purchasing.pembelian-bahan');
    Route::get('/purchasing/pembelian-bahan/{id}/edit', [PurchasingPembelianController::class, 'edit'])->name('purchasing.pembelian-bahan.edit');
    Route::put('/purchasing/pembelian/{id}', [PurchasingPembelianController::class, 'update'])->name('purchasing.pembelian.update');
    Route::post('/purchasing/pembelian/{id}/validasi', [PurchasingPembelianController::class, 'validasi'])->name('purchasing.pembelian.validasi');
    Route::post('/purchasing/pembelian/{id}/batal-validasi', [PurchasingPembelianController::class, 'batalValidasi'])->name('purchasing.pembelian.batalValidasi');
    Route::get('/purchasing/pembelian-bahan/{id}', [PurchasingPembelianController::class, 'viewBahan'])->name('purchasing.pembelian-bahan.view');
    Route::get('/purchasing/penyewaan', [PurchasingPenyewaanController::class, 'index'])->name('purchasing.penyewaan.index');
    Route::get('/purchasing/penyewaan/{id}/edit', [PurchasingPenyewaanController::class, 'edit'])->name('purchasing.penyewaan.edit');
    Route::get('/purchasing/penyewaan/{id}', [PurchasingPenyewaanController::class, 'show'])->name('purchasing.penyewaan.view');

    // Project Control
    Route::get('/project-control/proyek', [ProjectControlProyekController::class, 'index']);
    Route::get('/projectcontrol/proyek', [ProyekController::class, 'indexProjectControl'])->name('projectcontrol.proyek.index');
    Route::get('/projectcontrol/proyek/create', [ProjectControlController::class, 'create'])->name('projectcontrol.proyek.create');
    Route::post('/projectcontrol/proyek', [ProjectControlController::class, 'store'])->name('projectcontrol.proyek.store');
    Route::delete('/projectcontrol/proyek/{id}', [ProjectControlController::class, 'destroy'])->name('projectcontrol.proyek.destroy');
    Route::get('/projectcontrol/proyek/{id}/edit', [ProjectControlController::class, 'edit'])->name('projectcontrol.proyek.edit');
    Route::put('projectcontrol/proyek/{id}', [ProjectControlController::class, 'update'])->name('projectcontrol.proyek.update');
    Route::get('/projectcontrol/kontraktors', [ProjectControlKontraktorController::class, 'index'])->name('projectcontrol.kontraktors.index');
    Route::get('/projectcontrol/perkembangan', [ProjectControlPerkembanganProyekController::class, 'index'])->name('projectcontrol.perkembangan.index');
    Route::get('/projectcontrol/perkembangan/upload/{proyek_id}', [ProjectControlPerkembanganProyekController::class, 'upload'])->name('projectcontrol.perkembangan.upload');
    Route::get('/projectcontrol/perkembangan/update/{id}', [ProjectControlPerkembanganProyekController::class, 'edit'])->name('projectcontrol.perkembangan.update');
    Route::post('/projectcontrol/perkembangan/{id}', [ProjectControlPerkembanganProyekController::class, 'store'])->name('projectcontrol.proyek.perkembangan.store');
    Route::get('/projectcontrol/perkembangan/{id}', [ProjectControlPerkembanganProyekController::class, 'view'])->name('projectcontrol.perkembangan.view');
    Route::post('/projectcontrol/perkembangan/upload-foto/{proyek_id}', [ProjectControlPerkembanganProyekController::class, 'storeUploadFoto'])->name('projectcontrol.perkembangan.upload.foto');
    Route::get('/projectcontrol/pembelian-bahan', [ProjectControlPembelianController::class, 'index'])->name('projectcontrol.pembelian.index');
    Route::get('/projectcontrol/pembelian-bahan/create', [ProjectControlPembelianController::class, 'create'])->name('projectcontrol.pembelian.create');
    Route::post('/projectcontrol/pembelian-bahan', [ProjectControlPembelianController::class, 'store'])->name('projectcontrol.pembelian.store');
    Route::delete('/projectcontrol/pembelian-bahan/{id}', [ProjectControlPembelianController::class, 'destroy'])->name('projectcontrol.pembelian.destroy');
    Route::get('/projectcontrol/pembelian-bahan/{id}/edit', [ProjectControlPembelianController::class, 'edit'])->name('projectcontrol.pembelian.edit');
    Route::put('projectcontrol/pembelian-bahan/{id}', [ProjectControlPembelianController::class, 'update'])->name('projectcontrol.pembelian.update');
    Route::get('/projectcontrol/pembelian-bahan/{id}', [ProjectControlPembelianController::class, 'viewBahan'])->name('projectcontrol.pembelian.view');
    Route::get('/projectcontrol/penyewaan', [ProjectControlPenyewaanController::class, 'index'])->name('projectcontrol.penyewaan.index');
    Route::get('/projectcontrol/penyewaan/create', [ProjectControlPenyewaanController::class, 'create'])->name('projectcontrol.penyewaan.create');
    Route::get('/projectcontrol/penyewaan/{id}/edit', [ProjectControlPenyewaanController::class, 'edit'])->name('projectcontrol.penyewaan.edit');
    Route::get('/projectcontrol/penyewaan/{id}', [ProjectControlPenyewaanController::class, 'show'])->name('projectcontrol.penyewaan.view');
    Route::delete('/projectcontrol/penyewaan/{id}', [ProjectControlPenyewaanController::class, 'destroy'])->name('projectcontrol.penyewaan.destroy');
    Route::post('/projectcontrol/penyewaan', [ProjectControlPenyewaanController::class, 'store'])->name('projectcontrol.penyewaan.store');
    Route::put('/projectcontrol/penyewaan/{id}', [ProjectControlPenyewaanController::class, 'update'])->name('projectcontrol.penyewaan.update');

    // CRUD Proyek
    Route::get('/proyek', [ProyekController::class, 'index'])->name('proyek.index');
    Route::get('/proyek/create', [ProyekController::class, 'create'])->name('proyek.create');
    Route::post('/proyek', [ProyekController::class, 'store'])->name('proyek.store');
    Route::get('/proyek/{id}/edit', [ProyekController::class, 'edit'])->name('proyek.edit');
    Route::put('/proyek/{id}', [ProyekController::class, 'update'])->name('proyek.update');
    Route::delete('/proyek/{id}', [ProyekController::class, 'destroy'])->name('proyek.destroy');

    // Kontraktor
    Route::resource('kontraktors', KontraktorController::class);

    // Perkembangan Proyek
    Route::get('/perkembangan', [PerkembanganProyekController::class, 'index'])->name('perkembangan.index');
    Route::get('/perkembangan/{id}/upload', [PerkembanganProyekController::class, 'upload'])->name('perkembangan.upload');
    Route::get('/perkembangan/{id}/update', [PerkembanganProyekController::class, 'edit'])->name('perkembangan.update');
    Route::get('/perkembangan/{id}/view', [PerkembanganProyekController::class, 'view'])->name('perkembangan.view');
    Route::post('/proyek/{id}/perkembangan/store', [PerkembanganProyekController::class, 'store'])->name('proyek.perkembangan.store');
    Route::get('/proyek/{id}/perkembangan', [PerkembanganProyekController::class, 'show'])->name('perkembangan.show');
    Route::get('/proyek/{id}/grafik', [GrafikProyekController::class, 'index'])->name('proyek.grafik');

    // Upload dokumentasi
    Route::get('/upload-foto', [DokumentasiFotoController::class, 'upload'])->name('upload.foto.form');
    Route::post('/upload-foto', [DokumentasiFotoController::class, 'store'])->name('upload.foto');

    // Pembelian bahan/material
    Route::get('/pembelian-bahan', [PembelianController::class, 'index'])->name('pembelian.index');
    Route::get('/pembelian-bahan/create', [PembelianController::class, 'create'])->name('pembelian.create');
    Route::post('/pembelian-bahan', [PembelianController::class, 'store'])->name('pembelian.store');
    Route::get('/pembelian/{id}/edit', [PembelianController::class, 'edit'])->name('pembelian.edit');
    Route::put('/pembelian/{id}', [PembelianController::class, 'update'])->name('pembelian.update');
    Route::get('/pembelian-bahan/{id}', [PembelianController::class, 'viewBahan'])->name('pembelian.bahan');
    Route::delete('/pembelian/{id}', [PembelianController::class, 'destroy'])->name('pembelian.destroy');
    Route::post('/pembelian/{id}/validasi', [PembelianController::class, 'validasi'])->name('pembelian.validasi');
    Route::post('/pembelian/{id}/batal-validasi', [PembelianController::class, 'batalValidasi'])->name('pembelian.batalValidasi');

    // Penyewaan alat
    Route::resource('penyewaan', PenyewaanController::class);
    Route::post('/penyewaan', [PenyewaanController::class, 'store'])->name('penyewaan.store');
    Route::put('/penyewaan/{id}', [PenyewaanController::class, 'update'])->name('penyewaan.update');
    Route::get('/penyewaan/{id}', [PenyewaanController::class, 'show'])->name('penyewaan.view');
    Route::put('/penyewaan/{id}/validasi', [PenyewaanController::class, 'validasi'])->name('penyewaan.validasi');
    Route::put('/penyewaan/{id}/batalkan-validasi', [PenyewaanController::class, 'batalkanValidasi'])->name('penyewaan.batalkanValidasi');
});

use Illuminate\Support\Facades\Log;

Route::get('/test-log', function () {
    Log::error('Log ini seharusnya muncul.');
    return 'Log telah dicoba';
});


// Tambahan route logout backup
Route::post('/logout', function () {
    Auth::logout();
    return redirect()->route('login.form');
})->name('logout');
