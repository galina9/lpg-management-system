@extends('layouts.app')
@section('content')
<div class="page-wrapper">
   <div class="d-flex justify-content-between align-items-center mb-4">
      <div>
         <h2 class="fw-bold mb-1">
            Dashboard
         </h2>
         <small class="text-muted">
         LPG Management System Overview
         </small>
      </div>
   </div>
   <div class="row g-4">
      <div class="col-xl-3 col-md-6">
         <div class="card h-100">
            <div class="card-body">
               <h6 class="text-muted">Products</h6>
               <h2>{{ $totalProducts }}</h2>
            </div>
         </div>
      </div>
      <div class="col-xl-3 col-md-6">
         <div class="card h-100">
            <div class="card-body">
               <h6 class="text-muted">Customers</h6>
               <h2>{{ $totalCustomers }}</h2>
            </div>
         </div>
      </div>
      <div class="col-xl-3 col-md-6">
         <div class="card h-100">
            <div class="card-body">
               <h6 class="text-muted">Orders</h6>
               <h2>{{ $totalOrders }}</h2>
            </div>
         </div>
      </div>
      <div class="col-xl-3 col-md-6">
         <div class="card h-100">
            <div class="card-body">
               <h6 class="text-muted">Users</h6>
               <h2>{{ $totalUsers }}</h2>
            </div>
         </div>
      </div>
   </div>
   <div class="row mt-4">
      <div class="col-lg-8">
         <div class="card">
            <div class="card-header">
               <strong>Latest Orders</strong>
            </div>
            <div class="card-body p-0">
               <div class="table-responsive">
                  <table class="table table-hover mb-0">
                     <thead>
                        <tr>
                           <th>#</th>
                           <th>Customer</th>
                           <th>Date</th>
                           <th>Status</th>
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
                              No orders found.
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
               <strong>Low Stock Products</strong>
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
                  All products have sufficient stock.
               </p>
               @endforelse
            </div>
         </div>
      </div>
   </div>
</div>
@endsection