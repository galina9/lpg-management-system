@extends('layouts.app')
@section('content')
<div class="container-fluid">
   <div class="d-flex justify-content-between align-items-center mb-4">
      <div>
         <h2 class="fw-bold mb-1">{{ __('messages.orders') }}</h2>
         <small class="text-muted">{{ __('messages.manage_orders') }}</small>
      </div>
      <a href="{{ route('orders.create') }}" class="btn btn-primary">
      <i class="bi bi-plus-circle me-2"></i>
      {{ __('messages.add_order') }}
      </a>
   </div>
   <div class="card shadow-sm">
      <div class="card-body">
         <form method="GET">
            <div class="row mb-4">
               <div class="col-md-6">
                  <input
                     type="text"
                     name="search"
                     class="form-control"
                     placeholder="{{ __('messages.search_order') }}"
                     value="{{ request('search') }}">
               </div>
               <div class="col-md-2">
                  <button class="btn btn-primary w-100">
                  {{ __('messages.search') }}
                  </button>
               </div>
               <div class="col-md-2">
                  <a href="{{ route('orders.index') }}"
                     class="btn btn-secondary w-100">
                  {{ __('messages.reset') }}
                  </a>
               </div>
            </div>
         </form>
         <div class="table-responsive">
            <table class="table table-hover align-middle">
               <thead>
                  <tr>
                     <th>#</th>
                     <th>{{ __('messages.order_number') }}.</th>
                     <th>{{ __('messages.customer') }}</th>
                     <th>{{ __('messages.phone') }}</th>
                     <th>{{ __('messages.product') }}</th>
                     <th>{{ __('messages.driver') }}</th>
                     <th>{{ __('messages.quantity') }}</th>
                     <th>{{ __('messages.total') }}</th>
                     <th>{{ __('messages.status') }}</th>
                     <th>{{ __('messages.payment') }}</th>
                     <th>{{ __('messages.date') }}</th>
                     <th width="140">{{ __('messages.actions') }}</th>
                  </tr>
               </thead>
               <tbody>
                  @forelse($orders as $order)
                  <tr>
                     <td>{{ $order->id }}</td>
                     <td>{{ $order->order_number }}</td>
                     <td>
                        {{ $order->customer?->full_name ?? '-' }}
                     </td>
                     <td>
                        {{ $order->customer?->phone ?? '-' }}
                     </td>
                     <td>
                        {{ $order->product?->name ?? '-' }}
                     </td>
                     <td>
                        @if($order->driver)
                        {{ $order->driver->name }}
                        @else
                        <span class="text-muted">
                        {{ __('messages.not_assigned') }}
                        </span>
                        @endif
                     </td>
                     <td>{{ $order->quantity }}</td>
                     <td>
                        {{ number_format($order->total_price, 0, '.', ' ') }} AMD
                     </td>
                     <td>
                        @switch($order->status)
                        @case('Pending')
                        <span class="badge bg-warning text-dark">
                        {{ __('messages.pending') }}
                        </span>
                        @break
                        @case('Assigned')
                        <span class="badge bg-info">
                        {{ __('messages.assigned') }}
                        </span>
                        @break
                        @case('On Delivery')
                        <span class="badge bg-primary">
                        {{ __('messages.on_delivery') }}
                        </span>
                        @break
                        @case('Delivered')
                        <span class="badge bg-success">
                        {{ __('messages.delivered') }}
                        </span>
                        @break
                        @case('Cancelled')
                        <span class="badge bg-danger">
                        {{ __('messages.cancelled') }}
                        </span>
                        @break
                        @default
                        <span class="badge bg-secondary">
                        {{ $order->status }}
                        </span>
                        @endswitch
                     </td>
                     <td>
                        @if($order->payment)
                        @if($order->payment->status=='Paid')
                        <span class="badge bg-success">
                        {{ __('messages.paid') }}
                        </span>
                        @elseif($order->payment->status=='Partial')
                        <span class="badge bg-warning text-dark">
                        {{ __('messages.partial') }}
                        </span>
                        @else
                        <span class="badge bg-danger">
                        {{ __('messages.unpaid') }}
                        </span>
                        @endif
                        @else
                        <span class="badge bg-secondary">
                        {{ __('messages.no_payment') }}
                        </span>
                        @endif
                     </td>
                     <td>{{ $order->order_date }}</td>
                     <td>
                        <a href="{{ route('orders.edit', $order) }}"
                           class="btn btn-warning btn-sm">
                        <i class="bi bi-pencil"></i>
                        </a>
                        @if($order->payment)
                        <a
                           href="{{ route('payments.edit', $order->payment) }}"
                           class="btn btn-info btn-sm"
                           title="{{ __('messages.edit_payment') }}">
                        <i class="bi bi-credit-card"></i>
                        </a>
                        @else
                        <a
                           href="{{ route('payments.create', ['order' => $order->id]) }}"
                           class="btn btn-success btn-sm"
                           title="{{ __('messages.add_payment') }}">
                        <i class="bi bi-cash-stack"></i>
                        </a>
                        @endif
                        <a
    href="{{ route('orders.invoice', $order) }}"
    class="btn btn-secondary btn-sm"
    title="{{ __('messages.invoice') }}">

    <i class="bi bi-receipt"></i>

</a>
                        <form action="{{ route('orders.destroy', $order) }}"
                           method="POST"
                           class="d-inline">
                           @csrf
                           @method('DELETE')
                           <button
                              type="submit"
                              class="btn btn-danger btn-sm"
                              onclick="return confirm('{{ __('messages.delete_order') }}')">
                           <i class="bi bi-trash"></i>
                           </button>
                        </form>
                     </td>
                  </tr>
                  @empty
                  <tr>
                     <td colspan="12" class="text-center py-4">
                       {{ __('messages.no_orders_found') }}
                     </td>
                  </tr>
                  @endforelse
               </tbody>
            </table>
         </div>
         <div class="mt-3">
            {{ $orders->links() }}
         </div>
      </div>
   </div>
</div>
@endsection