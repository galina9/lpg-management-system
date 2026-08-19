@extends('layouts.app')
@section('content')
<div class="page-wrapper">
   <div class="d-flex justify-content-between align-items-center mb-4">
      <div>
         <h2 class="fw-bold mb-1">
            {{ __('messages.dashboard') }}
         </h2>
         <small class="text-muted">
         {{ __('messages.dashboard_overview') }}
         </small>
      </div>
   </div>
   <div class="row g-4">
      <div class="col-xl-3 col-md-6">
         <div class="card h-100">
            <div class="card-body">
               <h6 class="text-muted">{{ __('messages.products') }}</h6>
               <h2>{{ $totalProducts }}</h2>
            </div>
         </div>
      </div>
      <div class="col-xl-3 col-md-6">
         <div class="card h-100">
            <div class="card-body">
               <h6 class="text-muted">{{ __('messages.customers') }}</h6>
               <h2>{{ $totalCustomers }}</h2>
            </div>
         </div>
      </div>
      <div class="col-xl-3 col-md-6">
         <div class="card h-100">
            <div class="card-body">
               <h6 class="text-muted">{{ __('messages.orders') }}</h6>
               <h2>{{ $totalOrders }}</h2>
            </div>
         </div>
      </div>
      <div class="col-xl-3 col-md-6">
         <div class="card h-100">
            <div class="card-body">
               <h6 class="text-muted">{{ __('messages.users') }}</h6>
               <h2>{{ $totalUsers }}</h2>
            </div>
         </div>
      </div>
   </div>
   <div class="row mt-4">

    <div class="col-lg-12">

        <div class="card shadow-sm">

            <div class="card-header">

                <strong>{{ __('messages.monthly_sales') }}</strong>

            </div>

            <div class="card-body">

                <canvas id="salesChart"></canvas>

            </div>

        </div>

    </div>

</div>
   <div class="row mt-4">
      <div class="col-lg-8">
         <div class="card">
            <div class="card-header">
               <strong>{{ __('messages.latest_orders') }}</strong>
            </div>
            <div class="card-body p-0">
               <div class="table-responsive">
                  <table class="table table-hover mb-0">
                     <thead>
                        <tr>
                           <th>#</th>
                           <th>{{ __('messages.customer') }}</th>
                           <th>{{ __('messages.date') }}</th>
                           <th>{{ __('messages.status') }}</th>
                        </tr>
                     </thead>
                     <tbody>
                        @forelse($latestOrders as $order)
                        <tr>
                           <td>{{ $order->id }}</td>
                           <td>{{ $order->customer->full_name ?? '—' }}</td>
                           <td>{{ $order->order_date }}</td>
                           <td>
                              <x-order-status :status="$order->status" />
                           </td>
                        </tr>
                        @empty
                        <tr>
                           <td colspan="4"
                              class="text-center py-4">
                              {{ __('messages.no_orders_found') }}
                           </td>
                        </tr>
                        @endforelse
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
      </div>
      <div class="col-lg-4">
         <div class="card">
            <div class="card-header">
               <strong>{{ __('messages.low_stock_products') }}</strong>
            </div>
            <div class="card-body">
               @forelse($lowStockProducts as $product)
               <div class="d-flex justify-content-between border-bottom py-2">
                  <span>
                  {{ $product->name }}
                  </span>
                  <span class="badge bg-danger">
                  {{ $product->stock }}
                  </span>
               </div>
               @empty
               <p class="text-muted mb-0">
                  {{ __('messages.all_products_in_stock') }}
               </p>
               @endforelse
            </div>
         </div>
      </div>
   </div>
</div>
<script>

const sales = @json($monthlySales);

const labels = [];
const totals = [];

for (let i = 1; i <= 12; i++) {
    labels.push(i);
    totals.push(sales[i] ?? 0);
}

new Chart(
    document.getElementById('salesChart'),
    {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: "{{ __('messages.monthly_sales') }}",
                data: totals,
                borderWidth: 3,
                fill: false
            }]
        }
    }
);

</script>
@endsection
