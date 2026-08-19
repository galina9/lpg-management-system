@extends('layouts.app')

@section('content')

<div class="container-fluid">

   <h2 class="mb-4">
    {{ __('messages.edit_order') }}
</h2>

    <div class="card">

        <div class="card-body">

            <form action="{{ route('orders.update', $order) }}" method="POST">

                @csrf
                @method('PUT')

                @include('orders._form')

                <button type="submit" class="btn btn-primary">

                    {{ __('messages.update_order') }}

                </button>

                <a href="{{ route('orders.index') }}" class="btn btn-secondary">

                    {{ __('messages.cancel') }}

                </a>

            </form>

        </div>

    </div>

</div>

@endsection