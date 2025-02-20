<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ekskul extends Model
{
    use HasFactory;

    protected $table = 'ekskul';
    protected $fillable = [
        'nama_ekskul',
        'slug',
        'jml_anggota',
        'deskripsi',
        'gambar'
    ];
    protected $primaryKey = 'id_ekskul';
    public $timestamps = false;

    // Relasi untuk mendapatkan pembina (jabatan = 1)
    public function pembina()
    {
        return $this->hasOne(EkskulUser::class, 'ekskul_id')
            ->where('jabatan', 1)
            ->with('user');
    }

    // Relasi untuk mendapatkan ketua (jabatan = 2)
    public function ketua()
    {
        return $this->hasOne(EkskulUser::class, 'ekskul_id')
            ->where('jabatan', 2)
            ->with('user');
    }
}
