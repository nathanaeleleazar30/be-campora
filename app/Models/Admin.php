<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Admin extends Model
{
    /**
     * The table associated with the model.
     */
    protected $table = 'admins';

    /**
     * The primary key for the model.
     */
    protected $primaryKey = 'id_admin';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'username',
        'password_hash',
        'email',
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'password_hash',
    ];

    // ----------------------------------------------------------------
    // Relationships
    // ----------------------------------------------------------------

    /**
     * An admin can manage many ketersediaan records.
     */
    public function ketersediaans(): HasMany
    {
        return $this->hasMany(KetersediaanBarang::class, 'id_admin', 'id_admin');
    }

    /**
     * An admin can moderate / create many testimonials.
     */
    public function testimonis(): HasMany
    {
        return $this->hasMany(Testimoni::class, 'id_admin', 'id_admin');
    }

    /**
     * An admin manages many FAQs.
     */
    public function faqs(): HasMany
    {
        return $this->hasMany(Faq::class, 'id_admin', 'id_admin');
    }
}
