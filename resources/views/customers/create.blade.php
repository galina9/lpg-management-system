@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <h2 class="mb-4">Add Customer</h2>

    <div class="card">

        <div class="card-body">

            <form action="{{ route('customers.store') }}" method="POST">

                @csrf

                @include('customers._form')

                <button type="submit" class="btn btn-primary">

                    Save Customer

                </button>

                <a href="{{ route('customers.index') }}"
                   class="btn btn-secondary">

                    Cancel

                </a>

            </form>

        </div>

    </div>

</div>

@endsection