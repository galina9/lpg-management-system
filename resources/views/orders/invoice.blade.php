<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">

    <style>
        body{
            font-family: DejaVu Sans;
            font-size:13px;
            color:#333;
        }

        h1{
            text-align:center;
            margin-bottom:5px;
        }

        h3{
            text-align:center;
            margin-top:0;
            color:#666;
        }

        table{
            width:100%;
            border-collapse:collapse;
            margin-top:15px;
        }

        th,td{
            border:1px solid #ccc;
            padding:8px;
        }

        th{
            background:#f2f2f2;
        }

        .section{
            margin-top:25px;
        }

        .total{
            text-align:right;
            font-size:18px;
            font-weight:bold;
            margin-top:20px;
        }

        .footer{
            text-align:center;
            margin-top:40px;
            color:#888;
        }
    </style>
</head>

<body>

    <h1>ProGas MANAGEMENT SYSTEM</h1>

    <h3>{{ __('messages.invoice') }}</h3>

    <table>

        <tr>
            <th>{{ __('messages.invoice_date') }}</th>

            <td>
                {{ now()->format('d/m/Y') }}
            </td>
        </tr>

        <tr>
            <th>{{ __('messages.order_number') }}</th>

            <td>
                {{ $order->order_number }}
            </td>
        </tr>

        <tr>
            <th>{{ __('messages.order_date') }}</th>

            <td>
                {{ $order->order_date }}
            </td>
        </tr>

    </table>


    <div class="section">

        <h3>{{ __('messages.customer') }}</h3>

        <table>

            <tr>
                <th>{{ __('messages.name') }}</th>

                <td>
                    {{ $order->customer?->full_name }}
                </td>
            </tr>

            <tr>
                <th>{{ __('messages.phone') }}</th>

                <td>
                    {{ $order->customer?->phone }}
                </td>
            </tr>

        </table>

    </div>


    <div class="section">

        <h3>{{ __('messages.product') }}</h3>

        <table>

            <thead>
                <tr>

                    <th>{{ __('messages.product') }}</th>

                    <th>{{ __('messages.quantity') }}</th>

                    <th>{{ __('messages.unit_price') }}</th>

                    <th>{{ __('messages.total') }}</th>

                </tr>
            </thead>

            <tbody>

                <tr>

                    <td>
                        {{ $order->product?->name }}
                    </td>

                    <td>
                        {{ $order->quantity }}
                    </td>

                    <td>
                        {{ number_format($order->unit_price,0,'.',' ') }} AMD
                    </td>

                    <td>
                        {{ number_format($order->total_price,0,'.',' ') }} AMD
                    </td>

                </tr>

            </tbody>

        </table>

    </div>


    <div class="section">

        <h3>{{ __('messages.payment') }}</h3>

        <table>

            <tr>

                <th>{{ __('messages.status') }}</th>

                <td>
                    {{ $order->payment?->status ?? __('messages.no_payment') }}
                </td>

            </tr>

            <tr>

                <th>{{ __('messages.method') }}</th>

                <td>
                    {{ $order->payment?->method ?? '-' }}
                </td>

            </tr>

            <tr>

                <th>{{ __('messages.amount_paid') }}</th>

                <td>

                    @if($order->payment)

                        {{ number_format($order->payment->amount,0,'.',' ') }} AMD

                    @else

                        0 AMD

                    @endif

                </td>

            </tr>

        </table>

    </div>


    <div class="total">

        {{ __('messages.total') }}:

        {{ number_format($order->total_price,0,'.',' ') }} AMD

    </div>


    <div class="footer">

        {{ __('messages.thank_you') }}

    </div>

</body>
</html>