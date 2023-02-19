<?php

namespace App\Repositories;

use App\Interfaces\SubCategoryInterface;
use App\Models\SubCategory;

class SubCategoryRepository implements SubCategoryInterface
{
    public function editSubCategory($id): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Builder|array|null
    {
        return SubCategory::query()->find($id);
    }

    public function allSubCategories(): \Illuminate\Database\Eloquent\Collection
    {
        return SubCategory::all();
    }

    public function updateSubCategory($id, array $data): bool|int
    {
        return SubCategory::query()->find($id)->update($data);
    }

    public function create(array $data): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Builder
    {
        return SubCategory::query()->create($data);
    }

    public function deleteSubCategory(int $id)
    {
        return SubCategory::query()->find($id)->delete();
    }

    public function createSubCategory(array $data)
    {
        // TODO: Implement createSubCategory() method.
    }

    public function getCategory(int $categoryId)
    {
        return SubCategory::query()->where('category_id', $categoryId)->get();
    }
}
