<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HasilKuis extends Model
{
    use HasFactory;
    protected $table = 'hasil_kuis';
    protected $fillable = ['id_kuis', 'id_user', 'skor', 'bukti'];
    protected $timestamp = false;
    protected $primaryKey = 'id_hasil';

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}
