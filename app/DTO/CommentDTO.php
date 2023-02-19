<?php

namespace App\DTO;

class CommentDTO
{
    public static function toArray($data, $id)
    {
        return [
            'product_id' => $id,
            'user_id' => auth('sanctum')->id(),
            'comment' => $data['text'],
        ];
    }
}
