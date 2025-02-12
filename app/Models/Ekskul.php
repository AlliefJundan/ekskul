<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ekskul extends Model
{
    use HasFactory;

    protected $table = 'ekskul';
    protected $fillable = ['nama_ekskul', 'slug', 'id_pembina', 'id_ketua', 'id_sekertaris', 'id_bendahara','jml_anggota','deskripsi','gambar'];
    protected $primaryKey = 'id_ekskul';
    public $timestamps = false;

    // Relasi ke User (mencari siapa yang memiliki jabatan tertentu)
    public function pembina()
    {
        return $this->belongsTo(Jabatan::class, 'id_pembina', 'id_jabatan')->with('user');
    }

    public function ketua()
    {
        return $this->belongsTo(Jabatan::class, 'id_ketua', 'id_jabatan')->with('user');
    }

    public function sekertaris()
    {
        return $this->belongsTo(Jabatan::class, 'id_sekertaris', 'id_jabatan')->with('user');
    }

    public function bendahara()
    {
        return $this->belongsTo(Jabatan::class, 'id_bendahara', 'id_jabatan')->with('user');
    }

    
}
