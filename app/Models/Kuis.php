<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kuis extends Model
{

    use HasFactory;
    protected $table = 'kuis';
    protected $fillable = ['nama_kuis', 'slug', 'isi_kuis', 'id_ekskul'];
    protected $primaryKey = 'id_kuis';
    public $timestamps = false;

    public function ekskul()
    {
        return $this->belongsTo(Ekskul::class, 'id_ekskul', 'id_ekskul');
    }
}
