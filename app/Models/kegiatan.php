<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class kegiatan extends Model
{
    protected $table = 'kegiatan';
    protected $fillable = ['id_kegiatan', 'id_ekskul', 'hari', 'waktu_mulai', 'waktu_berakhir'];
    protected $primaryKey = 'id_kegiatan';
    protected $timestamps = false;

    public function ekskul()
    {
        return $this->belongsTo(Ekskul::class, 'id_ekskul', 'id_ekskul');
    }
}
