<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Customer;
use App\Services\OrderService;
use App\Exports\OrderExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderController extends Controller
{
    protected OrderService $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }


    public function index(Request $request)
    {
       $query = Order::with(['customer','product','driver', 'payment']);

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
        if (!$this->orderService->hasEnoughStock($product, $request->quantity)) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'quantity' => 'Not enough stock available.'
                    ]);
            }
           $orderNumber = 'ORD-' . now()->format('YmdHis');

            $order = Order::create([
                'order_number'   => $orderNumber,
                'product_id'     => $product->id,
                'customer_id'    => $request->customer_id,
                'quantity'       => $request->quantity,
                'unit_price'     => $product->sale_price,
                'total_price'    => $product->sale_price * $request->quantity,
                'order_date'     => $request->order_date,
                'status'         => $request->status,
                'driver_id'      => $request->driver_id,
            ]);

        $this->orderService->decreaseStock(
            $product,
            $request->quantity
        );
        return redirect()
            ->route('orders.index')
            ->with('success', 'Order created successfully.');
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
        $oldStatus = $order->status;

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

        if ($oldStatus != 'Cancelled' && $request->status == 'Cancelled') {

            $this->orderService->increaseStock(
                $product,
                $order->quantity
            );

        }

        return redirect()
            ->route('orders.index')
            ->with('success', 'Order updated successfully.');
    }

    public function destroy(Order $order)
    {
        if ($order->status != 'Cancelled') {

            $this->orderService->increaseStock(
                $order->product,
                $order->quantity
            );

        }

        $order->delete();

        return redirect()
            ->route('orders.index')
            ->with('success', 'Order deleted successfully.');
    }
    public function exportExcel(Order $order)
    {
        return Excel::download(
            new OrderExport($order),
            'order-'.$order->order_number.'.xlsx'
        );
    }
    
    public function invoice(Order $order)
{
    $order->load([
        'customer',
        'product',
        'driver',
        'payment'
    ]);

    $pdf = Pdf::loadView(
        'orders.invoice',
        compact('order')
    );

    return $pdf->download(
        'invoice-' . $order->order_number . '.pdf'
    );
}
}