<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

use App\Traits\HasActivityLog;

class Product extends Model
{
    use HasFactory, HasActivityLog;

    protected $fillable = [
        'name',
        'description',
        'group_id',
        'brand_id',
        'category_id',
        'material_type',
        'unit_id',
        'pieces_per_carton',
        'cost_price',
        'sale_price',
        'mrp',
        'current_stock',
        'reorder_point',
    ];

    protected $casts = [
        'cost_price'    => 'decimal:2',
        'sale_price'    => 'decimal:2',
        'current_stock' => 'decimal:3', // Supported decimal mapping
        'reorder_point' => 'decimal:3',
    ];

    /**
     * Get the brand that the product belongs to (New Layer).
     */
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * Get the group directly (Facilitates Migration/Link during restructuring).
     */
    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }

    /**
     * Get the category that the product belongs to.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the unit that the product references.
     */
    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }

    /**
     * Get the stock movements for this product.
     */
    public function stockMovements(): HasMany
    {
        return $this->hasMany(StockMovement::class);
    }

    /**
     * Get the stock movements for this product.
     */
    public function batches(): HasMany
    {
        return $this->hasMany(ProductBatch::class)->where('status', 'active')->orderBy('expiry_date');
    }

    public function activeBatches()
    {
        return $this->batches()->where('current_quantity', '>', 0);
    }
}
