<?php

namespace App\Http\Controllers\Api\V1;

use App\Contracts\ProductServiceInterface;
use App\DTO\ProductDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    private ProductServiceInterface $productService;

    public function __construct(ProductServiceInterface $productService)
    {
        $this->productService = $productService;
    }

    public function index(): JsonResponse
    {
        return $this->productService->getAll();
    }

    public function available(): JsonResponse
    {
        return $this->productService->getAvailable();
    }

    public function show(int $id): JsonResponse
    {
        return $this->productService->findById($id);
    }

    public function store(ProductRequest $request): JsonResponse
    {    \Log::info('ProductController store() received validated data:', $request->validated());

        $dto = new ProductDto(
            $request->validated()['name'],
            $request->validated()['category_id'],
            $request->validated()['price']
        );

        return $this->productService->create($dto);
    }

    public function update(ProductRequest $request, int $id): JsonResponse
    {
        $dto = new ProductDto(
            $request->validated()['name'],
            $request->validated()['category_id'],
            $request->validated()['price']
        );

        return $this->productService->update($id, $dto);
    }

    public function destroy(int $id): JsonResponse
    {
        return $this->productService->delete($id);
    }
}