<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GambarEkskul extends Model
{

    use HasFactory;
    protected $table = 'gambar_ekskul';
    protected $fillable = ['ekskul_id', 'gambar'];

    public function ekskul()
    {
        return $this->belongsTo(Ekskul::class, 'ekskul_id', 'id_ekskul');
    }
}
