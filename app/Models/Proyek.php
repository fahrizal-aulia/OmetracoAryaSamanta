<?php

// app/Models/Proyek.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proyek extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'lokasi',
        'tanggal_mulai',
        'tanggal_selesai'
    ];
    public function perkembangan()
    {
        return $this->hasMany(PerkembanganProyek::class);
    }
}
