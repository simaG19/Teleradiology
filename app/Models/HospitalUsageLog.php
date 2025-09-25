<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HospitalUsageLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'hospital_id',
        'uploader_id',
        'batch_no',
        'file_count',
        'total_size',
        'cost',
        'upload_date',
    ];

    protected $casts = [
        'upload_date' => 'date',
        'cost' => 'decimal:2',
    ];

    public function hospital()
    {
        return $this->belongsTo(HospitalProfile::class, 'hospital_id');
    }

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploader_id');
    }
}
