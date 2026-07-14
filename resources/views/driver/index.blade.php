@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <h2 class="mb-4">

        My Deliveries

    </h2>

    <div class="row">

        @forelse($orders as $order)

            <div class="col-md-6">

                <div class="card mb-3">

                    <div class="card-body">

                        <h5>

                            {{ $order->order_number }}

                        </h5>

                        <p>

                            <strong>Customer:</strong>

                            {{ $order->customer?->full_name }}

                        </p>

                        <p>

                            <strong>Phone:</strong>

                            {{ $order->customer?->phone }}

                        </p>

                        <p>

                            <strong>Product:</strong>

                            {{ $order->product?->name }}

                        </p>

                        <p>

                            <strong>Quantity:</strong>

                            {{ $order->quantity }}

                        </p>

                        <p>

                            <strong>Status:</strong>

                            {{ $order->status }}

                        </p>
                        @if($order->status == 'Assigned')

                            <form action="{{ route('driver.orders.start', $order) }}"
                                  method="POST"
                                  class="d-inline">

                                @csrf
                                @method('PATCH')

                                <button class="btn btn-primary btn-sm">

                                    Start Delivery

                                </button>

                            </form>

                            @endif


                            @if($order->status == 'On Delivery')

                            <form action="{{ route('driver.orders.complete', $order) }}"
                                  method="POST"
                                  class="d-inline">

                                @csrf
                                @method('PATCH')

                                <button class="btn btn-success btn-sm">

                                    Mark as Delivered

                                </button>

                            </form>

                        @endif

                    </div>

                </div>

            </div>

        @empty

            <div class="col-12">

                <div class="alert alert-info">

                    No deliveries assigned.

                </div>

            </div>

        @endforelse

    </div>

</div>

@endsection