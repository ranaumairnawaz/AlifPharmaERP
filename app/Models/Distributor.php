<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

use App\Traits\HasActivityLog;

class Distributor extends Model
{
    use HasFactory, HasActivityLog;

    protected $fillable = [
        'name',
        'company_name',
        'contact_name',
        'area',
        'phone',
        'street_address',
        'city',
        'is_active',
    ];

    public function inventorySlips(): HasMany
    {
        return $this->hasMany(InventorySlip::class);
    }
}
