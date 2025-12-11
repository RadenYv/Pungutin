<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransaksiSampah extends Model
{
    protected $table = 'transaksi_sampah';
    protected $primaryKey = 'id_transaksi';

    protected $fillable = [
        'id_user',
        'id_kategori',
        'id_batch',
        'berat_kg',
        'berat_kg_final',
        'total_uang',
        'poin_didapat',
        'tanggal_pickup',
        'pickup_window',
        'alamat',
        'no_hp',
        'catatan',
        'status'
    ];

    // Relations
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function kategori()
    {
        return $this->belongsTo(KategoriSampah::class, 'id_kategori', 'id_kategori');
    }

    public function batch()
    {
        return $this->belongsTo(Batch::class, 'id_batch', 'id_batch');
    }
}
