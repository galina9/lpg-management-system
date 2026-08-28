@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="fw-bold mb-1">
                {{ __('messages.users') }}
            </h2>

            <small class="text-muted">
                {{ __('messages.manage_system_users') }}
            </small>
        </div>

        <a href="{{ route('users.create') }}" class="btn btn-primary">

            <i class="bi bi-plus-circle me-2"></i>

            {{ __('messages.add_user') }}

        </a>

    </div>

    @if(session('success'))

        <div class="alert alert-success">
            {{ session('success') }}
        </div>

    @endif

    <div class="card">

        <div class="card-body">

            <form method="GET" class="row mb-4">

                <div class="col-md-6">

                    <input
                        type="text"
                        name="search"
                        class="form-control"
                        placeholder="{{ __('messages.search_user') }}"
                        value="{{ request('search') }}">

                </div>

                <div class="col-md-2">

                    <button class="btn btn-primary w-100">
                        {{ __('messages.search') }}
                    </button>

                </div>

                <div class="col-md-2">

                    <a href="{{ route('users.index') }}"
                       class="btn btn-secondary w-100">

                        {{ __('messages.reset') }}

                    </a>

                </div>

            </form>

            <div class="table-responsive">

                <table class="table table-hover">

                    <thead>

                        <tr>

                            <th>ID</th>

                            <th>{{ __('messages.name') }}</th>

                            <th>{{ __('messages.email') }}</th>

                            <th>{{ __('messages.role') }}</th>

                            <th>{{ __('messages.status') }}</th>

                            <th width="150">
                                {{ __('messages.actions') }}
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                    @forelse($users as $user)

                        <tr>

                            <td>{{ $user->id }}</td>

                            <td>{{ $user->name }}</td>

                            <td>{{ $user->email }}</td>

                            <td>

                                @switch($user->role)

                                    @case('director')

                                        <span class="badge bg-danger">
                                            {{ __('messages.executive_director') }}
                                        </span>

                                        @break

                                    @case('manager')

                                        <span class="badge bg-primary">
                                            {{ __('messages.manager') }}
                                        </span>

                                        @break

                                    @default

                                        <span class="badge bg-success">
                                            {{ __('messages.driver') }}
                                        </span>

                                @endswitch

                            </td>

                            <td>

                                @if($user->status)

                                    <span class="badge bg-success">
                                        {{ __('messages.active') }}
                                    </span>

                                @else

                                    <span class="badge bg-secondary">
                                        {{ __('messages.inactive') }}
                                    </span>

                                @endif

                            </td>

                            <td>

                                <a href="{{ route('users.edit',$user) }}"
                                   class="btn btn-warning btn-sm">

                                    <i class="bi bi-pencil"></i>

                                </a>

                                <form
                                    action="{{ route('users.destroy',$user) }}"
                                    method="POST"
                                    class="d-inline">

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('{{ __('messages.delete_user_confirm') }}')">

                                        <i class="bi bi-trash"></i>

                                    </button>

                                </form>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="6" class="text-center">

                                {{ __('messages.no_users_found') }}

                            </td>

                        </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>

            {{ $users->links() }}

        </div>

    </div>

</div>

@endsection