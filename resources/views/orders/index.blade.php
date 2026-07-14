@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="fw-bold mb-1">Orders</h2>
            <small class="text-muted">Manage LPG orders</small>
        </div>

        <a href="{{ route('orders.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-2"></i>
            Add Order
        </a>

    </div>

    <div class="card shadow-sm">

        <div class="card-body">

            <form method="GET">

                <div class="row mb-4">

                    <div class="col-md-6">

                        <input
                            type="text"
                            name="search"
                            class="form-control"
                            placeholder="Search order..."
                            value="{{ request('search') }}">

                    </div>

                    <div class="col-md-2">

                        <button class="btn btn-primary w-100">
                            Search
                        </button>

                    </div>

                    <div class="col-md-2">

                        <a href="{{ route('orders.index') }}"
                           class="btn btn-secondary w-100">
                            Reset
                        </a>

                    </div>

                </div>

            </form>

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead>

                    <tr>

                        <th>#</th>

                        <th>Order No.</th>

                        <th>Customer</th>

                        <th>Phone</th>

                        <th>Product</th>

                        <th>Driver</th>

                        <th>Quantity</th>

                        <th>Total</th>

                        <th>Status</th>

                        <th>Date</th>

                        <th width="140">Actions</th>

                    </tr>

                    </thead>

                    <tbody>

                    @forelse($orders as $order)

                        <tr>

                            <td>{{ $order->id }}</td>

                            <td>{{ $order->order_number }}</td>

                            <td>
                                {{ $order->customer?->full_name ?? '-' }}
                            </td>

                            <td>
                                {{ $order->customer?->phone ?? '-' }}
                            </td>

                            <td>
                                {{ $order->product?->name ?? '-' }}
                            </td>

                            <td>

                                @if($order->driver)

                                    {{ $order->driver->name }}

                                @else

                                    <span class="text-muted">
                                        Not Assigned
                                    </span>

                                @endif

                            </td>

                            <td>{{ $order->quantity }}</td>

                            <td>
                                {{ number_format($order->total_price, 0, '.', ' ') }} AMD
                            </td>

                            <td>

                                @switch($order->status)

                                    @case('Pending')

                                        <span class="badge bg-warning text-dark">
                                            Pending
                                        </span>

                                        @break

                                    @case('Assigned')

                                        <span class="badge bg-info">
                                            Assigned
                                        </span>

                                        @break

                                    @case('On Delivery')

                                        <span class="badge bg-primary">
                                            On Delivery
                                        </span>

                                        @break

                                    @case('Delivered')

                                        <span class="badge bg-success">
                                            Delivered
                                        </span>

                                        @break

                                    @case('Cancelled')

                                        <span class="badge bg-danger">
                                            Cancelled
                                        </span>

                                        @break

                                    @default

                                        <span class="badge bg-secondary">
                                            {{ $order->status }}
                                        </span>

                                @endswitch

                            </td>

                            <td>{{ $order->order_date }}</td>

                            <td>

                                <a href="{{ route('orders.edit', $order) }}"
                                   class="btn btn-warning btn-sm">

                                    <i class="bi bi-pencil"></i>

                                </a>

                                <form action="{{ route('orders.destroy', $order) }}"
                                      method="POST"
                                      class="d-inline">

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('Delete this order?')">

                                        <i class="bi bi-trash"></i>

                                    </button>

                                </form>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="11" class="text-center py-4">

                                No orders found.

                            </td>

                        </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>

            <div class="mt-3">

                {{ $orders->links() }}

            </div>

        </div>

    </div>

</div>

@endsection