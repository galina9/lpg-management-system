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
         }
         th,td{
         border:1px solid #000;
         padding:6px;
         }
         th{
         background:#eee;
         }
      </style>
   </head>
   <body>
      <h2>
         Stock History
      </h2>
      <table>
         <thead>
            <tr>
               <th>Date</th>
               <th>Product</th>
               <th>Type</th>
               <th>Qty</th>
               <th>Before</th>
               <th>After</th>
               <th>User</th>
            </tr>
         </thead>
         <tbody>
            @foreach($histories as $history)
            <tr>
               <td>{{ $history->created_at }}</td>
               <td>{{ $history->product?->name }}</td>
               <td>{{ $history->type }}</td>
               <td>{{ $history->quantity }}</td>
               <td>{{ $history->stock_before }}</td>
               <td>{{ $history->stock_after }}</td>
               <td>{{ $history->user?->name }}</td>
            </tr>
            @endforeach
         </tbody>
      </table>
   </body>
</html>