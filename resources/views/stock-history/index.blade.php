@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold">
                {{ __('messages.stock_history') }}
            </h2>

            <small class="text-muted">
                {{ __('messages.product_stock_movements') }}
            </small>

        </div>

    </div>

    <div class="card shadow-sm">

        <div class="card-body">

            <div class="table-responsive">

                <form method="GET">

                    <div class="row mb-4 align-items-end">

                        <div class="col-md-3">

                            <label class="form-label">
                                {{ __('messages.product') }}
                            </label>

                            <input
                                type="text"
                                name="product"
                                class="form-control"
                                placeholder="{{ __('messages.search_product') }}"
                                value="{{ request('product') }}">

                        </div>

                        <div class="col-md-2">

                            <label class="form-label">
                                {{ __('messages.type') }}
                            </label>

                            <select
                                name="type"
                                class="form-select">

                                <option value="">
                                    {{ __('messages.all') }}
                                </option>

                                <option value="IN"
                                    {{ request('type') == 'IN' ? 'selected' : '' }}>
                                    {{ __('messages.in') }}
                                </option>

                                <option value="OUT"
                                    {{ request('type') == 'OUT' ? 'selected' : '' }}>
                                    {{ __('messages.out') }}
                                </option>

                            </select>

                        </div>

                        <div class="col-md-2">

                            <label class="form-label">
                                {{ __('messages.from') }}
                            </label>

                            <input
                                type="date"
                                name="from"
                                class="form-control"
                                value="{{ request('from') }}">

                        </div>

                        <div class="col-md-2">

                            <label class="form-label">
                                {{ __('messages.to') }}
                            </label>

                            <input
                                type="date"
                                name="to"
                                class="form-control"
                                value="{{ request('to') }}">

                        </div>

                        <div class="col-md-1">

                            <button class="btn btn-primary w-100">

                                {{ __('messages.search') }}

                            </button>

                        </div>

                        <div class="col-md-1">

                            <a
                                href="{{ route('stock-history.index') }}"
                                class="btn btn-secondary w-100">

                                {{ __('messages.reset') }}

                            </a>

                        </div>

                        <div class="col-md-1 d-flex gap-2">

                            <a
                                href="{{ route('stock-history.excel') }}"
                                class="btn btn-success"
                                title="{{ __('messages.export_excel') }}">

                                <i class="bi bi-file-earmark-excel"></i>

                            </a>

                            <a
                                href="{{ route('stock-history.pdf') }}"
                                class="btn btn-danger"
                                title="{{ __('messages.export_pdf') }}">

                                <i class="bi bi-file-earmark-pdf"></i>

                            </a>

                        </div>

                    </div>

                </form>

                <table class="table table-hover">

                    <thead>

                        <tr>

                            <th>{{ __('messages.date') }}</th>

                            <th>{{ __('messages.product') }}</th>

                            <th>{{ __('messages.type') }}</th>

                            <th>{{ __('messages.quantity') }}</th>

                            <th>{{ __('messages.before') }}</th>

                            <th>{{ __('messages.after') }}</th>

                            <th>{{ __('messages.user') }}</th>

                            <th>{{ __('messages.note') }}</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($histories as $history)

                            <tr>

                                <td>
                                    {{ $history->created_at }}
                                </td>

                                <td>
                                    {{ $history->product?->name }}
                                </td>

                                <td>

                                    @if($history->type=='IN')

                                        <span class="badge bg-success">
                                            {{ __('messages.in') }}
                                        </span>

                                    @else

                                        <span class="badge bg-danger">
                                            {{ __('messages.out') }}
                                        </span>

                                    @endif

                                </td>

                                <td>
                                    {{ $history->quantity }}
                                </td>

                                <td>
                                    {{ $history->stock_before }}
                                </td>

                                <td>
                                    {{ $history->stock_after }}
                                </td>

                                <td>
                                    {{ $history->user?->name }}
                                </td>

                                <td>
                                    {{ $history->note }}
                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="8" class="text-center">

                                    {{ __('messages.no_history_found') }}

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            {{ $histories->links() }}

        </div>

    </div>

</div>

@endsection