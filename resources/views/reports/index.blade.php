@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <h2 class="fw-bold mb-4">
        Reports
    </h2>
    <div class="card mb-4">

    <div class="card-body">

        <form method="GET">

            <div class="row">

                <div class="col-md-4">

                    <label>From</label>

                    <input
                        type="date"
                        name="from"
                        class="form-control"
                        value="{{ request('from') }}">

                </div>

                <div class="col-md-4">

                    <label>To</label>

                    <input
                        type="date"
                        name="to"
                        class="form-control"
                        value="{{ request('to') }}">

                </div>

                <div class="col-md-4 d-flex align-items-end">

                    <button class="btn btn-primary me-2">

                        Apply

                    </button>

                    <a href="{{ route('reports.index') }}"
                       class="btn btn-secondary">

                        Reset

                    </a>

                </div>

            </div>

        </form>

    </div>

</div>

    <div class="row">

        <div class="col-md-6">

            <div class="card">

                <div class="card-body">

                    <h5>Today's Sales</h5>

                    <h2 class="text-success">

                        {{ number_format($dailySales,0,'.',' ') }} AMD

                    </h2>

                </div>

            </div>

        </div>

        <div class="col-md-6">

            <div class="card">

                <div class="card-body">

                    <h5>This Month</h5>

                    <h2 class="text-primary">

                        {{ number_format($monthlySales,0,'.',' ') }} AMD

                    </h2>

                </div>

            </div>

        </div>
        <div class="card mt-4">

    <div class="card-header">

        <strong>Top Customers</strong>

    </div>

    <div class="card-body p-0">

        <table class="table table-hover mb-0">

            <thead>

                <tr>

                    <th>Customer</th>

                    <th>Orders</th>

                    <th>Total Sales</th>

                </tr>

            </thead>

            <tbody>

                @forelse($topCustomers as $customer)

                    <tr>

                        <td>

                            {{ $customer->customer?->full_name ?? '-' }}

                        </td>

                        <td>

                            {{ $customer->total_orders }}

                        </td>

                        <td>

                            {{ number_format($customer->total_sales,0,'.',' ') }} AMD

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="3" class="text-center">

                            No data

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

        <div class="card mt-4">

    <div class="card-header">

        <strong>Product Sales</strong>

    </div>

    <div class="card-body p-0">

        <table class="table table-striped mb-0">

            <thead>

                <tr>

                    <th>Product</th>

                    <th>Quantity Sold</th>

                    <th>Revenue</th>

                </tr>

            </thead>

            <tbody>

                @forelse($productSales as $product)

                    <tr>

                        <td>

                            {{ $product->product?->name ?? '-' }}

                        </td>

                        <td>

                            {{ number_format($product->total_quantity,2) }}

                        </td>

                        <td>

                            {{ number_format($product->total_revenue,0,'.',' ') }} AMD

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="3" class="text-center">

                            No sales yet.

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>
    </div>

</div>

@endsection