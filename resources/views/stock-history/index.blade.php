@extends('layouts.app')
@section('content')
<div class="container-fluid">
   <div class="d-flex justify-content-between align-items-center mb-4">
      <div>
         <h2 class="fw-bold">
            Stock History
         </h2>
         <small class="text-muted">
         Product stock movements
         </small>
      </div>
   </div>
   <div class="card shadow-sm">
      <div class="card-body">
         <div class="table-responsive">
            <form method="GET">

    <div class="row mb-4 align-items-end">

        <div class="col-md-3">

            <label class="form-label">Product</label>

            <input
                type="text"
                name="product"
                class="form-control"
                placeholder="Search product..."
                value="{{ request('product') }}">

        </div>

        <div class="col-md-2">

            <label class="form-label">Type</label>

            <select
                name="type"
                class="form-select">

                <option value="">All</option>

                <option value="IN"
                    {{ request('type') == 'IN' ? 'selected' : '' }}>
                    IN
                </option>

                <option value="OUT"
                    {{ request('type') == 'OUT' ? 'selected' : '' }}>
                    OUT
                </option>

            </select>

        </div>

        <div class="col-md-2">

            <label class="form-label">From</label>

            <input
                type="date"
                name="from"
                class="form-control"
                value="{{ request('from') }}">

        </div>

        <div class="col-md-2">

            <label class="form-label">To</label>

            <input
                type="date"
                name="to"
                class="form-control"
                value="{{ request('to') }}">

        </div>

        <div class="col-md-1">

            <button class="btn btn-primary w-100">

                Search

            </button>

        </div>

        <div class="col-md-1">

            <a
                href="{{ route('stock-history.index') }}"
                class="btn btn-secondary w-100">

                Reset

            </a>

        </div>

        <div class="col-md-1 d-flex gap-2">

            <a
                href="{{ route('stock-history.excel') }}"
                class="btn btn-success"
                title="Export Excel">

                <i class="bi bi-file-earmark-excel"></i>

            </a>

            <a
                href="{{ route('stock-history.pdf') }}"
                class="btn btn-danger"
                title="Export PDF">

                <i class="bi bi-file-earmark-pdf"></i>

            </a>

        </div>

    </div>

</form>
            <table class="table table-hover">
               <thead>
                  <tr>
                     <th>Date</th>
                     <th>Product</th>
                     <th>Type</th>
                     <th>Quantity</th>
                     <th>Before</th>
                     <th>After</th>
                     <th>User</th>
                     <th>Note</th>
                  </tr>
               </thead>
               <tbody>
                  @forelse($histories as $history)
                  <tr>
                     <td>
                        {{ $history->created_at }}
                     </td>
                     <td>
                        {{ $history->product?->name }}
                     </td>
                     <td>
                        @if($history->type=='IN')
                        <span class="badge bg-success">
                        IN
                        </span>
                        @else
                        <span class="badge bg-danger">
                        OUT
                        </span>
                        @endif
                     </td>
                     <td>
                        {{ $history->quantity }}
                     </td>
                     <td>
                        {{ $history->stock_before }}
                     </td>
                     <td>
                        {{ $history->stock_after }}
                     </td>
                     <td>
                        {{ $history->user?->name }}
                     </td>
                     <td>
                        {{ $history->note }}
                     </td>
                  </tr>
                  @empty
                  <tr>
                     <td colspan="8" class="text-center">
                        No history found.
                     </td>
                  </tr>
                  @endforelse
               </tbody>
            </table>
         </div>
         {{ $histories->links() }}
      </div>
   </div>
</div>
@endsection