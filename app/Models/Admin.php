<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $table = 'admins';
    protected $primaryKey = 'id_admin';
    public $incrementing = true;

    protected $fillable = [
        'nama',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Jika nanti admin bisa assign petugas atau kelola transaksi
    public function transaksiDikelola()
    {
        return $this->hasMany(TransaksiSampah::class, 'id_admin', 'id_admin');
    }
}
