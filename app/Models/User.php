<?php

namespace App\Models;


use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users'; // Explicitly define the table name
    protected $primaryKey = 'id_user'; // Set the primary key to match the migration

    public $timestamps = false; // Disable timestamps since they're not present in migration

    protected $fillable = [
        'username',
        'password',
        'nama',
        'id_kelas',
        'id_ekskul',
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
     * Relationship with the Kelas model
     */
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas', 'id_kelas');
    }
    public function ekskuls()
    {
        return $this->belongsToMany(Ekskul::class, 'ekskul_user', 'user_id', 'ekskul_id')
            ->withPivot('jabatan') // Menyertakan kolom pivot seperti jabatan
            ->withTimestamps();
    }

    // Relasi ke Jabatan (jika diperlukan)
    public function ekskulUser()
    {
        return $this->hasOne(EkskulUser::class, 'user_id');
    }
    public function absensi()
    {
        return $this->hasMany(Absensi::class, 'id_user', 'id_user');
    }

    public function pengajuanEkskul()
    {
        return $this->hasMany(PengajuanEkskul::class, 'user_id', 'id_user');
    }
    
}
