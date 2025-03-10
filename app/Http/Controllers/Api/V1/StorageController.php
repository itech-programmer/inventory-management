<?php

namespace App\Http\Controllers\Api\V1;

use App\Contracts\StorageServiceInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StorageController extends Controller
{
    private StorageServiceInterface $storageService;

    public function __construct(StorageServiceInterface $storageService)
    {
        $this->storageService = $storageService;
    }

    public function getRemainingQuantities(Request $request): JsonResponse
    {
        $request->validate([
            'date' => 'required|date',
        ]);

        return $this->storageService->getRemainingQuantities($request->input('date'));
    }
}
