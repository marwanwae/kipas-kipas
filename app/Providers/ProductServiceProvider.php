<?php

namespace App\Providers;

use App\Services\ProductService;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class ProductServiceProvider extends ServiceProvider implements DeferrableProvider
{

    public array $singletons = [ProductService::class];

    public function provides()
    {
        return [ProductService::class];
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}