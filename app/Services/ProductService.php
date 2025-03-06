<?php

namespace App\Services;

use App\Contracts\ProductRepositoryInterface;
use App\Contracts\ProductServiceInterface;
use App\DTO\ProductDto;
use Illuminate\Http\JsonResponse;

class ProductService implements ProductServiceInterface
{
    private ProductRepositoryInterface $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function getAll(): JsonResponse
    {
        return response()->json([
            'message' => 'Products retrieved successfully',
            'data' => $this->productRepository->getAll()
        ], 200);
    }

    public function findById(int $id): JsonResponse
    {
        $product = $this->productRepository->findById($id);

        return $product
            ? response()->json(['message' => 'Product found', 'data' => $product], 200)
            : response()->json(['message' => 'Product not found'], 404);
    }

    public function create(ProductDto $dto): JsonResponse
    {
        $product = $this->productRepository->create([
            'name' => $dto->name,
            'category_id' => $dto->category_id,
            'price' => $dto->price,
        ]);

        return response()->json(['message' => 'Product created', 'data' => $product], 201);
    }

    public function update(int $id, ProductDto $dto): JsonResponse
    {
        $product = $this->productRepository->update($id, [
            'name' => $dto->name,
            'category_id' => $dto->category_id,
            'price' => $dto->price,
        ]);

        return $product
            ? response()->json(['message' => 'Product updated', 'data' => $product], 200)
            : response()->json(['message' => 'Product not found'], 404);
    }

    public function delete(int $id): JsonResponse
    {
        return $this->productRepository->delete($id)
            ? response()->json(['message' => 'Product deleted'], 200)
            : response()->json(['message' => 'Product not found'], 404);
    }
}