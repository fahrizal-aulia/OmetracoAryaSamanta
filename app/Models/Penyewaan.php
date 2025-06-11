<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penyewaan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_proyek',
        'lokasi',
        'tanggal_permintaan',
        'nama_alat',
        'mulai_jam',
        'selesai_jam',
        'total_jam_kerja',
        'jumlah_alat',
        'satuan',
        'volume_docket',
        'kumulatif',
        'status',
    ];
    public function alatPenyewaan()
{
    return $this->hasMany(AlatPenyewaan::class);
}
public function proyek()
{
    return $this->belongsTo(Proyek::class);
}


}
