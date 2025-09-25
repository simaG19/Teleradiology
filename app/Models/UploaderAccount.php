<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
// extend Authenticatable if you want them to log in

class UploaderAccount extends Authenticatable
{
    protected $fillable = [
        'hospital_id','name','email','password',
    ];

    protected $hidden = [
        'password',
    ];

    public function hospitalProfile()
    {
        return $this->belongsTo(HospitalProfile::class, 'hospital_id');
    }
}
