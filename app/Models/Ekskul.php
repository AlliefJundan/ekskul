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
    public function sekertaris()
    {
        return $this->hasOne(EkskulUser::class, 'ekskul_id')
            ->where('jabatan', 3)
            ->with('user');
    }
    public function bendahara()
    {
        return $this->hasOne(EkskulUser::class, 'ekskul_id')
            ->where('jabatan', 4)
            ->with('user');
    }
    // Relasi ke User melalui tabel pivot
    public function users()
    {
        return $this->belongsToMany(User::class, 'ekskul_user', 'ekskul_id', 'user_id')
            ->withPivot('jabatan')
            ->withTimestamps();
    }
}
