<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasActivityLog;

class MaterialEntry extends Model
{
    use HasFactory, HasActivityLog;

    protected $fillable = [
        'slip_number',
        'source',
        'transaction_date',
        'total_amount',
        'notes',
        'payment_status',
        'paid_amount'
    ];

    protected $casts = [
        'transaction_date' => 'date',
        'total_amount'     => 'decimal:2',
        'paid_amount'      => 'decimal:2'
    ];

    public function stockMovements()
    {
        return $this->hasMany(StockMovement::class);
    }

    /**
     * Generate next material slip number.
     */
    public static function nextSlipNumber()
    {
        $last = self::orderBy('id', 'desc')->first();
        if (!$last) {
            return 'MAT-00001';
        }

        $number = (int) str_replace('MAT-', '', $last->slip_number);
        return 'MAT-' . str_pad($number + 1, 5, '0', STR_PAD_LEFT);
    }

    /**
     * Calculate outstanding balance for this material entry.
     */
    public function remainingBalance()
    {
        return max(0, $this->total_amount - ($this->paid_amount ?? 0));
    }
}
