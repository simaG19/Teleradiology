<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedicalImage extends Model
{
    //

     protected $fillable = [
    'uploader_id',
    'filename',
    'original_name',
    'mime_type',
    'status',
    'batch_no',
];

        // ← Add this method:
    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploader_id');
    }
}
