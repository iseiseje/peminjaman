<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommodityResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'category_id' => $this->category_id,
            'program_study_id' => $this->program_study_id,
            'item_code' => $this->item_code,
            'stock' => $this->stock,
            'condition' => $this->condition,
            'image' => $this->image ? asset('storage/' . $this->image) : null,
        ];
    }
}
