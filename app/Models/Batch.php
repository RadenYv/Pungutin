<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    protected $table = 'batches';
    protected $primaryKey = 'id_batch';

    protected $fillable = [
        'id_truck',
        'id_team',
        'tanggal',
        'pickup_window',
        'status'
    ];

    public function truck()
    {
        return $this->belongsTo(PickupTruck::class, 'id_truck', 'id_truck');
    }

    public function team()
    {
        return $this->belongsTo(Team::class, 'id_team', 'id_team');
    }

    public function transaksi()
    {
        return $this->hasMany(TransaksiSampah::class, 'id_batch', 'id_batch');
    }
    
    public function countTransaksi()
    {
        return $this->transaksi()->count();
    }

    public function isOpenForTransaksi()
    {
        return $this->status === 'pending' && $this->countTransaksi() < 5;
    }
}
