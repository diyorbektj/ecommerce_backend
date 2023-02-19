<?php

namespace App\Interfaces;

interface UserInterface
{
    public function getUser($id);

    public function allUsers();

    public function updateUser($id, array $data);

    public function createUser(array $data);

    public function deleteUser($id): bool;
}
