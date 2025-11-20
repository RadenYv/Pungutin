<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $guard = 'admin';   // 🟦 SUPER IMPORTANT

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

    public function transaksiDikelola()
    {
        return $this->hasMany(TransaksiSampah::class, 'id_admin', 'id_admin');
    }
}
