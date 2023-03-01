<?php

namespace App\DTO;

use Carbon\Carbon;

class CreateProductOrderDTO
{
    public static function toArray(array $data, $order_id): array
    {
        return [
            'order_id' => $order_id,
            'product_id' => $data['product_id'],
            'quantity' => $data['quantity'],
            'price' => $data['price'],
            'attributes' => json_encode($data['attributes']),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
