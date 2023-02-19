<?php

namespace App\DTO;

class ProductDTO
{
    public static function toArray(array $data): array
    {
        return [
            'name' => $data['name'],
            'description' => $data['description'],
            'price' => $data['price'],
            'quantity' => $data['quantity'],
            'category_id' => $data['category_id'],
            'subcategory_id' => $data['subcategory_id'],
            'status' => 1,
        ];
    }

    public function uploadImage(array $data, $id): array
    {
        $images = [];
        foreach ($data as $image) {
            $imageName = $image->getClientOriginalName();
            $path = $image->move(public_path('images'), $imageName);
            $images[] = ['name' => $imageName, 'path' => '/images/'.$imageName, 'product_id' => $id, 'created_at' => now(), 'updated_at' => now()];
        }

        return $images;
    }
}
