<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasActivityLog;

class Employee extends Model
{
    use HasActivityLog;
    protected $fillable = [
        'employee_id', 
        'name', 
        'email', 
        'designation', 
        'base_salary', 
        'joining_date', 
        'account_number', 
        'bank_name', 
        'status'
    ];

    public function payments()
    {
        return $this->hasMany(SalaryPayment::class);
    }
}
