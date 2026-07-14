@extends('layouts.app')
@section('content')
<div class="container-fluid">
   <div class="d-flex justify-content-between align-items-center mb-4">
      <div>
         <h2 class="fw-bold mb-1">
            Products
         </h2>
         <small class="text-muted">
         Manage LPG products
         </small>
      </div>
      <a href="{{ route('products.create') }}" class="btn btn-primary">
      <i class="bi bi-plus-circle me-2"></i>
      Add Product
      </a>
   </div>

   <div class="card shadow-sm">
      <div class="card-body">
         <form method="GET" action="{{ route('products.index') }}">
            <div class="row g-3 mb-4">
               <div class="col-md-5">
                  <input
                     type="text"
                     name="search"
                     class="form-control"
                     placeholder="Write product name..."
                     value="{{ request('search') }}">
               </div>
               <div class="col-md-3">
                  <select
                     name="status"
                     class="form-select">
                     <option value="">All Status</option>
                     <option value="active"
                     {{ request('status')=='active' ? 'selected' : '' }}>
                     Active
                     </option>
                     <option value="inactive"
                     {{ request('status')=='inactive' ? 'selected' : '' }}>
                     Inactive
                     </option>
                  </select>
               </div>
               <div class="col-md-2">
                  <button class="btn btn-primary w-100">
                  Search
                  </button>
               </div>
               <div class="col-md-2">
                  <a href="{{ route('products.index') }}"
                     class="btn btn-secondary w-100">
                  Reset
                  </a>
               </div>
            </div>
         </form>
         <div class="table-responsive">
            <table class="table table-hover align-middle">
               <thead>
                  <tr>
                     <th>ID</th>
                     <th>Name</th>
                     <th>Code</th>
                     <th>Gas Type</th>
                     <th>Unit</th>
                     <th>Purchase</th>
                     <th>Sale</th>
                     <th>Stock</th>
                     <th>Status</th>
                     <th width="140">Actions</th>
                  </tr>
               </thead>
               <tbody>
                  @forelse($products as $product)
                  <tr>
                     <td>{{ $product->id }}</td>
                     <td>{{ $product->name }}</td>
                     <td>{{ $product->code }}</td>
                     <td>{{ $product->gas_type }}</td>
                     <td>{{ $product->unit }}</td>
                     <td>{{ number_format($product->purchase_price,2) }}AMD</td>
                     <td>{{ number_format($product->sale_price,2) }} AMD</td>
                     <td>@if($product->stock <= 10)

                         <span class="badge bg-danger">
                             {{ $product->stock }}
                         </span>

                     @elseif($product->stock <= 30)

                         <span class="badge bg-warning text-dark">
                             {{ $product->stock }}
                         </span>

                     @else

                         <span class="badge bg-success">
                             {{ $product->stock }}
                         </span>

                     @endif</td>
                     <td>
                        @if($product->status=='active')
                        <span class="badge bg-success">
                        Active
                        </span>
                        @else
                        <span class="badge bg-danger">
                        Inactive
                        </span>
                        @endif
                     </td>
                     <td>
                        <a
                           href="{{ route('products.edit',$product) }}"
                           class="btn btn-warning btn-sm">
                        <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('products.destroy',$product) }}"
                           method="POST"
                           class="d-inline delete-form">
                           @csrf
                           @method('DELETE')
                           <button
                              type="submit"
                              class="btn btn-danger btn-sm">
                           <i class="bi bi-trash"></i>
                           </button>
                        </form>
                     </td>
                  </tr>
                  @empty
                  <tr>
                     <td colspan="10" class="text-center py-4">
                        No products found.
                     </td>
                  </tr>
                  @endforelse
               </tbody>
            </table>
         </div>
         <div class="mt-3">
            {{ $products->links() }}
         </div>
      </div>
   </div>
</div>
@push('scripts')

<script>

document.querySelectorAll('.delete-form').forEach(form=>{

    form.addEventListener('submit',function(e){

        e.preventDefault();

        Swal.fire({

            title:'Delete Product?',

            text:'This action cannot be undone.',

            icon:'warning',

            showCancelButton:true,

            confirmButtonColor:'#dc3545',

            cancelButtonColor:'#6c757d',

            confirmButtonText:'Delete'

        }).then((result)=>{

            if(result.isConfirmed){

                form.submit();

            }

        });

    });

});

</script>

@endpush
@endsection