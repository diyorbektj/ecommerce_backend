<?php

namespace App\DTO;

class AddressDTO
{
    public static function toArray(array $data, $order_id)
    {
        return [
            'order_id' => $order_id,
            'fullname' => $data['fullname'],
            'email' => $data['email'] ?? NULL,
            'phone_number' => $data['phone_number'],
            'country' => 'Tajikistan',
            'region' => $data['region'] ?? NULL,
            'city' => $data['city'],
            'street' => $data['street'],
            'postcode' => $data['postcode'] ?? NULL,
            'guid' => $data['guid'],
            'user_id' => auth('sanctum')->id() ?? 1,
        ];
    }
}
