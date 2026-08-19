@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">{{ __('messages.edit_customer') }}</h2>
            <small class="text-muted">{{ __('messages.update_customer_information') }}</small>
        </div>

        <a href="{{ route('customers.index') }}" class="btn btn-secondary">
            {{ __('messages.back') }}
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
                       {{ __('messages.update_customer') }}
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>

@endsection