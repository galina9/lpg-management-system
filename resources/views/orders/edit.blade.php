@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <h2 class="mb-4">Edit Order</h2>

    <div class="card">

        <div class="card-body">

            <form action="{{ route('orders.update', $order) }}" method="POST">

                @csrf
                @method('PUT')

                @include('orders._form')

                <button type="submit" class="btn btn-primary">

                    Update Order

                </button>

                <a href="{{ route('orders.index') }}" class="btn btn-secondary">

                    Cancel

                </a>

            </form>

        </div>

    </div>

</div>

@endsection