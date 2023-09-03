<?php

namespace App\Http\Controllers;

use App\Helper\FormatResponse;
use App\Http\Requests\CustomerStoreRequest;
use App\Http\Requests\CustomerUpdateRequest;
use App\Models\Customer;
use App\Services\CustomerService;
use Illuminate\Http\Request;
use Ramsey\Uuid\Type\Integer;
use Throwable;

class CustomerController extends Controller
{

    public function list(Request $request) {
        $customer = Customer::all()->toArray();
        return FormatResponse::responseSuccess("00", "Success Get Customers", $customer);
    }

    public function store(CustomerStoreRequest $request) {

        $customer = Customer::create([
            "customer_name" => $request->input("customer_name"),
            "address" => $request->input("address"),
            "phone" => $request->input("phone"),
        ]);

        return FormatResponse::responseSuccess("00", "Create Customer successfully", $customer->toArray());
    }

    public function update(CustomerUpdateRequest $request, $customerId) {

        $customer = Customer::find($customerId);

        if(is_null($customer)) {
            return FormatResponse::responseFailed("01", "customer not found", null, 404);
        }

        $customer->customer_name = $request->input("customer_name");
        $customer->address = $request->input("address");
        $customer->phone = $request->input("phone");
        $customer->update();

        return FormatResponse::responseSuccess("00", "Updated Success", $customer);
    }
}