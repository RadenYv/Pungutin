<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $table = 'teams';
    protected $primaryKey = 'id_team';

    protected $fillable = [
        'id_truck',
        'tanggal'
    ];

    public function truck()
    {
        return $this->belongsTo(PickupTruck::class, 'id_truck', 'id_truck');
    }

    public function members()
    {
        return $this->hasMany(TeamPetugas::class, 'id_team', 'id_team');
    }

    public function petugas()
    {
        return $this->belongsToMany(
            Petugas::class,
            'team_petugas',
            'id_team',
            'id_petugas'
        );
    }

    public function batches()
    {
        return $this->hasMany(Batch::class, 'id_team', 'id_team');
    }
}
