<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ekskull extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_ekskul', // Tambahkan ini
        'nama_pembina',
        'nama_ketua',
        'jml_anggota',
    ];
}