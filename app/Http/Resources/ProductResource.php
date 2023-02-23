<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => Str::limit($this->name, 150),
            'description' => $this->description,
            'price' => $this->price,
            'quantity' => $this->quantity,
            'status' => $this->status_id,
            'view' => $this->view,
            'image' => env('APP_URL', 'https://api.seb.tj').$this->image->path ?? null,
            'images' => ProductImageResource::collection($this->images),
            'created_at' => $this->created_at,
            'category' => $this->category,
            'subcategory' => $this->subcategory,
            'subcategory_id' => $this->subcategory_id,
            'brand_id' => $this->brand_id,
            'colors' => AttributeResource::collection($this->getProductAttribute->where('attribute_id', 2)),
            'sizes' => AttributeResource::collection($this->getProductAttribute->where('attribute_id', 1)),
        ];
    }
}
