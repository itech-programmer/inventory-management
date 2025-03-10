<?php

namespace App\Services;

use App\Contracts\ApiResponseServiceInterface;
use App\Contracts\CategoryServiceInterface;
use App\Contracts\CategoryRepositoryInterface;
use App\DTO\CategoryDto;
use Illuminate\Http\JsonResponse;

class CategoryService implements CategoryServiceInterface
{
    private CategoryRepositoryInterface $categoryRepository;
    private ApiResponseServiceInterface $apiResponse;

    public function __construct(
        CategoryRepositoryInterface $categoryRepository,
        ApiResponseServiceInterface $apiResponse
    ) {
        $this->categoryRepository = $categoryRepository;
        $this->apiResponse = $apiResponse;
    }

    public function getAll(): JsonResponse
    {
        return $this->apiResponse->success('Categories retrieved successfully',
            $this->categoryRepository->getAll());
    }

    public function findById(int $id): JsonResponse
    {
        $category = $this->categoryRepository->findById($id);

        return $category
            ? $this->apiResponse->success('Category found', $category)
            : $this->apiResponse->error('Category not found', [], 404);
    }

    public function getSubcategories(int $categoryId): JsonResponse
    {
        return $this->apiResponse->success('Subcategories retrieved successfully',
            $this->categoryRepository->getSubcategories($categoryId));
    }

    public function getByProvider(int $providerId): JsonResponse
    {
        return $this->apiResponse->success('Categories by provider retrieved successfully',
            $this->categoryRepository->getByProvider($providerId));
    }

    public function create(CategoryDto $dto): JsonResponse
    {
        $category = $this->categoryRepository->create([
            'name' => $dto->name,
            'parent_id' => $dto->parent_id,
            'provider_id' => $dto->provider_id,
        ]);
        $category->load('provider');

        return $this->apiResponse->success('Category created successfully', $category, 201);
    }

    public function update(int $id, CategoryDto $dto): JsonResponse
    {
        $category = $this->categoryRepository->update($id, [
            'name' => $dto->name,
            'parent_id' => $dto->parent_id,
            'provider_id' => $dto->provider_id,
        ]);

        if (!$category) {
            return $this->apiResponse->error('Category not found', [], 404);
        }

        $category->load('provider');

        return $this->apiResponse->success('Category updated successfully', $category);
    }

    public function delete(int $id): JsonResponse
    {
        return $this->categoryRepository->delete($id)
            ? $this->apiResponse->success('Category deleted successfully')
            : $this->apiResponse->error('Category not found', [], 404);
    }
}
