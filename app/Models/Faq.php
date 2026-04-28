<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Faq extends Model
{
    /**
     * The table associated with the model.
     */
    protected $table = 'faqs';

    /**
     * The primary key for the model.
     */
    protected $primaryKey = 'id_faq';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'pertanyaan',
        'jawaban',
        'id_admin',
    ];

    // ----------------------------------------------------------------
    // Relationships
    // ----------------------------------------------------------------

    /**
     * A FAQ belongs to the admin who created it.
     */
    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'id_admin', 'id_admin');
    }
}
