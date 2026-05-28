<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Barang extends Model
{
    /**
     * The table associated with the model.
     */
    protected $table = 'barangs';

    /**
     * The primary key for the model.
     */
    protected $primaryKey = 'id_barang';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'id_kategori',
        'nama_barang',
        'merk',
        'spesifikasi',
        'harga_per_hari',
        'stok_total',
        'is_aktif',
        'rating',
        'jumlah_review',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'harga_per_hari' => 'decimal:2',
        'stok_total'     => 'integer',
        'is_aktif'       => 'boolean',
        'rating'         => 'float',
        'jumlah_review'  => 'integer',
    ];

    // ----------------------------------------------------------------
    // Relationships
    // ----------------------------------------------------------------

    /**
     * A barang belongs to a single kategori.
     */
    public function kategori(): BelongsTo
    {
        return $this->belongsTo(KategoriBarang::class, 'id_kategori', 'id_kategori');
    }

    /**
     * A barang can have many photos.
     */
    public function fotos(): HasMany
    {
        return $this->hasMany(FotoBarang::class, 'id_barang', 'id_barang');
    }

    /**
     * A barang can have many ketersediaan (availability) records.
     */
    public function ketersediaans(): HasMany
    {
        return $this->hasMany(KetersediaanBarang::class, 'id_barang', 'id_barang');
    }
}
