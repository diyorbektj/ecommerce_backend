<?php

namespace App\DTO;

use Illuminate\Support\Facades\Hash;

class UserDTO
{
    public static function toArray(array $data): array
    {
        return [
            'login' => $data['login'],
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'avatar_url' => "/storage/users/avatar/{$data['login']}.png",
            'password' => Hash::make($data['password']),
        ];
    }
}
