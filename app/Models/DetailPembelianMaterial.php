<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPembelianMaterial extends Model
{

    protected $table = 'detail_pembelian_materials';

    protected $fillable = [
        'pembelian_id', 'nama_material', 'jumlah', 'satuan',
        'panjang', 'lebar', 'tinggi', 'status', 'keterangan'
    ];

    public function pembelian()
    {
        return $this->belongsTo(Pembelian::class, 'pembelian_id', 'id');
    }
}
