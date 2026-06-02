<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Admin extends Model
{
    protected $table = 'admins';

    protected $primaryKey = 'id_admin';

    protected $fillable = [
        'username',
        'password_hash',
        'email',
    ];

    protected $hidden = [
        'password_hash',
    ];


    public function ketersediaans(): HasMany
    {
        return $this->hasMany(KetersediaanBarang::class, 'id_admin', 'id_admin');
    }

    public function testimonis(): HasMany
    {
        return $this->hasMany(Testimoni::class, 'id_admin', 'id_admin');
    }

    public function faqs(): HasMany
    {
        return $this->hasMany(Faq::class, 'id_admin', 'id_admin');
    }
}
