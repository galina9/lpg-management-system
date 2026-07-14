<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;


class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $payments = Payment::with('order.customer')
            ->latest()
            ->paginate(10);

        return view(
            'payments.index',
            compact('payments')
        );
    }
    /**
     * Show the form for creating a new resource.
     */
  public function create(Request $request)
    {
        $orders = Order::with('customer')
            ->orderByDesc('id')
            ->get();

        $selectedOrder = null;

        if ($request->filled('order')) {
            $selectedOrder = Order::find($request->order);
        }

        $payment = new Payment();

        return view(
            'payments.create',
            compact(
                'orders',
                'payment',
                'selectedOrder'
            )
        );
    }

    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request)
    {
        $request->validate([

            'order_id' => 'required|exists:orders,id',

            'amount' => 'required|numeric|min:0',

            'method' => 'required',

            'status' => 'required',

            'payment_date' => 'required|date',

            'note' => 'nullable'

        ]);

        Payment::create($request->all());

        return redirect()
            ->route('payments.index')
            ->with('success','Payment added successfully.');
    }

 

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payment $payment)
    {
        $orders = Order::with('customer')
            ->orderByDesc('id')
            ->get();

        return view(
            'payments.edit',
            compact('payment', 'orders')
        );
    }
    /**
     * Update the specified resource in storage.
     */
   public function update(Request $request, Payment $payment)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'amount' => 'required|numeric|min:0',
            'method' => 'required',
            'status' => 'required',
            'payment_date' => 'required|date',
            'note' => 'nullable',
        ]);

        $payment->update($request->all());

        return redirect()
            ->route('payments.index')
            ->with('success', 'Payment updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment)
    {
        $payment->delete();

        return redirect()
            ->route('payments.index')
            ->with('success', 'Payment deleted successfully.');
    }
}
