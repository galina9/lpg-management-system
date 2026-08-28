<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use App\Notifications\OrderStatusChanged;

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

        return view(
            'driver.index',
            compact('orders')
        );
    }


    public function start(Order $order)
    {
        if ($order->driver_id != auth()->id()) {
            abort(403);
        }


        $oldStatus =
            $order->status;


        $newStatus =
            'On Delivery';


        $order->update([
            'status' => $newStatus
        ]);


        $this->sendStatusNotification(
            $order,
            $oldStatus,
            $newStatus
        );


        return back()->with(
            'success',
            'Delivery started.'
        );
    }


    public function complete(Order $order)
    {
        if ($order->driver_id != auth()->id()) {
            abort(403);
        }


        $oldStatus =
            $order->status;


        $newStatus =
            'Delivered';


        $order->update([
            'status' => $newStatus
        ]);


        $this->sendStatusNotification(
            $order,
            $oldStatus,
            $newStatus
        );


        return back()->with(
            'success',
            'Order delivered successfully.'
        );
    }


    private function sendStatusNotification(
        Order $order,
        string $oldStatus,
        string $newStatus
    ) {

        $driver =
            auth()->user();


        $users =
            User::whereIn(
                'role',
                ['director', 'manager']
            )->get();


        foreach ($users as $user) {

            $user->notify(
                new OrderStatusChanged(
                    $order,
                    $oldStatus,
                    $newStatus,
                    $driver
                )
            );

        }

    }
}