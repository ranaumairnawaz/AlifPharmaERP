<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasActivityLog;

class Expense extends Model
{
    use HasActivityLog;
    protected $fillable = [
        'amount',
        'category',
        'ref_type',
        'ref_id',
        'description',
        'expense_date',
        'status',
        'payment_method',
    ];

    protected $casts = [
        'expense_date' => 'date',
        'amount'       => 'decimal:2',
    ];

    public function categoryLabel(): string
    {
        return match($this->category) {
            'Material Procurement' => 'Material Purchase',
            'Salary'               => 'Salary Payment',
            default                => $this->category,
        };
    }
}
