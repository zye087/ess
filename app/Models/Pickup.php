<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pickup extends Model
{
    use HasFactory;

    protected $fillable = [
        'child_id', 
        'picked_by_parent_id', 
        'picked_by_guardian_id', 
        'picked_up_at',
        'verified_by'
    ];

    public function child()
    {
        return $this->belongsTo(Child::class);
    }

    public function parent()
    {
        return $this->belongsTo(ParentUser::class, 'picked_by_parent_id');
    }

    public function guardian()
    {
        return $this->belongsTo(Guardian::class, 'picked_by_guardian_id');
    }

   public function verifier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }
}
