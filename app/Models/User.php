<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

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
     * Relationship with the Kelas model
     */
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas', 'id_kelas');
    }
    public function ekskul()
    {
        return $this->belongsTo(Ekskul::class, 'id_ekskul');
    }
    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class, 'id_jabatan');
    }
}
