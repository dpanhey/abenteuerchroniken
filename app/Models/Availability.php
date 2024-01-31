<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Availability extends Model
{
    use HasFactory;

    protected $fillable = [
        'starts_at', 'ends_at', 'user_id'
    ];

    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
