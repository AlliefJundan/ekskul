<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanEkskul extends Model
{
    use HasFactory;

    protected $table = 'pengajuan_ekskul';
    protected $primaryKey = 'id_pengajuan';
    protected $fillable = ['user_id', 'ekskul_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id_user');
    }

    public function ekskul()
    {
        return $this->belongsTo(Ekskul::class, 'ekskul_id', 'id_ekskul');
    }
}
