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
    protected $primaryKey = 'id_ekskul';
    public $timestamps = false;

    public function pembina()
    {
        return $this->belongsTo(Jabatan::class, 'id_pembina', 'id_jabatan');
    }

    public function ketua()
    {
        return $this->belongsTo(Jabatan::class, 'id_ketua', 'id_jabatan');
    }

    public function sekertaris()
    {
        return $this->belongsTo(Jabatan::class, 'id_sekertaris', 'id_jabatan');
    }

    public function bendahara()
    {
        return $this->belongsTo(Jabatan::class, 'id_bendahara', 'id_jabatan');
    }
}
