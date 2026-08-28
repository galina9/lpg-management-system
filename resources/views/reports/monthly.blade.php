@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <h2 class="mb-4" style="display: inline;">
        {{ __('messages.monthly_report') }}
    </h2>

    <a
        href="{{ route('reports.monthly.pdf', ['month' => $month]) }}"
        class="btn btn-danger m-4">

        <i class="bi bi-file-earmark-pdf"></i>

        {{ __('messages.export_pdf') }}

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

                {{ __('messages.show') }}

            </button>

        </div>

    </form>

    <table class="table table-bordered">

        <thead>

        <tr>

            <th>#</th>

            <th>{{ __('messages.order') }}</th>

            <th>{{ __('messages.customer') }}</th>

            <th>{{ __('messages.driver') }}</th>

            <th>{{ __('messages.product') }}</th>

            <th>{{ __('messages.total') }}</th>

            <th>{{ __('messages.status') }}</th>

        </tr>

        </thead>

        <tbody>

        @forelse($orders as $order)

            <tr>

                <td>{{ $order->id }}</td>

                <td>{{ $order->order_number }}</td>

                <td>{{ $order->customer?->full_name }}</td>

                <td>{{ $order->driver?->name }}</td>

                <td>{{ $order->product?->name }}</td>

                <td>
                    {{ number_format($order->total_price,0,'.',' ') }} AMD
                </td>

                <td>{{ $order->status }}</td>

            </tr>

        @empty

            <tr>

                <td colspan="7" class="text-center">

                    {{ __('messages.no_data') }}

                </td>

            </tr>

        @endforelse

        </tbody>

    </table>

</div>

@endsection