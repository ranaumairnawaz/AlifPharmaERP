<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasActivityLog;

class Income extends Model
{
    use HasActivityLog;
    protected $fillable = [
        'title',
        'category',
        'amount',
        'ref_type',
        'ref_id',
        'description',
        'income_date',
        'status',
    ];

    protected $casts = [
        'income_date' => 'date',
        'amount'      => 'decimal:2',
    ];

    /**
     * Fetch the related model (e.g., Invoice) via polymorphic-style ref.
     */
    public function reference()
    {
        if ($this->ref_type === 'Invoice') {
            return Invoice::find($this->ref_id);
        }
        return null;
    }

    /**
     * Category label for UI display.
     */
    public function categoryLabel(): string
    {
        return match($this->category) {
            'invoice_payment' => 'Invoice Payment',
            'advance_payment' => 'Advance Payment',
            'loan_received'   => 'Loan Received',
            default           => 'Other Income',
        };
    }
}
