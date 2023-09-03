<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $table = "tbl_customers";
    protected $primaryKey = "customer_id";

    protected $fillable = ["customer_name", "address", "phone"];

    public function orders() {
        return $this->hasMany(Order::class, 'customer_id', 'customer_id');
    }
}