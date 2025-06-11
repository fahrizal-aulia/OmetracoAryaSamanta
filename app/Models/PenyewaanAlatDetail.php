<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenyewaanAlatDetail extends Model
{
    //
    public function proyek()
{
    return $this->belongsTo(Proyek::class);
}
}
