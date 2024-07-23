<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Adventure extends Model implements HasMedia
{
    use HasFactory;
    use HasSlug;
    use InteractsWithMedia;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'cover',
        'status',
        'public'
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('cover')
            ->singleFile()
            ->useDisk('adventure-media')
            ->withResponsiveImages();

        $this->addMediaCollection('description_media')
            ->useDisk('adventure-media');
    }

    public function casts(): array
    {
        return [
            'public' => 'boolean',
        ];
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug')
            ->slugsShouldBeNoLongerThan(50);
    }

    public function getCoverUrl(): string
    {
        if (!$this->hasMedia('cover')) {
            return '';
        }
        return $this->getFirstMediaUrl('cover');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function chapters(): HasMany
    {
        return $this->hasMany(Chapter::class);
    }

    public function locations(): BelongsToMany
    {
        return $this->belongsToMany(Location::class);
    }

    public function nonPlayerCharacters(): BelongsToMany
    {
        return $this->belongsToMany(NonPlayerCharacter::class);
    }

    public function enemies(): BelongsToMany
    {
        return $this->belongsToMany(Enemy::class);
    }
}
