<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\Customer;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        // dd(auth()->check(), auth()->user());
        return view('admin.dashboard.index', [

            'totalProducts' => Product::count(),

            'totalCustomers' => Customer::count(),

            'totalOrders' => Order::count(),

            'totalUsers' => User::count(),

            'latestOrders' => Order::latest()
                ->take(5)
                ->get(),

            'lowStockProducts' => Product::where('stock','<',10)
                ->orderBy('stock')
                ->get(),

        ]);
    }
}