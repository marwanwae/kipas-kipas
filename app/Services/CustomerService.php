<?php

namespace App\Services;

use App\Http\Requests\CustomerStoreRequest;
use App\Models\Customer;

class CustomerService {

    public Customer $customer;

    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
    }

    public function store(CustomerStoreRequest $request): Customer{
        $customer = $this->customer;
        $customer->customer_name = $request->input("customer_name");
        $customer->address = $request->input("address");
        $customer->phone = $request->input("phone");
        $customer->save();

        return $customer;
    }
}