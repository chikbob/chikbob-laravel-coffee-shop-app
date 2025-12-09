<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CoffeeResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            // цена в рублях — округлим в frontend, но вернём decimal
            'price' => $this->base_price,
            'size' => new SizeCoffeeResource($this->whenLoaded('size')),
            'image' => $this->image,
            'available' => (bool)$this->available,
            'created_at' => $this->created_at,
        ];
    }
}
