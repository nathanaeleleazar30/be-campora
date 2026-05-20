<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paket extends Model
{
    protected $table = 'pakets';
    protected $primaryKey = 'id_paket';

    protected $fillable = [
        'nama_paket',
        'gambar',
        'deskripsi',
        'items',
        'harga',
        'is_featured',
        'is_aktif',
    ];

    protected $casts = [
        'items'       => 'array',
        'harga'       => 'decimal:2',
        'is_featured' => 'boolean',
        'is_aktif'    => 'boolean',
    ];
}
