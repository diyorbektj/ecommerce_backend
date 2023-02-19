<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSubCategoryRequest;
use App\Http\Requests\UpdateSubCategoryRequest;
use App\Http\Resources\SubCategoryResource;
use App\Repositories\SubCategoryRepository;
use App\Services\SubCategoryService;

class SubCategoryController extends Controller
{
    public SubCategoryRepository $subCategoryRepository;

    public SubCategoryService $subCategoryService;

    public function __construct(SubCategoryRepository $SubCategoryRepository, SubCategoryService $SubCategoryService)
    {
        $this->subCategoryRepository = $SubCategoryRepository;
        $this->subCategoryService = $SubCategoryService;
    }

    public function all(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return SubCategoryResource::collection($this->subCategoryRepository->allSubCategories());
    }

    public function store(CreateSubCategoryRequest $request): SubCategoryResource
    {
        return new SubCategoryResource($this->subCategoryService->createSubCategory($this->subCategoryRepository, $request->validated()));
    }

    public function edit(int $Id): SubCategoryResource
    {
        return new SubCategoryResource($this->subCategoryService->editSubCategory($this->subCategoryRepository, $Id));
    }

    public function update(UpdateSubCategoryRequest $request, int $Id): bool
    {
        return $this->subCategoryRepository->updateSubCategory($Id, $request->validated());
    }

    public function destroy(int $Id): mixed
    {
        return $this->subCategoryRepository->deleteSubCategory($Id);
    }

    public function getCategory(int $categoryId)
    {
        return SubCategoryResource::collection($this->subCategoryRepository->getCategory($categoryId));
    }
}
