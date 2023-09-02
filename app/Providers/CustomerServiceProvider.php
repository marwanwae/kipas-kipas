<?php

namespace App\Providers;

use App\Services\CustomerService;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class CustomerServiceProvider extends ServiceProvider implements DeferrableProvider
{

    public array $singletons = [CustomerService::class];

    public function provides()
    {
        return [CustomerService::class];
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