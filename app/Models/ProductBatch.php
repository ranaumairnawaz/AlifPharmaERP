<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use App\Traits\HasActivityLog;

class ProductBatch extends Model
{
    use HasFactory, HasActivityLog;

    protected $fillable = [
        'product_id',
        'batch_number',
        'initial_quantity',
        'current_quantity',
        'mfg_date',
        'expiry_date',
        'rejected_quantity',
        'discarded_quantity',
        'status',
    ];

    protected $casts = [
        'mfg_date' => 'date',
        'expiry_date' => 'date',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
