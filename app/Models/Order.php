<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Customer;
use App\Models\User;

class Order extends Model
{
    protected $fillable = [
        'driver_id',

        'order_number',

        'product_id',
        
        'customer_id',

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

    public function driver()
    {
        return $this->belongsTo(User::class, 'driver_id');
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
    
}