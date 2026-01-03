<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Models\UploaderAccount;
class HospitalUpload extends Model
{
    use HasUuids;

    protected $table = 'hospital_uploads';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
      'id','file_count', 'quoted_price','hospital_id','uploader_id','zip_path',
      'urgency','clinical_history','file_type_id','status'
    ];

    public function hospital()
    {
        return $this->belongsTo(HospitalProfile::class);
    }
    public function assignments()
{
    return $this->hasMany(\App\Models\Assignment::class, 'hospital_upload_id');
}


 public function uploader()
    {
        return $this->belongsTo(UploaderAccount::class, 'uploader_id');
    }



    public function fileType()
    {
        return $this->belongsTo(FileType::class);
    }

    /**
     * All assignments for this batch, via its medical images.
     */
    // public function assignments()
    // {
    //     return $this->hasManyThrough(
    //         \App\Models\Assignment::class,     // The final model
    //         \App\Models\MedicalImage::class,   // The intermediate
    //         'batch_no',    // Foreign key on medical_images → hospital_uploads.id
    //         'image_id',    // Foreign key on assignments → medical_images.id
    //         'id',          // Local key on hospital_uploads
    //         'id'           // Local key on medical_images
    //     );
    // }
}
