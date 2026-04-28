<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KategoriBarang extends Model
{
    /**
     * The table associated with the model.
     */
    protected $table = 'kategori_barangs';

    /**
     * The primary key for the model.
     */
    protected $primaryKey = 'id_kategori';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'nama_kategori',
        'slug',
    ];

    // ----------------------------------------------------------------
    // Relationships
    // ----------------------------------------------------------------

    /**
     * A category has many items (barangs).
     */
    public function barangs(): HasMany
    {
        return $this->hasMany(Barang::class, 'id_kategori', 'id_kategori');
    }
}
