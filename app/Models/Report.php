<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = ['assignment_id', 'pdf_path', 'notes'];

    public function assignment()
    {
        return $this->belongsTo(Assignment::class);
    }
}
