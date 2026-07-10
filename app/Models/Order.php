<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Customer;

class Order extends Model
{
    protected $fillable = [

        'order_number',

        'product_id',

        'customer_name',

        'customer_phone',

        'quantity',

        'unit_price',

        'total_price',

        'order_date',

        'status'

    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}