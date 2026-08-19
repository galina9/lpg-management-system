@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <h2 class="mb-4">
    {{ __('messages.add_customer') }}
</h2>

    <div class="card">

        <div class="card-body">

            <form action="{{ route('customers.store') }}" method="POST">

                @csrf

                @include('customers._form')

                <button type="submit" class="btn btn-primary">

                   {{ __('messages.save_customer') }}

                </button>

                <a href="{{ route('customers.index') }}"
                   class="btn btn-secondary">

                    {{ __('messages.cancel') }}

                </a>

            </form>

        </div>

    </div>

</div>

@endsection