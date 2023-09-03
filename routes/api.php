<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get("customer", [CustomerController::class, "list"]);
Route::post("customer", [CustomerController::class, "store"]);
Route::post("customer/{customer}", [CustomerController::class, "update"]);

Route::get("product", [ProductController::class, "list"]);
Route::post("product", [ProductController::class, "store"]);
Route::post("product/{product}", [ProductController::class, "update"]);

Route::get("order", [OrderController::class, "list"]);
Route::post("order", [OrderController::class, "store"]);