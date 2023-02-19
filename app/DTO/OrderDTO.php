<?php

namespace App\DTO;

class OrderDTO
{
    public static function toArray(array $data): array
    {
        return [
            'user_name' => $data['fullname'],
            'user_phone' => $data['phone_number'],
            'total_price' => $data['total_price'],
            'user_id' => 1,
            'guid' => $data['guid'],
            'status_id' => 1,
        ];
    }
}
