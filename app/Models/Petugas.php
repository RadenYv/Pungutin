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

    // Relasi
    public function teamMemberships()
    {
        return $this->hasMany(TeamPetugas::class, 'id_petugas', 'id_petugas');
    }

    public function teams()
    {
        return $this->belongsToMany(
            Team::class,
            'team_petugas',
            'id_petugas',
            'id_team'
        );
    }
}
