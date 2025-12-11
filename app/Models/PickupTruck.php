<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PickupTruck extends Model
{
    protected $table = 'pickup_truck';
    protected $primaryKey = 'id_truck';
    protected $fillable = [
        'nama', 
        'plat_nomor',
        'kapasitas', 
        'warehouse', 
        'status',
    ];

    public function teams()
    {
        return $this->hasMany(Team::class, 'id_truck', 'id_truck');
    }

    public function batches()
    {
        return $this->hasManyThrough(
            Batch::class,
            Team::class,
            'id_truck',  // FK on Team
            'id_team',   // FK on Batch
            'id_truck',  // Local key
            'id_team'    // Team local key
        );
    }
}
