<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FileType extends Model
{
    protected $fillable = ['name','anatomy','price_per_file'];
}
