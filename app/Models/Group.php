<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasActivityLog;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Group extends Model
{
    use HasFactory, HasActivityLog;

    protected $fillable = [
        'name',
        'description',
        'logo',
        'website',
        'contact_person',
        'phone',
        'country_of_origin',
    ];

    /**
     * Get the brands associated with this group.
     */
    public function brands(): HasMany
    {
        return $this->hasMany(Brand::class);
    }
}
