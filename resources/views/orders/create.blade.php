@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <h2 class="mb-4">Add Order</h2>

    <div class="card">

        <div class="card-body">

            <form action="{{ route('orders.store') }}" method="POST">

                @csrf

                @include('orders._form')

                <button type="submit" class="btn btn-primary">

                    Save Order

                </button>

                <a href="{{ route('orders.index') }}" class="btn btn-secondary">

                    Cancel

                </a>

            </form>

        </div>

    </div>

</div>

@endsection