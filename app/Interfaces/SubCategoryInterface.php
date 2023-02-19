<?php

namespace App\Interfaces;

interface SubCategoryInterface
{
    public function editSubCategory($id);

    public function allSubCategories();

    public function updateSubCategory($id, array $data);

    public function createSubCategory(array $data);

    public function deleteSubCategory(int $id);

    public function getCategory(int $categoryId);
}
