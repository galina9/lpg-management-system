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
      <h1>LPG MANAGEMENT SYSTEM</h1>
      <h3>INVOICE</h3>
      <table>
         <tr>
            <th>Invoice Date</th>
            <td>{{ now()->format('d/m/Y') }}</td>
         </tr>
         <tr>
            <th>Order Number</th>
            <td>{{ $order->order_number }}</td>
         </tr>
         <tr>
            <th>Order Date</th>
            <td>{{ $order->order_date }}</td>
         </tr>
      </table>
      <div class="section">
         <h3>Customer</h3>
         <table>
            <tr>
               <th>Name</th>
               <td>{{ $order->customer?->full_name }}</td>
            </tr>
            <tr>
               <th>Phone</th>
               <td>{{ $order->customer?->phone }}</td>
            </tr>
         </table>
      </div>
      <div class="section">
         <h3>Product</h3>
         <table>
            <thead>
               <tr>
                  <th>Product</th>
                  <th>Quantity</th>
                  <th>Unit Price</th>
                  <th>Total</th>
               </tr>
            </thead>
            <tbody>
               <tr>
                  <td>{{ $order->product?->name }}</td>
                  <td>{{ $order->quantity }}</td>
                  <td>{{ number_format($order->unit_price,0,'.',' ') }} AMD</td>
                  <td>{{ number_format($order->total_price,0,'.',' ') }} AMD</td>
               </tr>
            </tbody>
         </table>
      </div>
      <div class="section">
         <h3>Payment</h3>
         <table>
            <tr>
               <th>Status</th>
               <td>
                  {{ $order->payment?->status ?? 'No Payment' }}
               </td>
            </tr>
            <tr>
               <th>Method</th>
               <td>
                  {{ $order->payment?->method ?? '-' }}
               </td>
            </tr>
            <tr>
               <th>Amount Paid</th>
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
         Total:
         {{ number_format($order->total_price,0,'.',' ') }} AMD
      </div>
      <div class="footer">
         Thank you for choosing LPG Management System
      </div>
   </body>
</html>