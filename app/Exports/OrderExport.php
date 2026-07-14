<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class OrderExport implements FromArray, WithHeadings
{
    protected $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function headings(): array
    {
        return [
            'Order Number',
            'Customer',
            'Phone',
            'Driver',
            'Product',
            'Quantity',
            'Unit Price',
            'Total Price',
            'Status',
            'Order Date',
        ];
    }

    public function array(): array
    {
        return [[
            $this->order->order_number,
            $this->order->customer?->full_name,
            $this->order->customer?->phone,
            $this->order->driver?->name,
            $this->order->product?->name,
            $this->order->quantity,
            $this->order->unit_price,
            $this->order->total_price,
            $this->order->status,
            $this->order->order_date,
        ]];
    }
}