<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Faq extends Model
{
    protected $table = 'faqs';

    protected $primaryKey = 'id_faq';

    protected $fillable = [
        'pertanyaan',
        'jawaban',
        'id_admin',
    ];


    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'id_admin', 'id_admin');
    }
}
