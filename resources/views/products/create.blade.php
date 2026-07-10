@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold mb-1">
                Add Product
            </h2>

            <small class="text-muted">
                Create a new LPG product
            </small>

        </div>

        <a href="{{ route('products.index') }}" class="btn btn-secondary">

            <i class="bi bi-arrow-left me-2"></i>

            Back

        </a>

    </div>

    <div class="card shadow-sm">

        <div class="card-body">
            <form action="{{ route('products.store') }}" method="POST">

            @csrf

            @include('products._form')

            <button type="submit" class="btn btn-primary">
                Save Product
            </button>

        </form>

        </div>

    </div>

</div>

@endsection