<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class ReportController extends Controller
{
    public function sales(Request $request)
    {
        $query = Order::query();

        if ($request->filled('from')) {
            $query->whereDate('order_date', '>=', $request->from);
        }

        if ($request->filled('to')) {
            $query->whereDate('order_date', '<=', $request->to);
        }

        $orders = $query->latest()->get();

        $totalSales = $orders->sum('total_price');

        return view('reports.sales', compact(
            'orders',
            'totalSales'
        ));
    }
}