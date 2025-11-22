<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransaksiSampah extends Model
{
    protected $table = 'transaksi_sampah';
    protected $primaryKey = 'id_transaksi';
    public $incrementing = true;

    protected $fillable = [
        'id_user',
        'id_petugas',
        'id_kategori',
        'berat_kg',
        'berat_kg_final',
        'total_uang',
        'poin_didapat',
        'alamat',
        'no_hp',
        'catatan',
        'status',
    ];

    // Relasi ke user
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    // Relasi ke petugas
    public function petugas()
    {
        return $this->belongsTo(Petugas::class, 'id_petugas', 'id_petugas');
    }

    // Relasi ke kategori
    public function kategori()
    {
        return $this->belongsTo(KategoriSampah::class, 'id_kategori', 'id_kategori');
    }
}
