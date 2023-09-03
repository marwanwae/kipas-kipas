<?php

namespace Tests\Feature\Services;

use App\Http\Requests\CustomerStoreRequest;
use App\Services\CustomerService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Client\Request;
use Tests\TestCase;

class CustomerServiceTest extends TestCase
{
    use RefreshDatabase;
    public CustomerService $customerService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->customerService = $this->app->make(CustomerService::class);
    }

    public function testStoreCustomer() {
        $request = new CustomerStoreRequest([
            "customer_name" => "danish",
            "address" => "jakarta",
            "phone" => "08123",
        ]);

        $result = $this->customerService->store($request);
        $this->assertEquals("danish", $result->customer_name);
        $this->assertEquals("jakarta", $result->address);
    }
}