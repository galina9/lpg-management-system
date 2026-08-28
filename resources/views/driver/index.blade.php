@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2 class="mb-0">
            {{ __('messages.my_deliveries') }}
        </h2>

    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="row">

        @forelse($orders as $order)

            <div class="col-md-6 col-lg-4">

                <div class="card shadow-sm mb-4">

                    <div class="card-body">

                        {{-- Order Number --}}
                        <h5 class="fw-bold mb-3">
                            {{ $order->order_number }}
                        </h5>

                        {{-- Customer --}}
                        <p class="mb-2">
                            <strong>{{ __('messages.customer') }}:</strong>
                            {{ $order->customer?->full_name }}
                        </p>

                        {{-- Phone --}}
                        <p class="mb-2">
                            <strong>{{ __('messages.phone') }}:</strong>
                            {{ $order->customer?->phone }}
                        </p>

                        {{-- Address --}}
<p class="mb-3">
    <strong>{{ __('messages.address') }}:</strong>

    @if($order->customer)

        @php
            $addressParts = [];

            if ($order->customer->region) {
                $addressParts[] = $order->customer->region;
            }

            if ($order->customer->city) {
                $addressParts[] = $order->customer->city;
            }

            if ($order->customer->address) {
                $addressParts[] = $order->customer->address;
            }

            if ($order->customer->apartment) {
                $addressParts[] =
                    __('messages.apartment') . ' ' . $order->customer->apartment;
            }
        @endphp

        @if(count($addressParts))
            {{ implode(', ', $addressParts) }}
        @else
            <span class="text-muted">
                {{ __('messages.no_address') }}
            </span>
        @endif

    @else

        <span class="text-muted">
            {{ __('messages.no_address') }}
        </span>

    @endif
</p>

                        {{-- Product --}}
                        <p class="mb-2">
                            <strong>{{ __('messages.product') }}:</strong>
                            {{ $order->product?->name }}
                        </p>

                        {{-- Quantity --}}
                        <p class="mb-2">
                            <strong>{{ __('messages.quantity') }}:</strong>
                            {{ $order->quantity }}
                        </p>

                        {{-- Status --}}
                        <p class="mb-3">

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

                        </p>

                        {{-- Start Delivery --}}
                        @if($order->status === 'Assigned')

                            <form
                                action="{{ route('driver.orders.start', $order) }}"
                                method="POST">

                                @csrf
                                @method('PATCH')

                                <button class="btn btn-primary w-100">

                                    <i class="bi bi-truck me-2"></i>

                                    {{ __('messages.start_delivery') }}

                                </button>

                            </form>

                        @endif

                        {{-- Complete Delivery --}}
                        @if($order->status === 'On Delivery')

                            <form
                                action="{{ route('driver.orders.complete', $order) }}"
                                method="POST">

                                @csrf
                                @method('PATCH')

                                <button class="btn btn-success w-100">

                                    <i class="bi bi-check-circle me-2"></i>

                                    {{ __('messages.mark_delivered') }}

                                </button>

                            </form>

                        @endif

                    </div>

                </div>

            </div>

        @empty

            <div class="col-12">

                <div class="alert alert-info">
                    {{ __('messages.no_deliveries_assigned') }}
                </div>

            </div>

        @endforelse

    </div>

</div>

@endsection