<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    //

  protected $fillable = [
    'image_id',
    'batch_id',
     'hospital_upload_id',
    'assigned_by',
    'assigned_to',
    'assigned_at',
    'deadline',
    'status',
];


        // ← Add this method:

         public function image()
{
    return $this->belongsTo(MedicalImage::class, 'image_id');
}

public function batch()
{
    return $this->belongsTo(\App\Models\Batch::class, 'batch_id');
}

public function hospitalUpload()
{
    return $this->belongsTo(HospitalUpload::class, 'hospital_upload_id');
}

public function report()
{
    return $this->hasOne(Report::class);
}




    public function assignedBy()
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }


}
