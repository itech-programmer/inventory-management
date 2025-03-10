<?php

namespace Tests\Feature;

use App\Contracts\BatchProfitServiceInterface;
use App\Contracts\StorageServiceInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;

class StorageControllerTest extends TestCase
{
    private $storageServiceMock;

    protected function setUp(): void
    {
        parent::setUp();
        $this->storageServiceMock = Mockery::mock(StorageServiceInterface::class);
        $this->app->instance(StorageServiceInterface::class, $this->storageServiceMock);
    }

    public function test_get_remaining_quantities_successfully(): void
    {
        $remainingData = [
            ['id' => 1, 'name' => 'Ahmad Tea Earl Grey, 500g', 'remaining_qty' => 50]
        ];

        $this->storageServiceMock
            ->shouldReceive('getRemainingQuantities')
            ->with('2025-03-06')
            ->once()
            ->andReturn(response()->json([
                'type' => 'success',
                'message' => 'Remaining quantities retrieved successfully',
                'data' => $remainingData,
            ]));

        $response = $this->getJson('/api/v1/storage/remaining?date=2025-03-06');
        $response->assertStatus(200)
            ->assertJson([
                'type' => 'success',
                'message' => 'Remaining quantities retrieved successfully',
                'data' => $remainingData,
            ]);
    }

    public function test_get_remaining_quantities_no_data(): void
    {
        $this->storageServiceMock
            ->shouldReceive('getRemainingQuantities')
            ->with('2025-03-06')
            ->once()
            ->andReturn(response()->json([
                'type' => 'success',
                'message' => 'Remaining quantities retrieved successfully',
                'data' => [],
            ]));

        $response = $this->getJson('/api/v1/storage/remaining?date=2025-03-06');
        $response->assertStatus(200)
            ->assertJson([
                'type' => 'success',
                'message' => 'Remaining quantities retrieved successfully',
                'data' => [],
            ]);
    }
}
