<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Materi extends Model
{
    use HasFactory;

    protected $table = 'materi';
    protected $primaryKey = 'id_materi'; // Tambahkan ini untuk menghindari error "Unknown column 'materi.id'"
    public $incrementing = true; // Pastikan jika id_materi adalah auto-increment
    protected $keyType = 'int'; // Pastikan id_materi bertipe integer

    protected $fillable = ['id_ekskul', 'id_user', 'isi_materi', 'lampiran_materi'];

    public function ekskul()
    {
        return $this->belongsTo(Ekskul::class, 'id_ekskul', 'id_ekskul');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}
