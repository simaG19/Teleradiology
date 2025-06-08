<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    //

  protected $fillable = [
    'image_id',
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


    public function assignedBy()
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }


}
