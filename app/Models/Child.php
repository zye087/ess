<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Child extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent_id', 'stud_id', 'name', 'birth_date', 'gender', 'class_name', 'photo', 'status'
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(ParentUser::class, 'parent_id');
    }
}