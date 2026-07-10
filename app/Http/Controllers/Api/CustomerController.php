<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;

class CustomerController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'customers' => Customer::orderBy('full_name')->get(),
        ]);
    }

    public function show(Customer $customer)
    {
        return response()->json([
            'success' => true,
            'customer' => $customer,
        ]);
    }
}