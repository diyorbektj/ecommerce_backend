<?php

namespace App\Services;

use App\Repositories\SubCategoryRepository;

class SubCategoryService
{
    public function allSubCategories(SubCategoryRepository $subCategoryRepository)
    {
        return $subCategoryRepository->allSubCategories();
    }

    public function createSubCategory(SubCategoryRepository $subCategoryRepository, array $data)
    {
        return $subCategoryRepository->create($data);
    }

    public function editSubCategory(SubCategoryRepository $subCategoryRepository, $Id)
    {
        return $subCategoryRepository->editSubCategory($Id) ?? abort(404);
    }

    public function updateSubCategory(SubCategoryRepository $subCategoryRepository, array $data, int $Id): bool
    {
        return $subCategoryRepository->updateSubCategory($Id, $data) ?? abort(404);
    }

    public function deleteSubCategory(SubCategoryRepository $subCategoryRepository, int $Id)
    {
        return $subCategoryRepository->deleteSubCategory($Id) ?? abort(404);
    }
}
