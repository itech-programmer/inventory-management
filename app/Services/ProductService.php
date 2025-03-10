<?php

namespace App\Services;

use App\Contracts\ApiResponseServiceInterface;
use App\Contracts\ProductRepositoryInterface;
use App\Contracts\ProductServiceInterface;
use App\DTO\ProductDto;
use Illuminate\Http\JsonResponse;

class ProductService implements ProductServiceInterface
{
    private ProductRepositoryInterface $productRepository;
    private ApiResponseServiceInterface $apiResponse;

    public function __construct(
        ProductRepositoryInterface $productRepository,
        ApiResponseServiceInterface $apiResponse
    ) {
        $this->productRepository = $productRepository;
        $this->apiResponse = $apiResponse;
    }

    public function getAll(): JsonResponse
    {
        $products = $this->productRepository->getAll()->map(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'category_name' => $product->category ? $product->category->name : null,
                'price' => $product->price,
            ];
        });

        return $this->apiResponse->success('Products retrieved successfully', $products);
    }

    public function getAvailable(): JsonResponse
    {
        $products = $this->productRepository->getAvailableProducts();

        return $this->apiResponse->success('Available products retrieved successfully', $products);
    }

    public function findById(int $id): JsonResponse
    {
        $product = $this->productRepository->findById($id);

        return $product
            ? $this->apiResponse->success('Product found', $product)
            : $this->apiResponse->error('Product not found', [], 404);
    }

    public function create(ProductDto $dto): JsonResponse
    {
        $product = $this->productRepository->create([
            'name' => $dto->name,
            'category_id' => $dto->category_id,
            'price' => $dto->price,
        ]);

        return $this->apiResponse->success('Product created successfully', $product, 201);
    }

    public function update(int $id, ProductDto $dto): JsonResponse
    {
        $product = $this->productRepository->update($id, [
            'name' => $dto->name,
            'category_id' => $dto->category_id,
            'price' => $dto->price,
        ]);

        return $product
            ? $this->apiResponse->success('Product updated successfully', $product)
            : $this->apiResponse->error('Product not found', [], 404);
    }

    public function delete(int $id): JsonResponse
    {
        return $this->productRepository->delete($id)
            ? $this->apiResponse->success('Product deleted successfully')
            : $this->apiResponse->error('Product not found', [], 404);
    }
}