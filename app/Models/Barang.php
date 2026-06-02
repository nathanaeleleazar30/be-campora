<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Barang extends Model
{
    protected $table = 'barangs';

    protected $primaryKey = 'id_barang';

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

    protected $casts = [
        'harga_per_hari' => 'decimal:2',
        'stok_total'     => 'integer',
        'is_aktif'       => 'boolean',
        'rating'         => 'float',
        'jumlah_review'  => 'integer',
    ];


    public function kategori(): BelongsTo
    {
        return $this->belongsTo(KategoriBarang::class, 'id_kategori', 'id_kategori');
    }

    public function fotos(): HasMany
    {
        return $this->hasMany(FotoBarang::class, 'id_barang', 'id_barang');
    }

    public function ketersediaans(): HasMany
    {
        return $this->hasMany(KetersediaanBarang::class, 'id_barang', 'id_barang');
    }
}
