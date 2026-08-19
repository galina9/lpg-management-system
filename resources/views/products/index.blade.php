@extends('layouts.app')
@section('content')
<div class="container-fluid">
   <div class="d-flex justify-content-between align-items-center mb-4">
      <div>
         <h2 class="fw-bold mb-1">
            {{ __('messages.products') }}
         </h2>
         <small class="text-muted">
         {{ __('messages.manage_products') }}         </small>
      </div>
      <a href="{{ route('products.create') }}" class="btn btn-primary">
      <i class="bi bi-plus-circle me-2"></i>
      {{ __('messages.add_product') }}
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
                     placeholder="{{ __('messages.write_product_name') }}"
                     value="{{ request('search') }}">
               </div>
               <div class="col-md-3">
                  <select
                     name="status"
                     class="form-select">
                     <option value="">{{ __('messages.all_status') }}</option>
                     <option value="active"
                     {{ request('status')=='active' ? 'selected' : '' }}>
                     {{ __('messages.active') }}
                     </option>
                     <option value="inactive"
                     {{ request('status')=='inactive' ? 'selected' : '' }}>
                     {{ __('messages.inactive') }}
                     </option>
                  </select>
               </div>
               <div class="col-md-2">
                  <button class="btn btn-primary w-100">
                  {{ __('messages.search') }}
                  </button>
               </div>
               <div class="col-md-2">
                  <a href="{{ route('products.index') }}"
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
                     <th>ID</th>
                     <th>{{ __('messages.product_name') }}</th>
                     <th>{{ __('messages.code') }}</th>
                     <th>{{ __('messages.gas_type') }}</th>
                     <th>{{ __('messages.unit') }}</th>
                     <th>{{ __('messages.purchase') }}</th>
                     <th>{{ __('messages.sale') }}</th>
                     <th>{{ __('messages.stock') }}</th>
                     <th>{{ __('messages.status') }}</th>
                     <th width="140">{{ __('messages.actions') }}</th>
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
                     <td>{{ number_format($product->purchase_price,2) }} AMD</td>
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
                        @endif
                     </td>
                     <td>
                        @if($product->status=='active')
                        <span class="badge bg-success">
                        {{ __('messages.active') }}
                        </span>
                        @else
                        <span class="badge bg-danger">
                        {{ __('messages.inactive') }}
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
   
              title:"{{ __('messages.delete_product') }}",
   
              text:"{{ __('messages.delete_warning') }}",
   
               icon:'warning',
   
               showCancelButton:true,
   
               confirmButtonColor:'#dc3545',
   
               cancelButtonColor:'#6c757d',
   
              confirmButtonText:"{{ __('messages.delete') }}"
   
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