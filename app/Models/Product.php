<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = "tbl_products";
    protected $primaryKey = "product_id";

    public function orders() {
        return $this->hasMany(Order::class, 'product_id', 'product_id');
    }
}