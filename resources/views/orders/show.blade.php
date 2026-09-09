@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2>
            {{ __('messages.order_details') }}
        </h2>

        <a href="{{ route('payments.create', ['order' => $order->id]) }}" class="btn btn-success">
            <i class="bi bi-plus-circle me-1"></i>
            {{ __('messages.add_payment') }}

        </a>


        <a href="{{ route('orders.index') }}" class="btn btn-secondary">
            {{ __('messages.back') }}
        </a>

    </div>

    <div class="card shadow-sm">

        <div class="card-body">

            <h4 class="fw-bold mb-4">
                {{ $order->order_number }}
            </h4>

            <div class="row">

                {{-- Customer --}}
                <div class="col-md-12 mb-3">
                    <strong>{{ __('messages.customer') }}:</strong>
                    {{ $order->customer?->full_name }}
                </div>

                {{-- Phone --}}
                <div class="col-md-12 mb-3">
                    <strong>{{ __('messages.phone') }}:</strong>
                    {{ $order->customer?->phone }}
                </div>

                
                {{-- Address --}}
                <div class="col-md-12 mb-3">
                    <strong>{{ __('messages.address') }}:</strong>

                    @if($order->customer)

                        @php
                            $addressParts = array_filter([
                                $order->customer->region,
                                $order->customer->city,
                                $order->customer->address,
                            ]);
                        @endphp

                        {{ implode(', ', $addressParts) }}

                        @if($order->customer->apartment)
                            , {{ __('messages.apartment') }} {{ $order->customer->apartment }}
                        @endif

                    @else

                        <span class="text-muted">
                            {{ __('messages.no_address') }}
                        </span>

                    @endif
                </div>
                {{-- Product --}}
                <div class="col-md-6 mb-3">
                    <strong>{{ __('messages.product') }}:</strong>
                    {{ $order->product?->name }}
                </div>

                {{-- Quantity --}}
                <div class="col-md-6 mb-3">
                    <strong>{{ __('messages.quantity') }}:</strong>
                    {{ $order->quantity }}
                </div>

                {{-- Unit Price --}}
                <div class="col-md-6 mb-3">
                    <strong>{{ __('messages.unit_price') }}:</strong>
                    {{ number_format($order->unit_price, 2) }}
                </div>

                {{-- Total Price --}}
                <div class="col-md-6 mb-3">
                    <strong>{{ __('messages.total_price') }}:</strong>
                    {{ number_format($order->total_price, 2) }}
                </div>
                {{-- Payment Summary --}}
                @php
                    $paidAmount = $order->payments->sum('amount');
                    $remainingAmount = max(0, $order->total_price - $paidAmount);
                @endphp

                <div class="col-md-6 mb-3">
                    <strong>{{ __('messages.paid_amount') }}:</strong>
                    {{ number_format($paidAmount, 2) }}
                </div>

                <div class="col-md-6 mb-3">
                    <strong>{{ __('messages.remaining_amount') }}:</strong>
                    {{ number_format($remainingAmount, 2) }}
                </div>

                <div class="col-md-6 mb-3">
                    <strong>{{ __('messages.payment_status') }}:</strong>

                    @if($paidAmount <= 0)

                        <span class="badge bg-danger">
                            {{ __('messages.unpaid') }}
                        </span>

                    @elseif($paidAmount < $order->total_price)

                        <span class="badge bg-warning text-dark">
                            {{ __('messages.partial') }}
                        </span>

                    @else

                        <span class="badge bg-success">
                            {{ __('messages.paid') }}
                        </span>

                    @endif
                </div>
                {{-- Payments History --}}
<div class="col-12 mt-4">

    <div class="card border-0 shadow-sm">

        <div class="card-header bg-light">

            <h5 class="mb-0 fw-bold">
                {{ __('messages.payment_history') }}
            </h5>

        </div>

        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <thead>
                        <tr>

                            <th>
                                {{ __('messages.payment_date') }}
                            </th>

                            <th>
                                {{ __('messages.amount') }}
                            </th>

                            <th>
                                {{ __('messages.payment_method') }}
                            </th>

                            <th>
                                {{ __('messages.status') }}
                            </th>

                            <th>
                                {{ __('messages.note') }}
                            </th>

                        </tr>
                    </thead>

                    <tbody>

                        @forelse($order->payments as $payment)

                            <tr>

                                <td>
                                    {{ $payment->payment_date }}
                                </td>

                                <td class="fw-bold">
                                    {{ number_format($payment->amount, 2) }} AMD
                                </td>

                                <td>

                                    @if($payment->method === 'Cash')

                                        {{ __('messages.cash') }}

                                    @elseif($payment->method === 'Card')

                                        {{ __('messages.card') }}

                                    @else

                                        {{ __('messages.bank_transfer') }}

                                    @endif

                                </td>

                                <td>

                                    @if($payment->status === 'Paid')

                                        <span class="badge bg-success">
                                            {{ __('messages.paid') }}
                                        </span>

                                    @elseif($payment->status === 'Partial')

                                        <span class="badge bg-warning text-dark">
                                            {{ __('messages.partial') }}
                                        </span>

                                    @else

                                        <span class="badge bg-danger">
                                            {{ __('messages.unpaid') }}
                                        </span>

                                    @endif

                                </td>

                                <td>
                                    {{ $payment->note ?? '-' }}
                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="5" class="text-center text-muted py-4">

                                    {{ __('messages.no_payments_found') }}

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>
                {{-- Driver --}}
                <div class="col-md-6 mb-3">
                    <strong>{{ __('messages.driver') }}:</strong>
                    {{ $order->driver?->name ?? '-' }}
                </div>

                {{-- Order Date --}}
                <div class="col-md-6 mb-3">
                    <strong>{{ __('messages.order_date') }}:</strong>
                    {{ $order->order_date }}
                </div>

                {{-- Status --}}
                <div class="col-md-6 mb-3">

                    <strong>{{ __('messages.status') }}:</strong>

                    @if($order->status === 'Assigned')

                        <span class="badge bg-primary">
                            {{ __('messages.assigned') }}
                        </span>

                    @elseif($order->status === 'On Delivery')

                        <span class="badge bg-warning text-dark">
                            {{ __('messages.on_delivery') }}
                        </span>

                    @elseif($order->status === 'Delivered')

                        <span class="badge bg-success">
                            {{ __('messages.delivered') }}
                        </span>

                    @elseif($order->status === 'Cancelled')

                        <span class="badge bg-danger">
                            {{ __('messages.cancelled') }}
                        </span>

                    @else

                        <span class="badge bg-secondary">
                            {{ $order->status }}
                        </span>

                    @endif

                </div>

            </div>

        </div>

    </div>

</div>

@endsection