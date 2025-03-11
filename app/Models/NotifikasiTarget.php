<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class NotifikasiTarget extends Model
{

    protected $table = 'notifikasi_target';
    protected $primaryKey = 'id_target';
    protected $fillable = ['id_notifikasi', 'id_user', 'is_read'];
    public $timestamps = true;

    public function notifikasi()
    {
        return $this->belongsTo(Notifikasi::class, 'id_notifikasi', 'id_notifikasi');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}
