<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

use App\Traits\HasActivityLog;

class InventorySlip extends Model
{
    use HasFactory, HasActivityLog;

    protected $fillable = [
        'slip_number',
        'distributor_id',
        'transaction_date',
        'notes',
        'status',
        'is_net_invoiced',
        'is_warranty_invoiced',
    ];

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class, 'inventory_slip_id');
    }

    public function canGenerateNetInvoice(): bool
    {
        return !$this->is_net_invoiced;
    }

    public function canGenerateWarrantyInvoice(): bool
    {
        return !$this->is_warranty_invoiced;
    }

    protected $casts = [
        'transaction_date' => 'date',
    ];

    public function distributor(): BelongsTo
    {
        return $this->belongsTo(Distributor::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(InventorySlipItem::class);
    }

    /**
     * Generate the next AP-series slip number.
     */
    public static function nextSlipNumber()
    {
        $last = self::orderBy('id', 'desc')->first();
        if (!$last) {
            return 'AP00001';
        }

        $number = (int) str_replace('AP', '', $last->slip_number);
        return 'AP' . str_pad($number + 1, 5, '0', STR_PAD_LEFT);
    }
}
