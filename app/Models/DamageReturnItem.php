<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DamageReturnItem extends Model
{
    protected $fillable = [
        'damage_report_id',
        'product_id',
        'quantity_returned',
        'unit_cost',
    ];

    public function damageReport(): BelongsTo
    {
        return $this->belongsTo(DamageReport::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class); // The packaging material
    }
}
