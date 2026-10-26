<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasActivityLog;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Brand extends Model
{
    use HasFactory, HasActivityLog;

    protected $fillable = [
        'name',
        'description',
        'group_id',
    ];

    /**
     * Get the group that this brand belongs to.
     */
    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }

    /**
     * Get the products for this brand.
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
