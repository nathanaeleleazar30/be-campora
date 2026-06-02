<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FotoBarang extends Model
{
    protected $table = 'foto_barangs';

    protected $primaryKey = 'id_foto';

    protected $fillable = [
        'id_barang',
        'url_foto',
    ];


    public function barang(): BelongsTo
    {
        return $this->belongsTo(Barang::class, 'id_barang', 'id_barang');
    }
}
