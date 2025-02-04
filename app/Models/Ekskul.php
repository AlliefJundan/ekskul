<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ekskul extends Model
{
    use HasFactory;

    protected $table = 'ekskul';
    protected $fillable = ['nama_ekskul', 'id_pembina', 'id_ketua', 'id_sekertaris', 'id_bendahara'];
    public $timestamps = false;

    // Relationship for 'pembina' (relating to 'id_pembina' in 'ekskul' and 'id_jabatan' in 'jabatan')
    public function pembina()
    {
        return $this->belongsTo(Jabatan::class, 'id_pembina', 'id_jabatan');
    }

    // Relationship for 'ketua' (relating to 'id_ketua' in 'ekskul' and 'id_jabatan' in 'jabatan')
    public function ketua()
    {
        return $this->belongsTo(Jabatan::class, 'id_ketua', 'id_jabatan');
    }

    // Relationship for 'sekertaris' (relating to 'id_sekertaris' in 'ekskul' and 'id_jabatan' in 'jabatan')
    public function sekertaris()
    {
        return $this->belongsTo(Jabatan::class, 'id_sekertaris', 'id_jabatan');
    }

    // Relationship for 'bendahara' (relating to 'id_bendahara' in 'ekskul' and 'id_jabatan' in 'jabatan')
    public function bendahara()
    {
        return $this->belongsTo(Jabatan::class, 'id_bendahara', 'id_jabatan');
    }
}
