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
         <h2>
    {{ __('messages.stock_history') }}
</h2>
      </h2>
      <table>
         <thead>
            <tr>
               <th>{{ __('messages.date') }}</th>
               <th>{{ __('messages.product') }}</th>
               <th>{{ __('messages.type') }}</th>
               <th>{{ __('messages.quantity') }}</th>
               <th>{{ __('messages.before') }}</th>
               <th>{{ __('messages.after') }}</th>
               <th>{{ __('messages.user') }}</th>
            </tr>
         </thead>
         <tbody>

        @foreach($histories as $history)

            <tr>

                <td>{{ $history->created_at }}</td>

                <td>{{ $history->product?->name }}</td>

                <td>
                    @if($history->type === 'IN')
                        {{ __('messages.in') }}
                    @else
                        {{ __('messages.out') }}
                    @endif
                </td>

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