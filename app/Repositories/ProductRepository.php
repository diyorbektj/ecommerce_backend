<?php

namespace App\Repositories;

use App\Models\Product;

class ProductRepository implements \App\Interfaces\ProductInterface
{
    public function getProduct($id): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Builder|array|null
    {
        $product = Product::query()->find($id);
        $product->increment('view');

        return $product;
    }

    public function allProducts(): \Illuminate\Database\Eloquent\Collection|array
    {
        return Product::query()->orderByDesc('created_at')->with('getProductAttribute')->get();
    }

    public function updateProduct($id, array $data): bool|int
    {
        return Product::query()->find($id)->update($data);
    }

    public function createProduct(array $data)
    {
        return Product::query()->create($data);
    }

    public function deleteProduct(int $id): bool
    {
        return Product::query()->find($id)->delete();
    }

    public function searchProduct($query): \Illuminate\Database\Eloquent\Collection|array
    {
        return Product::query()->where('name', 'like', '%'.$query.'%')->get();
    }
}
