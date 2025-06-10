<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    use HasFactory;

    protected $fillable = [
        'proyek_id', 'lokasi', 'tanggal_permintaan', 'status',
    ];

    public function proyek()
    {
        return $this->belongsTo(Proyek::class);
    }

    public function materials()
    {
        return $this->hasMany(DetailPembelianMaterial::class, 'pembelian_id');
    }
}
