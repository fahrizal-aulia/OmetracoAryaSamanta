<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PembelianMaterial extends Model
{
  protected $fillable = ['proyek_id', 'lokasi', 'tanggal_permintaan', 'status'];

public function proyek()
{
    return $this->belongsTo(Proyek::class);
}

}
