@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <h2 class="mb-4">Add User</h2>

    <div class="card">

        <div class="card-body">

            <form action="{{ route('users.store') }}" method="POST">

                @csrf

                @include('users._form')

                <button class="btn btn-primary">

                    Save User

                </button>

                <a href="{{ route('users.index') }}"
                   class="btn btn-secondary">

                    Cancel

                </a>

            </form>

        </div>

    </div>

</div>

@endsection