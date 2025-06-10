<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Foto extends Model
{
    protected $fillable = ['dokumentasi_foto_id', 'file_path', 'caption'];

    public function dokumentasi()
    {
        return $this->belongsTo(DokumentasiFoto::class, 'dokumentasi_foto_id');
    }
}
