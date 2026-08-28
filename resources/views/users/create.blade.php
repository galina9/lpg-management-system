@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <h2 class="mb-4">
        {{ __('messages.add_user') }}
    </h2>

    <div class="card">

        <div class="card-body">

            <form action="{{ route('users.store') }}" method="POST">

                @csrf

                @include('users._form')

                <button class="btn btn-primary">

                    {{ __('messages.save_user') }}

                </button>

                <a href="{{ route('users.index') }}"
                   class="btn btn-secondary">

                    {{ __('messages.cancel') }}

                </a>

            </form>

        </div>

    </div>

</div>

@endsection