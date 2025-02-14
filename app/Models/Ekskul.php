<?php

namespace App\Models;

use App\Models\User;
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

    // Relasi ke User melalui tabel pivot
    public function users()
    {
        return $this->belongsToMany(User::class, 'ekskul_user', 'ekskul_id', 'user_id')
            ->withPivot('jabatan')
            ->withTimestamps();
    }
}
