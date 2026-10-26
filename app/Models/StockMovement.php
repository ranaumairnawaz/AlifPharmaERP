<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StockMovement extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'type', // 'in' or 'out'
        'quantity',
        'notes',
        'transaction_date',
        'material_entry_id',
        'price_per_unit',
        'lot_number',
        'expiry_date',
    ];

    protected $casts = [
        'quantity'         => 'decimal:3',
        'transaction_date' => 'datetime',
        'price_per_unit'   => 'decimal:2',
        'expiry_date'      => 'date',
    ];

    public function materialEntry(): BelongsTo
    {
        return $this->belongsTo(MaterialEntry::class);
    }

    /**
     * Get the product associated with this stock movement.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
