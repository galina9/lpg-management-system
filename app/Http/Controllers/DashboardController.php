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
        $monthlySales = Order::selectRaw("
        MONTH(order_date) as month,
        SUM(total_price) as total
            ")
            ->whereYear('order_date', now()->year)
            ->where('status','Delivered')
            ->groupByRaw('MONTH(order_date)')
            ->pluck('total','month');

        return view('admin.dashboard.index', [

            'totalProducts' => Product::count(),

            'totalCustomers' => Customer::count(),

            'totalOrders' => Order::count(),

            'totalUsers' => User::count(),

            'latestOrders' => Order::latest()
                ->take(5)
                ->get(),

            'lowStockProducts' => Product::where('stock', '<=', 10)
                ->orderBy('stock')
                ->get(),
            'monthlySales'=>$monthlySales,

        ]);
    }
}