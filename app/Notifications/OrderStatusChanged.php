<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class OrderStatusChanged extends Notification
{
    use Queueable;

    public function __construct(
        public $order,
        public string $oldStatus,
        public string $newStatus,
        public $driver
    ) {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'title' => 'Order Status Changed',

            'message' => 'Order status has been changed.',

            'order_id' => $this->order->id,

            'order_number' => $this->order->order_number,

            'driver_name' => $this->driver->name,

            'old_status' => $this->oldStatus,

            'new_status' => $this->newStatus,
        ];
    }
}