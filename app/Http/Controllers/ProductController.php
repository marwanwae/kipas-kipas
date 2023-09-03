<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Helper\FormatResponse;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateReqeust;

class ProductController extends Controller
{
    public function list(Request $request) {
        $products = Product::all()->toArray();
        return FormatResponse::responseSuccess("00", "success get products", $products);
    }

    public function store(ProductStoreRequest $request) {

        $product = new Product();
        $product->product_description = $request->input("product_description");
        $product->product_price = $request->integer("product_price");
        $product->stock = $request->integer("stock");

        $product->save();

        return FormatResponse::responseSuccess("00", "add product successfully", $product->toArray());
    }

    public function update(ProductUpdateReqeust $request, $productId) {

        $product = Product::find($productId);

        if (is_null($product)) {
            return FormatResponse::responseFailed("01", "product not found", null, 404);
        }

        $product->product_description = $request->input("product_description");
        $product->product_price = $request->integer("product_price");
        $product->stock = $request->integer("stock");

        $product->update();

        return FormatResponse::responseSuccess("00", "update success fully", $product->toArray());

    }
}