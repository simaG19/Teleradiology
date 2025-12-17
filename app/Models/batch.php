<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    public $incrementing = false;  // because ID is a UUID
    protected $keyType = 'string';

       protected $fillable = [
      'id',
      'paid',
      'tx_ref',
      'uploader_id',
      'urgency',
      'clinical_history',
      'file_type_id',
      'quoted_price',
       'archive_path',
        'confirmed',
    ];
  public function user()
{
    return $this->belongsTo(User::class, 'uploader_id', 'id');
}


        public function uploader()
    {
        return $this->belongsTo(\App\Models\UploaderAccount::class, 'uploader_id');
        // If uploader is in users table, use App\Models\User::class instead
        // return $this->belongsTo(\App\Models\User::class, 'uploader_id');
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
