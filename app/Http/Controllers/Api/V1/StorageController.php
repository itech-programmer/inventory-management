<?php

namespace App\Http\Controllers\Api\V1;

use App\Contracts\StorageRepositoryInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StorageController extends Controller
{
    private StorageRepositoryInterface $storageRepository;

    public function __construct(StorageRepositoryInterface $storageRepository)
    {
        $this->storageRepository = $storageRepository;
    }

    public function getRemainingQuantities(Request $request): JsonResponse
    {
        $request->validate([
            'date' => 'required|date',
        ]);

        $remainingQuantities = $this->storageRepository->getRemainingQuantities($request->input('date'));

        return response()->json([
            'message' => 'Remaining quantities retrieved successfully',
            'data' => $remainingQuantities,
        ]);
    }
}
