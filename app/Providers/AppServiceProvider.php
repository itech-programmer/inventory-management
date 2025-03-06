<?php

namespace App\Providers;

use App\Contracts\BatchProfitServiceInterface;
use App\Contracts\OrderRepositoryInterface;
use App\Contracts\OrderServiceInterface;
use App\Contracts\ProductRepositoryInterface;
use App\Contracts\ProductServiceInterface;
use App\Contracts\RefundRepositoryInterface;
use App\Contracts\RefundServiceInterface;
use App\Repositories\OrderRepository;
use App\Repositories\ProductRepository;
use App\Repositories\RefundRepository;
use App\Services\BatchProfitService;
use App\Services\OrderService;
use App\Services\ProductService;
use App\Services\RefundService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(ProductServiceInterface::class, ProductService::class);

        $this->app->bind(OrderRepositoryInterface::class, OrderRepository::class);
        $this->app->bind(OrderServiceInterface::class, OrderService::class);

        $this->app->bind(RefundRepositoryInterface::class, RefundRepository::class);
        $this->app->bind(RefundServiceInterface::class, RefundService::class);
        $this->app->bind(BatchProfitServiceInterface::class, BatchProfitService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
