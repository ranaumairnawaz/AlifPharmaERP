<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    protected $fillable = [
        'invoice_id', 
        'product_id', 
        'product_batch_id',
        'quantity', 
        'unit_price', 
        'gross_amount',
        'discount_percentage',
        'discount_value',
        'total_price'
    ];

    public function productBatch()
    {
        return $this->belongsTo(ProductBatch::class, 'product_batch_id');
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
