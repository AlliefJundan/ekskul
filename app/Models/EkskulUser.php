<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EkskulUser extends Model
{
    use HasFactory;

    protected $table = 'ekskul_user';
    protected $fillable = ['user_id', 'ekskul_id', 'jabatan'];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi ke Ekskul
    public function ekskul()
    {
        return $this->belongsTo(Ekskul::class, 'ekskul_id');
    }

    public function getCurrentEkskul($id_ekskul)
    {
        return $this->where('user_id', auth()->user()->id_user)->where('ekskul_id', $id_ekskul)->first();
    }
}
