<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guardian extends Model
{
    /** @use HasFactory<\Database\Factories\GuardianFactory> */
    use HasFactory;

    protected $fillable = [
        'parent_id', 'qr_code', 'name', 'phone_number', 'address', 'relationship', 
        'id_type', 'id_number', 'photo', 'status'
    ];

    public function parent()
    {
        return $this->belongsTo(ParentUser::class, 'parent_id');
    }
}
