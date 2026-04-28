<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FotoBarang extends Model
{
    /**
     * The table associated with the model.
     */
    protected $table = 'foto_barangs';

    /**
     * The primary key for the model.
     */
    protected $primaryKey = 'id_foto';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'id_barang',
        'url_foto',
    ];

    // ----------------------------------------------------------------
    // Relationships
    // ----------------------------------------------------------------

    /**
     * A photo belongs to a single barang.
     */
    public function barang(): BelongsTo
    {
        return $this->belongsTo(Barang::class, 'id_barang', 'id_barang');
    }
}
