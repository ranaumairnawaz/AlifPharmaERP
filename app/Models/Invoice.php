<?php

namespace App\Models;

use App\Traits\HasActivityLog;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasActivityLog;

    protected $fillable = [
        'invoice_number', 'inventory_slip_id', 'project_manager_id', 'type', 
        'due_date', 'payment_status', 'paid_amount', 'subtotal_mrp', 'discount_percentage', 'discount_amount', 
        'adjustment_amount', 'grand_total', 'notes', 'created_by'
    ];

    protected $casts = [
        'due_date' => 'date',
    ];
    
    public function isNet()
    {
        return $this->type === 'net';
    }

    public function remainingBalance()
    {
        return $this->grand_total - $this->paid_amount;
    }

    public function projectManager()
    {
        return $this->belongsTo(ProjectManager::class);
    }

    public function slip()
    {
        return $this->belongsTo(InventorySlip::class, 'inventory_slip_id');
    }

    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public static function nextInvoiceNumber()
    {
        $last = self::orderBy('id', 'desc')->first();
        if (!$last) return 'INV-' . date('Y') . '-0001';

        $number = (int) substr($last->invoice_number, -4);
        return 'INV-' . date('Y') . '-' . str_pad($number + 1, 4, '0', STR_PAD_LEFT);
    }
}
