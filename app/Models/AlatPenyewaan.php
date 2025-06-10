<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlatPenyewaan extends Model
{
    use HasFactory;

    protected $fillable = [
        'penyewaan_id',
        'nama_alat',
        'mulai_jam',
        'selesai_jam',
        'total_jam_kerja',
        'jumlah_alat',
        'satuan',
        'volume_docket',
        'kumulatif',
    ];

    public function penyewaan()
    {
        return $this->belongsTo(Penyewaan::class);
    }

     public function penyewaanAlatDetails()
    {
        return $this->hasMany(PenyewaanAlatDetail::class, 'penyewaan_id');
    }

}
