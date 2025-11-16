<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'id_user';
    public $incrementing = true;

    protected $fillable = [
        'nama',
        'email',
        'password',
        'no_hp',
        'saldo_total',
        'poin_total',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Relasi ke transaksi
    public function transaksi()
    {
        return $this->hasMany(TransaksiSampah::class, 'id_user', 'id_user');
    }
}
