<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Testimoni extends Model
{
    protected $table = 'testimonis';

    protected $primaryKey = 'id_testimoni';

    protected $fillable = [
        'nama_customer',
        'foto_customer',
        'rating',
        'isi_review',
        'produk_disewa',
        'kegiatan',
        'id_admin',
        'is_approved',
    ];

    protected $casts = [
        'rating'      => 'integer',
        'id_admin'    => 'integer',
        'is_approved' => 'boolean',
    ];


    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'id_admin', 'id_admin')->withDefault();
    }
}
