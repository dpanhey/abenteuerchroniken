<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attribute extends Model
{
    use HasFactory;

    protected $fillable = [
        'character_id',
        'mut',
        'klugheit',
        'intuition',
        'charisma',
        'fingerfertigkeit',
        'gewandtheit',
        'konstitution',
        'koerperkraft',
        'lebensenergie',
        'astralenergie',
        'karmaenergie',
        'seelenkraft',
        'zaehigkeit',
        'ausweichen',
        'initiative',
        'wundschwelle',
        'geschwindigkeit',
        'schicksalspunkte',
    ];

    public function character(): BelongsTo
    {
        return $this->belongsTo(Character::class);
    }
}
