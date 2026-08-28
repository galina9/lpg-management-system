@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <h2 class="mb-4">
        {{ __('messages.edit_user') }}
    </h2>

    <div class="card">

        <div class="card-body">

            <form action="{{ route('users.update',$user) }}" method="POST">

                @csrf
                @method('PUT')

                @include('users._form')

                <button class="btn btn-primary">
                    {{ __('messages.update_user') }}
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