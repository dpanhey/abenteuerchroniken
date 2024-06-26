<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdventureResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'cover' => $this->cover,
            'user' => $this->whenLoaded('user', fn () => UserResource::make($this->user)),
            'chapters' => $this->whenLoaded('chapters', fn () => ChapterResource::collection($this->chapters)),
            'locations' => $this->whenLoaded('locations', fn () => LocationResource::collection($this->locations)),
            'description' => $this->description,
            'html' => $this->html,
            'public' => $this->public,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
