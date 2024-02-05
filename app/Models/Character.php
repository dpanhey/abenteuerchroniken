<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Character extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $fillable = [
        'name',
        'user_id',
        'familie',
        'geburtsort',
        'geburtsdatum',
        'alter',
        'geschlecht',
        'groesse',
        'gewicht',
        'haarfarbe',
        'augenfarbe',
        'titel',
        'sozialstatus',
        'charakteristiken',
        'hintergrundgeschichte',
        'andere_informationen',
        'ap_gesamt',
        'ap_verfuegbar',
        'ap_ausgegeben',
        'portrait_url',
        'lebendig',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function attributes(): HasOne
    {
        return $this->hasOne(Attribute::class);
    }

    public function adventures(): BelongsToMany
    {
        return $this->belongsToMany(Adventure::class);
    }
}
