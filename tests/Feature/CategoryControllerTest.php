<?php

namespace Tests\Feature;

use App\Contracts\CategoryServiceInterface;
use App\DTO\CategoryDto;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;

class CategoryControllerTest extends TestCase
{
    private $categoryServiceMock;

    protected function setUp(): void
    {
        parent::setUp();
        $this->categoryServiceMock = Mockery::mock(CategoryServiceInterface::class);
        $this->app->instance(CategoryServiceInterface::class, $this->categoryServiceMock);
    }

    public function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_all_categories(): void
    {
        $categories = [
            ['id' => 1, 'name' => 'Ahmad Tea', 'parent_id' => null, 'provider_id' => 1],
            ['id' => 2, 'name' => 'Black Tea', 'parent_id' => 1, 'provider_id' => null],
        ];

        $this->categoryServiceMock
            ->shouldReceive('getAll')
            ->once()
            ->andReturn(response()->json([
                'type' => 'success',
                'message' => 'Categories retrieved successfully',
                'data' => $categories,
            ]));

        $response = $this->getJson('/api/v1/categories');
        $response->assertStatus(200)
            ->assertJson([
                'type' => 'success',
                'message' => 'Categories retrieved successfully',
                'data' => $categories,
            ]);
    }

    public function test_single_category_by_id(): void
    {
        $category = ['id' => 1, 'name' => 'Ahmad Tea', 'parent_id' => null, 'provider_id' => 1];

        $this->categoryServiceMock
            ->shouldReceive('findById')
            ->with(1)
            ->once()
            ->andReturn(response()->json([
                'type' => 'success',
                'message' => 'Category found',
                'data' => $category,
            ]));

        $response = $this->getJson('/api/v1/categories/1');
        $response->assertStatus(200)
            ->assertJson([
                'type' => 'success',
                'message' => 'Category found',
                'data' => $category,
            ]);
    }

    public function test_404_if_category_not_found(): void
    {
        $this->categoryServiceMock
            ->shouldReceive('findById')
            ->with(999)
            ->once()
            ->andReturn(response()->json([
                'type' => 'error',
                'message' => 'Category not found',
                'data' => [],
            ], 404));

        $response = $this->getJson('/api/v1/categories/999');
        $response->assertStatus(404)
            ->assertJson([
                'type' => 'error',
                'message' => 'Category not found',
            ]);
    }

    public function test_create_a_category(): void
    {
        $data = [
            'name' => 'New Category',
            'parent_id' => null,
            'provider_id' => null
        ];

        $this->categoryServiceMock
            ->shouldReceive('create')
            ->once()
            ->with(Mockery::type(CategoryDto::class))
            ->andReturn(response()->json([
                'type' => 'success',
                'message' => 'Category created successfully',
                'data' => ['id' => 3, 'name' => 'New Category'],
            ], 201));

        $response = $this->postJson('/api/v1/categories', $data);

        $response->assertStatus(201)
            ->assertJson([
                'type' => 'success',
                'message' => 'Category created successfully',
                'data' => ['id' => 3, 'name' => 'New Category'],
            ]);
    }

    public function test_validation_error_on_invalid_category_creation(): void
    {
        $response = $this->postJson('/api/v1/categories', [
            'name' => ''
        ]);

        $response->assertStatus(422)
            ->assertJsonStructure(['type', 'message', 'data']);
    }

    public function test_update_a_category(): void
    {
        $data = [
            'name' => 'Updated Category',
            'parent_id' => null,
            'provider_id' => null
        ];

        $this->categoryServiceMock
            ->shouldReceive('update')
            ->once()
            ->with(1, Mockery::type(CategoryDto::class))
            ->andReturn(response()->json([
                'type' => 'success',
                'message' => 'Category updated successfully',
                'data' => ['id' => 1, 'name' => 'Updated Category', 'parent_id' => null, 'provider_id' => null],
            ]));

        $response = $this->putJson('/api/v1/categories/1', $data);

        $response->assertStatus(200)
            ->assertJson([
                'type' => 'success',
                'message' => 'Category updated successfully',
                'data' => ['id' => 1, 'name' => 'Updated Category'],
            ]);
    }

    public function test_delete_a_category(): void
    {
        $this->categoryServiceMock
            ->shouldReceive('delete')
            ->once()
            ->with(1)
            ->andReturn(response()->json([
                'type' => 'success',
                'message' => 'Category deleted successfully',
            ]));

        $response = $this->deleteJson('/api/v1/categories/1');
        $response->assertStatus(200)
            ->assertJson([
                'type' => 'success',
                'message' => 'Category deleted successfully',
            ]);
    }

    public function test_404_if_category_to_delete_not_found(): void
    {
        $this->categoryServiceMock
            ->shouldReceive('delete')
            ->once()
            ->with(999)
            ->andReturn(response()->json([
                'type' => 'error',
                'message' => 'Category not found',
                'data' => [],
            ], 404));

        $response = $this->deleteJson('/api/v1/categories/999');
        $response->assertStatus(404)
            ->assertJson([
                'type' => 'error',
                'message' => 'Category not found',
            ]);
    }
}
