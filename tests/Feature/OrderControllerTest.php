<?php
namespace Tests\Feature;

use App\Contracts\OrderServiceInterface;
use App\DTO\OrderDto;
use Mockery;
use Tests\TestCase;

class OrderControllerTest extends TestCase
{
    private $orderServiceMock;

    protected function setUp(): void
    {
        parent::setUp();
        $this->orderServiceMock = Mockery::mock(OrderServiceInterface::class);
        $this->app->instance(OrderServiceInterface::class, $this->orderServiceMock);
    }

    public function test_return_all_orders(): void
    {
        $orders = [
            [
                'id' => 1,
                'client_id' => 2,
                'client_name' => 'Supermarket X',
                'products' => [
                    ['id' => 1, 'name' => 'Ahmad Tea Earl Grey', 'quantity' => 2, 'price_at_sale' => 12.99]
                ]
            ]
        ];

        $this->orderServiceMock
            ->shouldReceive('getAll')
            ->once()
            ->andReturn(response()->json([
                'type' => 'success',
                'message' => 'Orders retrieved successfully',
                'data' => $orders,
            ]));

        $response = $this->getJson('/api/v1/orders');

        $response->assertStatus(200)
            ->assertJson([
                'type' => 'success',
                'message' => 'Orders retrieved successfully',
                'data' => $orders,
            ]);
    }

    public function test_return_order_by_id(): void
    {
        $order = [
            'id' => 1,
            'client_id' => 2,
            'client_name' => 'Supermarket X',
            'products' => [
                ['id' => 1, 'name' => 'Ahmad Tea Earl Grey', 'quantity' => 2, 'price_at_sale' => 12.99]
            ]
        ];

        $this->orderServiceMock
            ->shouldReceive('findById')
            ->with(1)
            ->once()
            ->andReturn(response()->json([
                'type' => 'success',
                'message' => 'Order found',
                'data' => $order,
            ]));

        $response = $this->getJson('/api/v1/orders/1');

        $response->assertStatus(200)
            ->assertJson([
                'type' => 'success',
                'message' => 'Order found',
                'data' => $order,
            ]);
    }

    public function test_return_404_if_order_not_found(): void
    {
        $this->orderServiceMock
            ->shouldReceive('findById')
            ->with(999)
            ->once()
            ->andReturn(response()->json([
                'type' => 'error',
                'message' => 'Order not found',
                'data' => [],
            ], 404));

        $response = $this->getJson('/api/v1/orders/999');

        $response->assertStatus(404)
            ->assertJson([
                'type' => 'error',
                'message' => 'Order not found',
            ]);
    }

    public function test_return_orders_by_client(): void
    {
        $orders = [
            [
                'id' => 1,
                'client_id' => 2,
                'client_name' => 'Supermarket X',
                'products' => [
                    ['id' => 1, 'name' => 'Ahmad Tea Earl Grey', 'quantity' => 2, 'price_at_sale' => 12.99]
                ]
            ]
        ];

        $this->orderServiceMock
            ->shouldReceive('getByClientId')
            ->with(2)
            ->once()
            ->andReturn(response()->json([
                'type' => 'success',
                'message' => 'Orders retrieved successfully',
                'data' => $orders,
            ]));

        $response = $this->getJson('/api/v1/orders/client/2');

        $response->assertStatus(200)
            ->assertJson([
                'type' => 'success',
                'message' => 'Orders retrieved successfully',
                'data' => $orders,
            ]);
    }

    public function test_create_an_order(): void
    {
        $data = [
            'client_id' => 1,
            'products' => [
                ['id' => 1, 'qty' => 2]
            ]
        ];

        $this->orderServiceMock
            ->shouldReceive('create')
            ->once()
            ->with(Mockery::type(OrderDto::class))
            ->andReturn(response()->json([
                'type' => 'success',
                'message' => 'Order created successfully',
                'data' => [
                    'id' => 2,
                    'client_id' => 1,
                    'client_name' => 'Supermarket X',
                    'products' => [
                        ['id' => 1, 'name' => 'Ahmad Tea Earl Grey', 'quantity' => 2, 'price_at_sale' => 12.99]
                    ]
                ],
            ], 201));

        $response = $this->postJson('/api/v1/orders', $data);

        $response->assertStatus(201)
            ->assertJson([
                'type' => 'success',
                'message' => 'Order created successfully',
            ]);
    }

    public function test_return_validation_error_on_invalid_order_creation(): void
    {
        $response = $this->postJson('/api/v1/orders', [
            'client_id' => '',
            'products' => []
        ]);

        $response->assertStatus(422)
            ->assertJsonStructure(['type', 'message', 'data']);
    }

    public function test_delete_an_order(): void
    {
        $this->orderServiceMock
            ->shouldReceive('delete')
            ->once()
            ->with(1)
            ->andReturn(response()->json([
                'type' => 'success',
                'message' => 'Order deleted successfully',
            ]));

        $response = $this->deleteJson('/api/v1/orders/1');

        $response->assertStatus(200)
            ->assertJson([
                'type' => 'success',
                'message' => 'Order deleted successfully',
            ]);
    }

    public function test_return_404_if_order_to_delete_not_found(): void
    {
        $this->orderServiceMock
            ->shouldReceive('delete')
            ->once()
            ->with(999)
            ->andReturn(response()->json([
                'type' => 'error',
                'message' => 'Order not found',
                'data' => [],
            ], 404));

        $response = $this->deleteJson('/api/v1/orders/999');

        $response->assertStatus(404)
            ->assertJson([
                'type' => 'error',
                'message' => 'Order not found',
            ]);
    }
}
