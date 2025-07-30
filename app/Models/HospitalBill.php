<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HospitalBill extends Model
{
    use HasFactory;

    protected $fillable = [
        'hospital_id',
        'bill_year',
        'bill_month',
        'files_uploaded',
        'monthly_fee',
        'per_file_fee',
        'total_amount',
        'status',
        'due_date',
        'paid_date',
    ];

    protected $casts = [
        'due_date' => 'date',
        'paid_date' => 'date',
        'monthly_fee' => 'decimal:2',
        'per_file_fee' => 'decimal:2',
        'total_amount' => 'decimal:2',
    ];

    public function hospital()
    {
        return $this->belongsTo(HospitalProfile::class, 'hospital_id');
    }

    public function getMonthNameAttribute()
    {
        return date('F', mktime(0, 0, 0, $this->bill_month, 1));
    }

    public function getBillPeriodAttribute()
    {
        return $this->month_name . ' ' . $this->bill_year;
    }
}
