<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;

    protected $table = 'absensi';
    protected $primaryKey = 'id_absensi';

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
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
     public function getCurrentEkskul($id_ekskul)
    {
        return $this->where('user_id', auth()->user()->id_user)->where('ekskul_id', $id_ekskul)->first();
    }
}
