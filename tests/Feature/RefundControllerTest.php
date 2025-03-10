<?php
namespace Tests\Feature;

use App\Contracts\RefundServiceInterface;
use App\DTO\RefundDto;
use Mockery;
use Tests\TestCase;

class RefundControllerTest extends TestCase
{
    private $refundServiceMock;

    protected function setUp(): void
    {
        parent::setUp();
        $this->refundServiceMock = Mockery::mock(RefundServiceInterface::class);
        $this->app->instance(RefundServiceInterface::class, $this->refundServiceMock);
    }

    public function test_return_all_refunds(): void
    {
        $refunds = [
            ['id' => 1, 'order_id' => 2, 'quantity' => 1, 'refund_amount' => 5.50],
            ['id' => 2, 'batch_id' => 3, 'quantity' => 2, 'refund_amount' => 10.00],
        ];

        $this->refundServiceMock
            ->shouldReceive('getAll')
            ->once()
            ->andReturn(response()->json([
                'type' => 'success',
                'message' => 'Refunds retrieved successfully',
                'data' => $refunds,
            ]));

        $response = $this->getJson('/api/v1/refunds');

        $response->assertStatus(200)
            ->assertJson([
                'type' => 'success',
                'message' => 'Refunds retrieved successfully',
                'data' => $refunds,
            ]);
    }

    public function test_return_refund_by_id(): void
    {
        $refund = ['id' => 1, 'order_id' => 2, 'quantity' => 1, 'refund_amount' => 5.50];

        $this->refundServiceMock
            ->shouldReceive('findById')
            ->with(1)
            ->once()
            ->andReturn(response()->json([
                'type' => 'success',
                'message' => 'Refund found',
                'data' => $refund,
            ]));

        $response = $this->getJson('/api/v1/refunds/1');

        $response->assertStatus(200)
            ->assertJson([
                'type' => 'success',
                'message' => 'Refund found',
                'data' => $refund,
            ]);
    }

    public function test_return_404_if_refund_not_found(): void
    {
        $this->refundServiceMock
            ->shouldReceive('findById')
            ->with(999)
            ->once()
            ->andReturn(response()->json([
                'type' => 'error',
                'message' => 'Refund not found',
                'data' => [],
            ], 404));

        $response = $this->getJson('/api/v1/refunds/999');

        $response->assertStatus(404)
            ->assertJson([
                'type' => 'error',
                'message' => 'Refund not found',
            ]);
    }

    public function test_create_a_refund(): void
    {
        $data = [
            'order_id' => 1,
            'quantity' => 1,
            'refund_amount' => 5.50
        ];

        $this->refundServiceMock
            ->shouldReceive('create')
            ->once()
            ->with(Mockery::type(RefundDto::class))
            ->andReturn(response()->json([
                'type' => 'success',
                'message' => 'Refund processed',
                'data' => [
                    'id' => 3,
                    'order_id' => 1,
                    'quantity' => 1,
                    'refund_amount' => 5.50
                ],
            ], 201));

        $response = $this->postJson('/api/v1/refunds', $data);

        $response->assertStatus(201)
            ->assertJson([
                'type' => 'success',
                'message' => 'Refund processed',
            ]);
    }

    public function test_return_validation_error_on_invalid_refund_creation(): void
    {
        $response = $this->postJson('/api/v1/refunds', [
            'order_id' => '',
            'quantity' => '',
            'refund_amount' => ''
        ]);

        $response->assertStatus(422)
            ->assertJsonStructure(['type', 'message', 'data']);
    }
}
