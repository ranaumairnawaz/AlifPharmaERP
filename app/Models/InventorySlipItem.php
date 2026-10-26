<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InventorySlipItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'inventory_slip_id',
        'product_id',
        'quantity',
        'quantity_cartons',
        'quantity_pieces',
        'total_pieces_deducted',
        'number_of_cartons',
    ];

    public function slip(): BelongsTo
    {
        return $this->belongsTo(InventorySlip::class, 'inventory_slip_id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
