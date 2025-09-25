<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Traits\HasRoles;
class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'hospital_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function hospitalProfile()
{
    return $this->hasOne(HospitalProfile::class, 'user_id');
}
/**
 * For a hospital user, the uploader accounts they created.
 */
public function uploaders()
{
    // Assumes 'hospital_id' on the users table points back to this hospital
    return $this->hasMany(User::class, 'hospital_id');
}
  public function assignments()
    {
        // 'assigned_to' is the foreign key on assignments pointing to users.id
        return $this->hasMany(Assignment::class, 'assigned_to');
    }

    public function hospital()
    {
        // Only define relationship if hospital_profiles table exists
        if (Schema::hasTable('hospital_profiles')) {
            return $this->belongsTo(HospitalProfile::class, 'hospital_id');
        }
        return null;
    }

    public function uploadedFiles()
    {
        return $this->hasMany(MedicalImage::class, 'uploader_id');
    }

    public function usageLogs()
    {
        // Only define relationship if hospital_usage_logs table exists
        if (Schema::hasTable('hospital_usage_logs')) {
            return $this->hasMany(HospitalUsageLog::class, 'uploader_id');
        }
        return collect(); // Return empty collection if table doesn't exist
    }

    // Helper method to check if user has a role
    // public function hasRole($role)
    // {
    //     return $this->role === $role;
    // }

    // Helper method to check if user has any of the given roles
    // public function hasAnyRole($roles)
    // {
    //     if (is_string($roles)) {
    //         $roles = [$roles];
    //     }
    //     return in_array($this->role, $roles);
    // }
}
