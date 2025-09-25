<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Report;
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

    public function report()
{
  return $this->hasOne(Report::class, 'batch_no', 'batch_no');
}

public function batch()
{
    return $this->belongsTo(Batch::class, 'batch_no', 'id');
}


public function fileType()
{
  return $this->belongsTo(FileType::class);
}


}
