<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users'; // Menentukan nama tabel secara eksplisit
    protected $primaryKey = 'id_user'; // Menyesuaikan dengan migration

    public $timestamps = true; // Mengaktifkan timestamps (created_at & updated_at)

    protected $fillable = [
        'username',
        'password',
        'nama',
        'id_kelas',
        'id_ekskul',
        'id_jabatan',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'role' => 'string',
    ];

    /**
     * Relasi ke tabel kelas
     */
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas', 'id_kelas');
    }
}
