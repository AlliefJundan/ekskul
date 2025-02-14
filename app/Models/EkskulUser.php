<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EkskulUser extends Model
{
    protected $table = 'ekskul_user';
    protected $fillable = ['user_id', 'ekskul_id', 'jabatan'];
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ekskul()
    {
        return $this->belongsTo(Ekskul::class);
    }

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class);
    }
}
