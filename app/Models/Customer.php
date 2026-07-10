<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [

        'full_name',

        'phone',

        'email',

        'address',

        'status'

    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}