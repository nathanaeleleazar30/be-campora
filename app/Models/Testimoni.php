<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Testimoni extends Model
{
    /**
     * The table associated with the model.
     */
    protected $table = 'testimonis';

    /**
     * The primary key for the model.
     */
    protected $primaryKey = 'id_testimoni';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'nama_customer',
        'foto_customer',
        'rating',
        'isi_review',
        'id_admin',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'rating'   => 'integer',
        'id_admin' => 'integer',
    ];

    // ----------------------------------------------------------------
    // Relationships
    // ----------------------------------------------------------------

    /**
     * A testimoni may optionally belong to an admin (nullable).
     */
    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'id_admin', 'id_admin')->withDefault();
    }
}
