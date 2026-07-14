@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <div class="card shadow-sm">

        <div class="card-header">

            <h4 class="mb-0">

                Add Payment

            </h4>

        </div>

        <div class="card-body">

            <form
                action="{{ route('payments.store') }}"
                method="POST">

                @csrf

                @include('payments._form')

                <button
                    class="btn btn-primary">

                    Save Payment

                </button>

                <a
                    href="{{ route('payments.index') }}"
                    class="btn btn-secondary">

                    Cancel

                </a>

            </form>

        </div>

    </div>

</div>

@endsection