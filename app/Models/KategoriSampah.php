<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriSampah extends Model
{
    protected $table = 'kategori_sampah';
    protected $primaryKey = 'id_kategori';
    public $incrementing = true;

    protected $fillable = [
        'nama_kategori',
        'harga_per_kg',
        'poin_per_kg',
    ];

    //Belasi antar Table
    public function transaksi()
    {
        return $this->hasMany(TransaksiSampah::class, 'id_kategori', 'id_kategori');
    }
    
}
