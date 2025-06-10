<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DokumentasiFoto extends Model
{
    use HasFactory;

    protected $fillable = [
        'proyek_id',
        'minggu_ke',
        'file_path',
        'caption',
    ];

public function fotos()
{
    return $this->hasMany(Foto::class);
}

}
