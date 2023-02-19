<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'product_id' => $this->product_id,
            'user_id' => $this->user_id,
            'like_count' => count($this->likes),
            'comment' => $this->comment,
            'created_at' => Carbon::make($this->created_at)->format('d.m.Y H:i'),
            'updated_at' => $this->updated_at,
            'like' => $this->likes,
            'user' => $this->user,
        ];
    }
}
