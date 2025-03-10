<?php

namespace Tests\Feature;

use App\Contracts\BatchProfitServiceInterface;
use App\Contracts\StorageServiceInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;

class BatchControllerTest extends TestCase
{
    private $batchProfitServiceMock;

    protected function setUp(): void
    {
        parent::setUp();
        $this->batchProfitServiceMock = Mockery::mock(BatchProfitServiceInterface::class);
        $this->app->instance(BatchProfitServiceInterface::class, $this->batchProfitServiceMock);
    }

    public function test_calculate_profit_successfully(): void
    {
        $profitData = [
            [
                'batch_id' => 1,
                'total_sales' => 259.80,
                'total_cost' => 199.99,
                'total_refunds' => 5.50,
                'profit' => 54.31
            ]
        ];

        $this->batchProfitServiceMock
            ->shouldReceive('calculateProfit')
            ->once()
            ->andReturn(response()->json([
                'type' => 'success',
                'message' => 'Batch profit calculated successfully',
                'data' => $profitData,
            ]));

        $response = $this->getJson('/api/v1/batches/profit');
        $response->assertStatus(200)
            ->assertJson([
                'type' => 'success',
                'message' => 'Batch profit calculated successfully',
                'data' => $profitData,
            ]);
    }

    public function test_calculate_profit_with_no_batches(): void
    {
        $this->batchProfitServiceMock
            ->shouldReceive('calculateProfit')
            ->once()
            ->andReturn(response()->json([
                'type' => 'error',
                'message' => 'No batch data found',
                'data' => [],
            ], 404));

        $response = $this->getJson('/api/v1/batches/profit');
        $response->assertStatus(404)
            ->assertJson([
                'type' => 'error',
                'message' => 'No batch data found',
            ]);
    }
}
