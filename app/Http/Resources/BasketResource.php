<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BasketResource extends JsonResource
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
            'id' => $this->id ?? null,
            'user_id' => $this->user_id ?? null,
            'product_id' => $this->product_id,
            'product_name' => $this->product_name,
            'product_image' => $this->product_image,
            'quantity' => $this->quantity,
            'status' => $this->status,
            'price' => $this->price,
            'guid' => $this->guid,
            'id_hash' => $this->id_hash,
            'attributes' => json_decode($this->attributes),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
