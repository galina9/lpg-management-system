@extends('layouts.app')
@section('content')
<div class="container-fluid">
   <div class="d-flex justify-content-between align-items-center mb-4">
      <div>
         <h2 class="fw-bold mb-1">
            {{ __('messages.edit_product') }}
         </h2>
         <small class="text-muted">
         {{ __('messages.update_product_information') }}
         </small>
      </div>
      <a href="{{ route('products.index') }}" class="btn btn-secondary">
      <i class="bi bi-arrow-left me-2"></i>
      {{ __('messages.back') }}
      </a>
   </div>
   <div class="card shadow-sm">
      <div class="card-body">
         <form action="{{ route('products.update', $product) }}" method="POST">
            @csrf
            @method('PUT')
            @include('products._form')
            <button class="btn btn-primary">
            <i class="bi bi-check-circle me-2"></i>
            {{ __('messages.update_product') }}
            </button>
         </form>
      </div>
   </div>
</div>
@endsection