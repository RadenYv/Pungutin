<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeamPetugas extends Model
{
    protected $table = 'team_petugas';
    protected $primaryKey = 'id_team_petugas';

    protected $fillable = [
        'id_team',
        'id_petugas',
        'role'
    ];

    public function team()
    {
        return $this->belongsTo(Team::class, 'id_team', 'id_team');
    }

    public function petugas()
    {
        return $this->belongsTo(Petugas::class, 'id_petugas', 'id_petugas');
    }
}
