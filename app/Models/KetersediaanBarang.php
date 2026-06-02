<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KetersediaanBarang extends Model
{
    protected $table = 'ketersediaan_barangs';

    protected $primaryKey = 'id_ketersediaan';

    protected $fillable = [
        'id_barang',
        'id_admin',
        'tanggal_mulai',
        'tanggal_selesai',
        'stok_disewa',
        'catatan',
    ];

    protected $casts = [
        'tanggal_mulai'   => 'date',
        'tanggal_selesai' => 'date',
        'stok_disewa'     => 'integer',
    ];


    public function barang(): BelongsTo
    {
        return $this->belongsTo(Barang::class, 'id_barang', 'id_barang');
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'id_admin', 'id_admin');
    }
}
