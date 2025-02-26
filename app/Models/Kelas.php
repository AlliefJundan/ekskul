<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;
    protected $table = 'kelas';
    protected $fillable = ['kelas', 'jurusan', 'nomor_kelas'];
    protected $primaryKey = 'id_kelas';
    public $timestamps = false;

    public function pengajuanEkskul()
    {
        return $this->hasMany(PengajuanEkskul::class, 'ekskul_id', 'id_ekskul');
    }
}
