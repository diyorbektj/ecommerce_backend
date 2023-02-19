<?php

namespace App\Interfaces;

interface ProductInterface
{
    public function getProduct($id);

    public function allProducts();

    public function updateProduct($id, array $data);

    public function createProduct(array $data);

    public function deleteProduct(int $id);

    public function searchProduct($query);
}
