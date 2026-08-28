@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2>
            {{ __('messages.order_details') }}
        </h2>

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