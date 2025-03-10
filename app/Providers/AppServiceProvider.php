<?php

namespace App\Providers;

use App\Contracts\ApiResponseServiceInterface;
use App\Contracts\BatchProfitServiceInterface;
use App\Contracts\BatchRepositoryInterface;
use App\Contracts\CategoryRepositoryInterface;
use App\Contracts\CategoryServiceInterface;
use App\Contracts\OrderRepositoryInterface;
use App\Contracts\OrderServiceInterface;
use App\Contracts\ProductRepositoryInterface;
use App\Contracts\ProductServiceInterface;
use App\Contracts\RefundRepositoryInterface;
use App\Contracts\RefundServiceInterface;
use App\Contracts\StorageRepositoryInterface;
use App\Contracts\StorageServiceInterface;
use App\Repositories\BatchRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\OrderRepository;
use App\Repositories\ProductRepository;
use App\Repositories\RefundRepository;
use App\Repositories\StorageRepository;
use App\Services\ApiResponseService;
use App\Services\BatchProfitService;
use App\Services\CategoryService;
use App\Services\OrderService;
use App\Services\ProductService;
use App\Services\RefundService;
use App\Services\StorageService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ApiResponseServiceInterface::class, ApiResponseService::class);

        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
        $this->app->bind(CategoryServiceInterface::class, CategoryService::class);

        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(ProductServiceInterface::class, ProductService::class);

        $this->app->bind(OrderRepositoryInterface::class, OrderRepository::class);
        $this->app->bind(OrderServiceInterface::class, OrderService::class);

        $this->app->bind(RefundRepositoryInterface::class, RefundRepository::class);
        $this->app->bind(RefundServiceInterface::class, RefundService::class);

        $this->app->bind(BatchRepositoryInterface::class, BatchRepository::class);
        $this->app->bind(BatchProfitServiceInterface::class, BatchProfitService::class);

        $this->app->bind(StorageServiceInterface::class, StorageService::class);
        $this->app->bind(StorageRepositoryInterface::class, StorageRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
