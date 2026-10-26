<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasActivityLog;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Unit extends Model
{
    use HasFactory, HasActivityLog;

    protected $fillable = [
        'name',
        'short_name',
        'description',
        'is_decimal',
        'is_active',
    ];

    protected $casts = [
        'is_decimal' => 'boolean',
        'is_active' => 'boolean',
    ];

    /**
     * Get the products associated with this unit.
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
