<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    public $incrementing = false;  // because ID is a UUID
    protected $keyType = 'string';

       protected $fillable = [
      'id',
      'uploader_id',
      'urgency',
      'clinical_history',
      'file_type_id',
      'quoted_price',
    ];
  public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function fileType()
    {
        return $this->belongsTo(FileType::class, 'file_type_id');
    }

    public function images()
    {
        return $this->hasMany(MedicalImage::class, 'batch_no', 'id');
    }


}
