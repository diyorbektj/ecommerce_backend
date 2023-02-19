<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository implements \App\Interfaces\UserInterface
{
    public function getUser($id)
    {
        return User::query()->findOrFail($id);
    }

    public function allUsers(): array
    {
        return User::all();
    }

    public function updateUser($id, array $data)
    {
        return User::query()->findOrFail($id)->update($data);
    }

    public function createUser(array $data)
    {
        return User::query()->create($data);
    }

    public function deleteUser($id): bool
    {
        return User::query()->find($id)->delete();
    }
}
