@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold mb-1">
                {{ __('messages.customers') }}
            </h2>

            <small class="text-muted">
                {{ __('messages.manage_customers') }}
            </small>

        </div>

        <a href="{{ route('customers.create') }}" class="btn btn-primary">

            <i class="bi bi-plus-circle me-2"></i>

            {{ __('messages.add_customer') }}

        </a>

    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow-sm">

        <div class="card-body">

            <form method="GET">

                <div class="row mb-4">

                    <div class="col-md-6">

                        <input
                            type="text"
                            name="search"
                            class="form-control"
                            placeholder="{{ __('messages.search_customer') }}"
                            value="{{ request('search') }}">

                    </div>

                    <div class="col-md-2">

                        <button class="btn btn-primary w-100">
                            {{ __('messages.search') }}
                        </button>

                    </div>

                    <div class="col-md-2">

                        <a href="{{ route('customers.index') }}"
                           class="btn btn-secondary w-100">

                            {{ __('messages.reset') }}

                        </a>

                    </div>

                </div>

            </form>

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead>

                        <tr>

                            <th>ID</th>
                            <th>{{ __('messages.full_name') }}</th>
                            <th>{{ __('messages.phone') }}</th>
                            <th>{{ __('messages.email') }}</th>

                            <th>{{ __('messages.region') }}</th>
                            <th>{{ __('messages.city') }}</th>
                            <th>{{ __('messages.address') }}</th>
                            <th>{{ __('messages.apartment') }}</th>

                            <th>{{ __('messages.status') }}</th>

                            <th width="140">{{ __('messages.actions') }}</th>

                        </tr>

                    </thead>

                    <tbody>

                    @forelse($customers as $customer)

                        <tr>

                            <td>{{ $customer->id }}</td>

                            <td>{{ $customer->full_name }}</td>

                            <td>{{ $customer->phone }}</td>

                            <td>{{ $customer->email }}</td>

                            <td>{{ $customer->region ?? '—' }}</td>

                            <td>{{ $customer->city ?? '—' }}</td>

                            <td>{{ $customer->address ?? '—' }}</td>

                            <td>{{ $customer->apartment ?? '—' }}</td>

                            <td>

                                @if($customer->status == 'active')

                                    <span class="badge bg-success">
                                        {{ __('messages.active') }}
                                    </span>

                                @else

                                    <span class="badge bg-danger">
                                        {{ __('messages.inactive') }}
                                    </span>

                                @endif

                            </td>

                            <td>

                                <a href="{{ route('customers.edit',$customer) }}"
                                   class="btn btn-warning btn-sm">

                                    <i class="bi bi-pencil"></i>

                                </a>

                                <form action="{{ route('customers.destroy',$customer) }}"
                                      method="POST"
                                      class="d-inline">

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        onclick="return confirm('{{ __('messages.delete_customer') }}')"
                                        class="btn btn-danger btn-sm">

                                        <i class="bi bi-trash"></i>

                                    </button>

                                </form>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="10"
                                class="text-center py-5">

                                {{ __('messages.no_customers_found') }}

                            </td>

                        </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>

            <div class="mt-3">

                {{ $customers->links() }}

            </div>

        </div>

    </div>

</div>

@endsection