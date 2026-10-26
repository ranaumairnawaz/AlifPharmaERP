<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasActivityLog;

class SalaryPayment extends Model
{
    use HasActivityLog;
    protected $fillable = [
        'employee_id',
        'payment_month',
        'base_salary',
        'off_days',
        'off_days_deduction',
        'manual_adjustment',
        'adjustment_note',
        'net_salary',
        'status',
        'paid_at'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
