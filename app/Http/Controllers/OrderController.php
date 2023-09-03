<?php

namespace App\Http\Controllers;

use Throwable;
use App\Models\Order;
use App\Models\Product;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Helper\FormatResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\OrderStoreRequest;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class OrderController extends Controller
{
    public function list(Request $request) {
        $orders = Order::all();
        return FormatResponse::responseSuccess("00", "success get order", $orders->toArray());
    }

    public function store(OrderStoreRequest $request) {
        try{
            DB::beginTransaction();

            $customer = Customer::find($request->integer("customer_id"));
            if (is_null($customer)) {
                throw new NotFoundHttpException("customer not found");
            }

            $product = Product::find($request->integer("product_id"));
            if (is_null($product)) {
                throw new NotFoundHttpException("product not found");
            }

            if($product->stock < $request->integer("quality")) {
                throw new BadRequestHttpException("product out of stock");
            }

            $product->stock = $product->stock - $request->integer("quality");
            $product->update();

            $order = new Order();
            $order->customer_id = $request->input("customer_id");
            $order->customer_name = $customer->customer_name;
            $order->amount = $product->product_price * $request->integer("quality");
            $order->quality = $request->integer("quality");
            $order->product_id = $request->integer("product_id");
            $order->order_date = $request->date("order_date");
            $order->save();

            DB::commit();

            return FormatResponse::responseSuccess("00", "success create order", $order->toArray());
        }catch(NotFoundHttpException $exception){
            DB::rollBack();
            return FormatResponse::responseFailed("01", $exception->getMessage(), [], 200);
        }catch(BadRequestHttpException $exception){
            DB::rollBack();
            return FormatResponse::responseFailed("02", $exception->getMessage(), [], 200);
        }catch(Throwable $exception){
            DB::rollBack();
            return FormatResponse::responseFailed("99", $exception->getMessage(), [], 500);
        }
    }
}