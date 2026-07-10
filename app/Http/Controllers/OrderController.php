<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('product');

        if ($request->filled('search')) {
            $query->where('order_number', 'like', '%' . $request->search . '%')
                  ->orWhere('customer_name', 'like', '%' . $request->search . '%');
        }

        $orders = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        $products = Product::where('status', 'active')->get();

        return view('orders.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id'      => 'required|exists:products,id',
            'customer_name'   => 'required|max:255',
            'customer_phone'  => 'required|max:50',
            'quantity'        => 'required|numeric|min:1',
            'order_date'      => 'required|date',
            'status'          => 'required',
        ]);

        $product = Product::findOrFail($request->product_id);

        Order::create([
            'order_number'   => 'ORD-' . now()->format('YmdHis'),
            'product_id'     => $product->id,
            'customer_name'  => $request->customer_name,
            'customer_phone' => $request->customer_phone,
            'quantity'       => $request->quantity,
            'unit_price'     => $product->sale_price,
            'total_price'    => $product->sale_price * $request->quantity,
            'order_date'     => $request->order_date,
            'status'         => $request->status,
        ]);

        return redirect()
            ->route('orders.index')
            ->with('success', 'Order created successfully.');
    }

    public function show(Order $order)
    {
        //
    }

    public function edit(Order $order)
    {
        $products = Product::where('status', 'active')->get();

        return view('orders.edit', compact('order', 'products'));
    }

    public function update(Request $request, Order $order)
    {
        $request->validate([
            'product_id'      => 'required|exists:products,id',
            'customer_name'   => 'required|max:255',
            'customer_phone'  => 'required|max:50',
            'quantity'        => 'required|numeric|min:1',
            'order_date'      => 'required|date',
            'status'          => 'required',
        ]);

        $product = Product::findOrFail($request->product_id);

        $order->update([
            'product_id'     => $product->id,
            'customer_name'  => $request->customer_name,
            'customer_phone' => $request->customer_phone,
            'quantity'       => $request->quantity,
            'unit_price'     => $product->sale_price,
            'total_price'    => $product->sale_price * $request->quantity,
            'order_date'     => $request->order_date,
            'status'         => $request->status,
        ]);

        return redirect()
            ->route('orders.index')
            ->with('success', 'Order updated successfully.');
    }

    public function destroy(Order $order)
    {
        $order->delete();

        return redirect()
            ->route('orders.index')
            ->with('success', 'Order deleted successfully.');
    }
}