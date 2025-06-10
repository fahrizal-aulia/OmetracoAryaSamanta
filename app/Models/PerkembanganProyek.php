<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PerkembanganProyek extends Model
{
    protected $table = 'perkembangan_proyeks'; // Nama tabel

    protected $fillable = [
        'proyek_id',
        'minggu_ke',
        'tanggal_mulai',
        'tanggal_selesai',
        'struktur',
        'arsitektur',
        'tambah_kurang',
        'total_progres'
    ];
}
