<?php

namespace App\Http\Controllers;

use App\Models\Order;

class DriverController extends Controller
{
    public function index()
    {
        $orders = Order::with([
                'customer',
                'product'
            ])
            ->where('driver_id', auth()->id())
            ->latest()
            ->get();

        return view('driver.index', compact('orders'));
    }
    public function start(Order $order)
    {
        if ($order->driver_id != auth()->id()) {
            abort(403);
        }

        $order->update([
            'status' => 'On Delivery'
        ]);

        return back()->with('success', 'Delivery started.');
    }

    public function complete(Order $order)
    {
        if ($order->driver_id != auth()->id()) {
            abort(403);
        }

        $order->update([
            'status' => 'Delivered'
        ]);

        return back()->with('success', 'Order delivered successfully.');
    }
}