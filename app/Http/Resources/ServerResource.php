<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\CategoryResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ServerResource extends JsonResource
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
            'name' => $this->name,
            'image_thumbnail' => $this->getFirstMediaUrl('image', 'thumb'),
            'users' => UserResource::collection($this->whenLoaded('users')),
            'categories' => CategoryResource::collection($this->whenLoaded('categories')),
        ];
    }
}
