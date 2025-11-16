<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Petugas extends Authenticatable
{
    use Notifiable;

    protected $table = 'petugas';
    protected $primaryKey = 'id_petugas';
    public $incrementing = true;

    protected $fillable = [
        'nama',
        'email',
        'password',
        'no_hp',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Relasi ke transaksi
    public function transaksi()
    {
        return $this->hasMany(TransaksiSampah::class, 'id_petugas', 'id_petugas');
    }
}
