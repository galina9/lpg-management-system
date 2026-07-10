<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\User;

class OrderController extends Controller
{
    public function index(Request $request)
    {
       $query = Order::with(['product','driver']);

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

        $customers = Customer::where('status', 'active')
            ->orderBy('full_name')
            ->get();

        $drivers = User::where('role', 'driver')
            ->orderBy('name')
            ->get();

        return view('orders.create', compact(
            'products',
            'customers',
            'drivers'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id'      => 'required|exists:products,id',
            'customer_id' => 'required|exists:customers,id',
            'quantity'        => 'required|numeric|min:1',
            'order_date'      => 'required|date',
            'status'          => 'required',
            'driver_id' => 'nullable|exists:users,id',
        ]);

        $product = Product::findOrFail($request->product_id);
        if ($product->stock < $request->quantity) {

            return back()
                ->withInput()
                ->with('error',
                    'Not enough stock. Available: '.$product->stock
                );

        }
        Order::create([
            'order_number'   => 'ORD-' . now()->format('YmdHis'),
            'product_id'     => $product->id,
            'customer_id' => $request->customer_id,
            'quantity'       => $request->quantity,
            'unit_price'     => $product->sale_price,
            'total_price'    => $product->sale_price * $request->quantity,
            'order_date'     => $request->order_date,
            'status'         => $request->status,
            'driver_id' => $request->driver_id,
        ]);
        $product->decrement('stock', $request->quantity);
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

    $customers = Customer::where('status', 'active')
        ->orderBy('full_name')
        ->get();

    $drivers = User::where('role', 'driver')
        ->orderBy('name')
        ->get();

    return view('orders.edit', compact(
        'order',
        'products',
        'customers',
        'drivers'
    ));
}
    public function update(Request $request, Order $order)
    {
        $request->validate([
            'product_id'      => 'required|exists:products,id',
            'customer_id' => 'required|exists:customers,id',
            'quantity'        => 'required|numeric|min:1',
            'order_date'      => 'required|date',
            'status'          => 'required',
            'driver_id' => 'nullable|exists:users,id',

        ]);

        $product = Product::findOrFail($request->product_id);

        $order->update([
            'product_id'     => $product->id,
            'customer_id' => $request->customer_id,
            'quantity'       => $request->quantity,
            'unit_price'     => $product->sale_price,
            'total_price'    => $product->sale_price * $request->quantity,
            'order_date'     => $request->order_date,
            'status'         => $request->status,
            'driver_id' => $request->driver_id,
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