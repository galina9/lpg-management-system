@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <h2 class="mb-4">
    {{ __('messages.add_order') }}
</h2>

    <div class="card">

        <div class="card-body">

            <form action="{{ route('orders.store') }}" method="POST">

                @csrf

                @include('orders._form')

                <button type="submit" class="btn btn-primary">

                   {{ __('messages.save_order') }}

                </button>

                <a href="{{ route('orders.index') }}" class="btn btn-secondary">

                    {{ __('messages.cancel') }}

                </a>

            </form>

        </div>

    </div>

</div>

@endsection