<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;

use Illuminate\Notifications\Notifiable;

class ParentUser extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'parent_users';

    protected $fillable = [
        'qr_code', 
        'name', 
        'email', 
        'password', 
        'phone_number', 
        'address',
        'parent_type', 
        'id_type', 
        'id_photo', 
        'profile_picture', 
        'email_verified_at', 
        'verification_token',
        'face_data'
    ];

    protected $hidden = ['password'];

    protected $casts = [
        'password' => 'hashed',
        'email_verified_at' => 'datetime',
        'face_data' => 'array',
    ];

    public function children(): HasMany
    {
        return $this->hasMany(Child::class, 'parent_id');
    }

}
