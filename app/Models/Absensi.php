<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;

    protected $table = 'absensi';
    protected $primaryKey = 'id_absensi';
    public $timestamps = false;

    protected $fillable = [
        'id_ekskul',
        'id_user',
        'tanggal',
        'kehadiran',
        'status',
    ];

    public function ekskul()
    {
        return $this->belongsTo(Ekskul::class, 'id_ekskul');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}