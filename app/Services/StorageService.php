<?php

namespace App\Services;

use App\Contracts\ApiResponseServiceInterface;
use App\Contracts\StorageRepositoryInterface;
use App\Contracts\StorageServiceInterface;
use Illuminate\Http\JsonResponse;

class StorageService implements StorageServiceInterface
{
    private StorageRepositoryInterface $storageRepository;
    private ApiResponseServiceInterface $apiResponse;

    public function __construct(
        StorageRepositoryInterface $storageRepository,
        ApiResponseServiceInterface $apiResponse
    ) {
        $this->storageRepository = $storageRepository;
        $this->apiResponse = $apiResponse;
    }

    public function getRemainingQuantities(string $date): JsonResponse
    {
        $remainingQuantities = $this->storageRepository->getRemainingQuantities($date);

        return $this->apiResponse->success('Remaining quantities retrieved successfully', $remainingQuantities);
    }
}
