<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Order;

class Product extends Model
{
    protected $fillable = [

        'name',

        'code',

        'gas_type',

        'unit',

        'purchase_price',

        'sale_price',

        'stock',

        'status',

        'description'

    ];
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
