<?php

namespace App\Interfaces;

interface FavoriteInterface
{
    public function create($id);

    public function delete($id);

    public function update($id);

    public function show();
}
