<?php

namespace App\DTO;

class AddressDTO
{
    public static function toArray(array $data, $order_id)
    {
        return [
            'order_id' => $order_id,
            'fullname' => $data['fullname'],
            'email' => $data['email'] ?? null,
            'phone_number' => $data['phone_number'],
            'country' => 'Tajikistan',
            'region' => $data['region'] ?? null,
            'city' => $data['city'],
            'street' => $data['street'],
            'postcode' => $data['postcode'] ?? null,
            'guid' => $data['guid'],
            'user_id' => auth('sanctum')->id() ?? 1,
        ];
    }
}
