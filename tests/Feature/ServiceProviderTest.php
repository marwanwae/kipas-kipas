<?php

namespace Tests\Feature;

use App\Services\CustomerService;
use App\Services\OrderService;
use App\Services\ProductService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ServiceProviderTest extends TestCase
{
    public CustomerService $customerService;
    public OrderService $orderService;
    public ProductService $productService;
    public function setUp(): void{
        parent::setUp();
        $this->customerService = $this->app->make(CustomerService::class);
        $this->orderService = $this->app->make(OrderService::class);
        $this->productService = $this->app->make(ProductService::class);
    }

    public function testCustomerServiceProviderNotNull() {
        $this->assertNotNull($this->customerService);
    }

    public function testOrderServiceProviderNotNull() {
        $this->assertNotNull($this->orderService);
    }

    public function testProductServiceProviderNotNull() {
        $this->assertNotNull($this->productService);
    }
}