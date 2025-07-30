<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HospitalProfile extends Model
{
    protected $fillable = [
    'user_id',
    'monthly_file_limit',
    'uploader_account_limit',
    'billing_rate',
    'is_active'
];


    /**
     * The hospital user that this profile belongs to.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function uploaders()
{
    return $this->hasMany(UploaderAccount::class, 'hospital_id');
}
  public function usageLogs()
    {
        return $this->hasMany(HospitalUsageLog::class, 'hospital_id');
    }

}
