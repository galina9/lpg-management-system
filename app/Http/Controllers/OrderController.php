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
       $query = Order::with(['customer','product','driver', 'payments']);

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
            'unit_price' => 'required|numeric|min:0',
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
                'unit_price' => $request->unit_price,
                'total_price' => $request->unit_price * $request->quantity,
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
        public function show(Order $order)
    {
        $order->load([
            'customer',
            'product',
            'driver',
            'payments'
        ]);

        return view('orders.show', compact('order'));
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
        'product_id'  => 'required|exists:products,id',
        'customer_id' => 'required|exists:customers,id',
        'unit_price' => 'required|numeric|min:0',
        'quantity'    => 'required|numeric|min:1',
        'order_date'  => 'required|date',
        'status'      => 'required',
        'driver_id'   => 'nullable|exists:users,id',
    ]);

    $newProduct = Product::findOrFail($request->product_id);

    $oldProduct = $order->product;
    $oldQuantity = (float) $order->quantity;
    $oldStatus = $order->status;

    $newQuantity = (float) $request->quantity;
    $newStatus = $request->status;


    /*
    |--------------------------------------------------------------------------
    | Active → Cancelled
    |--------------------------------------------------------------------------
    */

    if ($oldStatus !== 'Cancelled' && $newStatus === 'Cancelled') {

        // Return the FULL old order quantity to stock
        $this->orderService->increaseStock(
            $oldProduct,
            $oldQuantity
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Cancelled → Active
    |--------------------------------------------------------------------------
    */

    elseif ($oldStatus === 'Cancelled' && $newStatus !== 'Cancelled') {

        if (!$this->orderService->hasEnoughStock(
            $newProduct,
            $newQuantity
        )) {

            return back()
                ->withInput()
                ->withErrors([
                    'quantity' =>
                        'Not enough stock available for the selected product.'
                ]);
        }

        $this->orderService->decreaseStock(
            $newProduct,
            $newQuantity
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Active → Active
    |--------------------------------------------------------------------------
    */

    elseif ($oldStatus !== 'Cancelled' && $newStatus !== 'Cancelled') {

        // Same product
        if ($oldProduct->id === $newProduct->id) {

            $difference = $newQuantity - $oldQuantity;


            // Quantity increased
            if ($difference > 0) {

                if (!$this->orderService->hasEnoughStock(
                    $newProduct,
                    $difference
                )) {

                    return back()
                        ->withInput()
                        ->withErrors([
                            'quantity' =>
                                'Not enough stock available.'
                        ]);
                }

                $this->orderService->decreaseStock(
                    $newProduct,
                    $difference
                );
            }


            // Quantity decreased
            elseif ($difference < 0) {

                $this->orderService->increaseStock(
                    $newProduct,
                    abs($difference)
                );
            }
        }


        // Product changed
        else {

            // Return old product stock
            $this->orderService->increaseStock(
                $oldProduct,
                $oldQuantity
            );


            // Check new product stock
            if (!$this->orderService->hasEnoughStock(
                $newProduct,
                $newQuantity
            )) {

                // Restore old product state
                $this->orderService->decreaseStock(
                    $oldProduct,
                    $oldQuantity
                );

                return back()
                    ->withInput()
                    ->withErrors([
                        'quantity' =>
                            'Not enough stock available for the selected product.'
                    ]);
            }


            // Take stock from new product
            $this->orderService->decreaseStock(
                $newProduct,
                $newQuantity
            );
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Update order
    |--------------------------------------------------------------------------
    */

    $order->update([
        'product_id'  => $newProduct->id,
        'customer_id' => $request->customer_id,
        'quantity'    => $newQuantity,
        'unit_price' => $request->unit_price,
        'total_price' => $request->unit_price * $newQuantity,
        'order_date'  => $request->order_date,
        'status'      => $newStatus,
        'driver_id'   => $request->driver_id,
    ]);


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
        'payments'
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