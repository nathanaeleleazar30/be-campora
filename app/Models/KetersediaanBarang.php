<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KetersediaanBarang extends Model
{
    /**
     * The table associated with the model.
     */
    protected $table = 'ketersediaan_barangs';

    /**
     * The primary key for the model.
     */
    protected $primaryKey = 'id_ketersediaan';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'id_barang',
        'id_admin',
        'tanggal_mulai',
        'tanggal_selesai',
        'stok_disewa',
        'catatan',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'tanggal_mulai'   => 'date',
        'tanggal_selesai' => 'date',
        'stok_disewa'     => 'integer',
    ];

    // ----------------------------------------------------------------
    // Relationships
    // ----------------------------------------------------------------

    /**
     * A ketersediaan record belongs to a specific barang.
     */
    public function barang(): BelongsTo
    {
        return $this->belongsTo(Barang::class, 'id_barang', 'id_barang');
    }

    /**
     * A ketersediaan record belongs to the admin who created it.
     */
    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'id_admin', 'id_admin');
    }
}
