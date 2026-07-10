@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Edit Customer</h2>
            <small class="text-muted">Update customer information</small>
        </div>

        <a href="{{ route('customers.index') }}" class="btn btn-secondary">
            Back
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">

            <form action="{{ route('customers.update', $customer) }}" method="POST">

                @csrf
                @method('PUT')

                @include('customers._form')

                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">
                        Update Customer
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>

@endsection