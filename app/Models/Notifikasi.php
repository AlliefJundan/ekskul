<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notifikasi extends Model
{

    protected $table = 'notifikasi';
    protected $primaryKey = 'id_notifikasi';
    protected $fillable = ['title', 'category', 'id_ekskul', 'id_user', 'description', 'is_read'];
    public $timestamps = true;

    public function ekskul()
    {
        return $this->belongsTo(Ekskul::class, 'id_ekskul', 'id_ekskul');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function getUrlAttribute()
    {
        $ekskul = $this->ekskul; // Pastikan relasi sudah ada

        switch ($this->category) {
            case 'materi':
                return route('materi.index', ['slug' => $ekskul->slug]);
            case 'kuis':
                return route('kuis.show', ['slug' => $ekskul->slug]);
            case 'Pendaftaran':
                return route('pendaftaran.show', ['slug' => $ekskul->slug]);
            case 'diterima':
                return route('ekskul.show', ['slug' => $ekskul->slug]);
            case 'kegiatan':
                return route('ekskul.show', ['slug' => $ekskul->slug]);
            case 'pendaftaran':
                return route('dashboard_admin');
            default:
                return route('dashboard_admin'); // Default jika kategori tidak dikenali
        }
    }
}
