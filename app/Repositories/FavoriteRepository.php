<?php

namespace App\Repositories;

use App\Models\Favorit;

class FavoriteRepository implements \App\Interfaces\FavoriteInterface
{
    public function create($id): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Builder|null
    {
        return Favorit::query()->findOrNew([
            'user_id' => auth()->id(),
            'product_id' => $id,
        ]);
    }

    public function delete($id)
    {
        // TODO: Implement delete() method.
    }

    public function update($id)
    {
        // TODO: Implement update() method.
    }

    public function show()
    {
        return Favorit::query()->where('guid', \request()->input('guid'))->with('product')->get();
    }
}
