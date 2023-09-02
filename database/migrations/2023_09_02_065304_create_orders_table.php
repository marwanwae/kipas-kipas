<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_orders', function (Blueprint $table) {
            $table->integer("order_id")->autoIncrement();
            $table->integer("customer_id");
            $table->string("customer_name");
            $table->integer("amount");
            $table->integer("quality");
            $table->integer("product_id");
            $table->dateTime("order_date");
            $table->timestamps();

            $table->unique(["customer_id","product_id"]);
            $table->foreign("customer_id")->references("customer_id")->on("tbl_customers");
            $table->foreign("product_id")->references("product_id")->on("tbl_products");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
};