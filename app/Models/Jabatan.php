<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Jabatan extends Model
{
    use HasFactory;
    protected $table = 'jabatan';
    protected $fillable = ['kode_jabatan', 'nama_jabatan', 'slug', 'id_ekskul', 'id_user'];
    public $timestamps = false;

    public function ekskul()
    {
        return $this->belongsTo(Ekskul::class, 'id_ekskul', 'id_ekskul');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'user');
    }
}
