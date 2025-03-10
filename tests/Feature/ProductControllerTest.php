<?php

namespace Tests\Feature;

use App\Contracts\ProductServiceInterface;
use App\DTO\ProductDto;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    private $productServiceMock;

    protected function setUp(): void
    {
        parent::setUp();
        $this->productServiceMock = Mockery::mock(ProductServiceInterface::class);
        $this->app->instance(ProductServiceInterface::class, $this->productServiceMock);
    }

    public function test_return_all_products(): void
    {
        $products = [
            ['id' => 1, 'name' => 'Ahmad Tea Earl Grey, 500g', 'category_id' => 1, 'price' => 10.99],
            ['id' => 2, 'name' => 'Green Tea, 250g', 'category_id' => 2, 'price' => 8.99],
        ];

        $this->productServiceMock
            ->shouldReceive('getAll')
            ->once()
            ->andReturn(response()->json([
                'type' => 'success',
                'message' => 'Products retrieved successfully',
                'data' => $products,
            ]));

        $response = $this->getJson('/api/v1/products');
        $response->assertStatus(200)
            ->assertJson([
                'type' => 'success',
                'message' => 'Products retrieved successfully',
                'data' => $products,
            ]);
    }

    public function test_return_available_products(): void
    {
        $availableProducts = [
            ['id' => 1, 'name' => 'Ahmad Tea Earl Grey, 500g', 'category_name' => 'Black Tea', 'price' => 10.99, 'qty' => 50],
        ];

        $this->productServiceMock
            ->shouldReceive('getAvailable')
            ->once()
            ->andReturn(response()->json([
                'type' => 'success',
                'message' => 'Available products retrieved successfully',
                'data' => $availableProducts,
            ]));

        $response = $this->getJson('/api/v1/products/available');
        $response->assertStatus(200)
            ->assertJson([
                'type' => 'success',
                'message' => 'Available products retrieved successfully',
                'data' => $availableProducts,
            ]);
    }

    public function test_return_product_by_id(): void
    {
        $product = ['id' => 1, 'name' => 'Ahmad Tea Earl Grey, 500g', 'category_id' => 1, 'price' => 10.99];

        $this->productServiceMock
            ->shouldReceive('findById')
            ->with(1)
            ->once()
            ->andReturn(response()->json([
                'type' => 'success',
                'message' => 'Product found',
                'data' => $product,
            ]));

        $response = $this->getJson('/api/v1/products/1');
        $response->assertStatus(200)
            ->assertJson([
                'type' => 'success',
                'message' => 'Product found',
                'data' => $product,
            ]);
    }

    public function test_return_404_if_product_not_found(): void
    {
        $this->productServiceMock
            ->shouldReceive('findById')
            ->with(999)
            ->once()
            ->andReturn(response()->json([
                'type' => 'error',
                'message' => 'Product not found',
                'data' => [],
            ], 404));

        $response = $this->getJson('/api/v1/products/999');
        $response->assertStatus(404)
            ->assertJson([
                'type' => 'error',
                'message' => 'Product not found',
            ]);
    }

    public function test_create_a_product(): void
    {
        $data = [
            'name' => 'New Product',
            'category_id' => 1,
            'price' => 9.99
        ];

        $expectedResponse = response()->json([
            'type' => 'success',
            'message' => 'Product created successfully',
            'data' => ['id' => 3, 'name' => 'New Product', 'category_id' => 1, 'price' => 9.99],
        ], 201);

        $this->productServiceMock
            ->shouldReceive('create')
            ->once()
            ->with(Mockery::on(function ($arg) {
                return $arg instanceof ProductDto &&
                    $arg->name === 'New Product' &&
                    $arg->category_id === 1 &&
                    $arg->price === 9.99;
            }))
            ->andReturn($expectedResponse);

        $response = $this->postJson('/api/v1/products', $data);

        $response->assertStatus(201)
            ->assertJson([
                'type' => 'success',
                'message' => 'Product created successfully',
                'data' => ['id' => 3, 'name' => 'New Product'],
            ]);
    }

    public function test_return_validation_error_on_invalid_product_creation(): void
    {
        $response = $this->postJson('/api/v1/products', [
            'name' => '',
            'category_id' => '',
            'price' => ''
        ]);

        $response->assertStatus(422)
            ->assertJsonStructure(['type', 'message', 'data']);
    }

    public function test_update_a_product(): void
    {
        $data = [
            'name' => 'Updated Product',
            'category_id' => 2,
            'price' => 12.99
        ];

        $expectedResponse = response()->json([
            'type' => 'success',
            'message' => 'Product updated successfully',
            'data' => ['id' => 1, 'name' => 'Updated Product', 'category_id' => 2, 'price' => 12.99],
        ]);

        $this->productServiceMock
            ->shouldReceive('update')
            ->once()
            ->with(1, Mockery::on(function ($arg) {
                return $arg instanceof ProductDto &&
                    $arg->name === 'Updated Product' &&
                    $arg->category_id === 2 &&
                    $arg->price === 12.99;
            }))
            ->andReturn($expectedResponse);

        $response = $this->putJson('/api/v1/products/1', $data);

        $response->assertStatus(200)
            ->assertJson([
                'type' => 'success',
                'message' => 'Product updated successfully',
                'data' => ['id' => 1, 'name' => 'Updated Product'],
            ]);
    }

    public function test_delete_a_product(): void
    {
        $this->productServiceMock
            ->shouldReceive('delete')
            ->once()
            ->with(1)
            ->andReturn(response()->json([
                'type' => 'success',
                'message' => 'Product deleted successfully',
            ]));

        $response = $this->deleteJson('/api/v1/products/1');
        $response->assertStatus(200)
            ->assertJson([
                'type' => 'success',
                'message' => 'Product deleted successfully',
            ]);
    }

    public function test_return_404_if_product_to_delete_not_found(): void
    {
        $this->productServiceMock
            ->shouldReceive('delete')
            ->once()
            ->with(999)
            ->andReturn(response()->json([
                'type' => 'error',
                'message' => 'Product not found',
                'data' => [],
            ], 404));

        $response = $this->deleteJson('/api/v1/products/999');
        $response->assertStatus(404)
            ->assertJson([
                'type' => 'error',
                'message' => 'Product not found',
            ]);
    }
}
