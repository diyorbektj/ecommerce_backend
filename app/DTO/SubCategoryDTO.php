<?php

namespace App\DTO;

class SubCategoryDTO
{
    public static function toArray(array $data)
    {
        return [
            'name' => $data['name'],
            'category_id' => $data['category_id'],
        ];
    }
}
