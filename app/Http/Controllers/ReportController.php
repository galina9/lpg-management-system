<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $from = $request->from;
        $to   = $request->to;

        $orders = Order::query()
            ->where('status', 'Delivered');

        if ($from && $to) {
            $orders->whereBetween('order_date', [$from, $to]);
        }

        $dailySales = (clone $orders)->sum('total_price');

        $monthlySales = $dailySales;

        $topCustomers = (clone $orders)
            ->select(
                'customer_id',
                DB::raw('SUM(total_price) as total_sales'),
                DB::raw('COUNT(*) as total_orders')
            )
            ->with('customer')
            ->groupBy('customer_id')
            ->orderByDesc('total_sales')
            ->take(5)
            ->get();

        $productSales = (clone $orders)
            ->select(
                'product_id',
                DB::raw('SUM(quantity) as total_quantity'),
                DB::raw('SUM(total_price) as total_revenue')
            )
            ->with('product')
            ->groupBy('product_id')
            ->orderByDesc('total_quantity')
            ->get();

        return view('reports.index', compact(
            'dailySales',
            'monthlySales',
            'topCustomers',
            'productSales'
        ));
    }
    public function monthly(Request $request)
{
    $month = $request->month ?? now()->format('Y-m');

    $orders = Order::with([
            'customer',
            'product',
            'driver'
        ])
        ->whereYear('order_date', date('Y', strtotime($month)))
        ->whereMonth('order_date', date('m', strtotime($month)))
        ->get();

    return view('reports.monthly', compact(
        'orders',
        'month'
    ));
}
public function monthlyPdf(Request $request)
{
    $month = $request->month ?? now()->format('Y-m');

    $orders = Order::with([
            'customer',
            'product',
            'driver'
        ])
        ->whereYear('order_date', date('Y', strtotime($month)))
        ->whereMonth('order_date', date('m', strtotime($month)))
        ->get();

    $totalRevenue = $orders->sum('total_price');

    $pdf = Pdf::loadView('reports.pdf.monthly', [

        'orders' => $orders,
        'month' => $month,
        'totalRevenue' => $totalRevenue

    ]);

    return $pdf->download(
        'Monthly-Report-'.$month.'.pdf'
    );
}
}