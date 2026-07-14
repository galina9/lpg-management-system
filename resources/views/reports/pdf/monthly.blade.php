<!DOCTYPE html>
<html>
   <head>
      <meta charset="UTF-8">
      <style>
         body{
         font-family: DejaVu Sans;
         font-size:12px;
         }
         table{
         width:100%;
         border-collapse:collapse;
         margin-top:20px;
         }
         th,td{
         border:1px solid #999;
         padding:8px;
         }
         th{
         background:#efefef;
         }
         h1,h3{
         text-align:center;
         }
      </style>
   </head>
   <body>
      <h1>LPG ERP</h1>
      <h3>Monthly Report</h3>
      <p>
         Month:
         <strong>{{ $month }}</strong>
      </p>
      <p>
         Revenue:
         <strong>
         {{ number_format($totalRevenue,0,'.',' ') }}
         AMD
         </strong>
      </p>
      <table>
         <thead>
            <tr>
               <th>Order</th>
               <th>Customer</th>
               <th>Driver</th>
               <th>Product</th>
               <th>Qty</th>
               <th>Total</th>
               <th>Status</th>
            </tr>
         </thead>
         <tbody>
            @foreach($orders as $order)
            <tr>
               <td>{{ $order->order_number }}</td>
               <td>{{ $order->customer?->full_name }}</td>
               <td>{{ $order->driver?->name }}</td>
               <td>{{ $order->product?->name }}</td>
               <td>{{ $order->quantity }}</td>
               <td>{{ number_format($order->total_price,0,'.',' ') }}</td>
               <td>{{ $order->status }}</td>
            </tr>
            @endforeach
         </tbody>
      </table>
   </body>
</html>