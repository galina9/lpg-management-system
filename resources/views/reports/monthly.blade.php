@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <h2 class="mb-4" style="display: inline;">
        Monthly Report
    </h2>
     <a

	    href="{{ route('reports.monthly.pdf', ['month'=>$month]) }}"

	    class="btn btn-danger m-4">

	    <i class="bi bi-file-earmark-pdf"></i>

	    Export PDF

</a>
    <form method="GET" class="row mb-4">

        <div class="col-md-3">

            <input
                type="month"
                name="month"
                class="form-control"
                value="{{ $month }}">

        </div>

        <div class="col-md-2">

            <button class="btn btn-primary">

                Show

            </button>


        </div>


    </form>

    <table class="table table-bordered">

        <thead>

        <tr>

            <th>#</th>

            <th>Order</th>

            <th>Customer</th>

            <th>Driver</th>

            <th>Product</th>

            <th>Total</th>

            <th>Status</th>

        </tr>

        </thead>

        <tbody>

        @foreach($orders as $order)

            <tr>

                <td>{{ $order->id }}</td>

                <td>{{ $order->order_number }}</td>

                <td>{{ $order->customer?->full_name }}</td>

                <td>{{ $order->driver?->name }}</td>

                <td>{{ $order->product?->name }}</td>

                <td>{{ number_format($order->total_price,0,'.',' ') }} AMD</td>

                <td>{{ $order->status }}</td>

            </tr>

        @endforeach

        </tbody>

    </table>

</div>

@endsection