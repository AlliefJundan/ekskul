<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kegiatan extends Model
{
    protected $table = 'kegiatan';
    protected $primaryKey = 'id_kegiatan';
    public $timestamps = false;

    protected $fillable = ['id_ekskul', 'hari', 'waktu_mulai', 'waktu_berakhir'];

    public function ekskul()
    {
        return $this->belongsTo(Ekskul::class, 'id_ekskul', 'id_ekskul');
    }
}
