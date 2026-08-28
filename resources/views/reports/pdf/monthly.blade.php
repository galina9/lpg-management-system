<!DOCTYPE html>
<html>

<head>

    <meta charset="UTF-8">

    <style>

        body {
            font-family: DejaVu Sans;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #999;
            padding: 8px;
        }

        th {
            background: #efefef;
        }

        h1,
        h3 {
            text-align: center;
        }

    </style>

</head>

<body>

    <h1>ProGas</h1>

    <h3>
        {{ __('messages.monthly_report') }}
    </h3>

    <p>

        {{ __('messages.month') }}:

        <strong>
            {{ $month }}
        </strong>

    </p>

    <p>

        {{ __('messages.revenue') }}:

        <strong>

            {{ number_format($totalRevenue,0,'.',' ') }}
            AMD

        </strong>

    </p>

    <table>

        <thead>

            <tr>

                <th>{{ __('messages.order') }}</th>

                <th>{{ __('messages.customer') }}</th>

                <th>{{ __('messages.driver') }}</th>

                <th>{{ __('messages.product') }}</th>

                <th>{{ __('messages.quantity') }}</th>

                <th>{{ __('messages.total') }}</th>

                <th>{{ __('messages.status') }}</th>

            </tr>

        </thead>

        <tbody>

        @forelse($orders as $order)

            <tr>

                <td>{{ $order->order_number }}</td>

                <td>{{ $order->customer?->full_name }}</td>

                <td>{{ $order->driver?->name }}</td>

                <td>{{ $order->product?->name }}</td>

                <td>{{ $order->quantity }}</td>

                <td>
                    {{ number_format($order->total_price,0,'.',' ') }}
                </td>

                <td>{{ $order->status }}</td>

            </tr>

        @empty

            <tr>

                <td colspan="7" style="text-align:center;">

                    {{ __('messages.no_data') }}

                </td>

            </tr>

        @endforelse

        </tbody>

    </table>

</body>

</html>