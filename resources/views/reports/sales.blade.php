@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold mb-1">

                Sales Report

            </h2>

            <small class="text-muted">

                Sales by date

            </small>

        </div>

    </div>

    <div class="card mb-4">

        <div class="card-body">

            <form method="GET">

                <div class="row">

                    <div class="col-md-4">

                        <label class="form-label">

                            From

                        </label>

                        <input
                            type="date"
                            name="from"
                            class="form-control"
                            value="{{ request('from') }}">

                    </div>

                    <div class="col-md-4">

                        <label class="form-label">

                            To

                        </label>

                        <input
                            type="date"
                            name="to"
                            class="form-control"
                            value="{{ request('to') }}">

                    </div>

                    <div class="col-md-4 d-flex align-items-end">

                        <button class="btn btn-primary w-100">

                            Filter

                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>

    <div class="row mb-4">

        <div class="col-md-4">

            <div class="card">

                <div class="card-body">

                    <h6>Total Sales</h6>

                    <h2>

                        ${{ number_format($totalSales,2) }}

                    </h2>

                </div>

            </div>

        </div>

        <div class="col-md-4">

            <div class="card">

                <div class="card-body">

                    <h6>Total Orders</h6>

                    <h2>

                        {{ $orders->count() }}

                    </h2>

                </div>

            </div>

        </div>

        <div class="col-md-4">

            <div class="card">

                <div class="card-body">

                    <h6>Average Order</h6>

                    <h2>

                        ${{ $orders->count() ? number_format($totalSales / $orders->count(),2) : '0.00' }}

                    </h2>

                </div>

            </div>

        </div>

    </div>

    <div class="card">

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-hover">

                    <thead>

                        <tr>

                            <th>#</th>

                            <th>Customer</th>

                            <th>Date</th>

                            <th>Status</th>

                            <th>Total</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($orders as $order)

                            <tr>

                                <td>{{ $order->id }}</td>

                                <td>

                                    {{ $order->customer_name ?? '-' }}

                                </td>

                                <td>

                                    {{ $order->order_date }}

                                </td>

                                <td>

                                    {{ $order->status }}

                                </td>

                                <td>

                                    ${{ number_format($order->total_price,2) }}

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="5"
                                    class="text-center">

                                    No data found.

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