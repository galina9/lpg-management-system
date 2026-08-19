@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold">

                {{ __('messages.payments') }}

            </h2>

            <small class="text-muted">

                {{ __('messages.manage_payments') }}

            </small>

        </div>

        <a
            href="{{ route('payments.create') }}"
            class="btn btn-primary">

            <i class="bi bi-plus-circle"></i>

            {{ __('messages.add_payment') }}

        </a>

    </div>

    <div class="card shadow-sm">

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-hover">

                    <thead>

                        <tr>

                            <th>{{ __('messages.order') }}</th>

                            <th>{{ __('messages.customer') }}</th>

                            <th>{{ __('messages.amount') }}</th>

                            <th>{{ __('messages.method') }}</th>

                            <th>{{ __('messages.status') }}</th>

                            <th>{{ __('messages.date') }}</th>

                            <th>{{ __('messages.actions') }}</th>

                        </tr>

                    </thead>

                    <tbody>

                    @forelse($payments as $payment)

                        <tr>

                            <td>

                                {{ $payment->order?->order_number }}

                            </td>

                            <td>

                                {{ $payment->order?->customer?->full_name }}

                            </td>

                            <td>

                                {{ number_format($payment->amount,0,'.',' ') }} AMD

                            </td>

                            <td>

                                {{ $payment->method }}

                            </td>

                            <td>

                                @if($payment->status=='Paid')

                                    <span class="badge bg-success">

                                        {{ __('messages.paid') }}

                                    </span>

                                @elseif($payment->status=='Partial')

                                    <span class="badge bg-warning text-dark">

                                        {{ __('messages.partial') }}

                                    </span>

                                @else

                                    <span class="badge bg-danger">

                                        {{ __('messages.unpaid') }}

                                    </span>

                                @endif

                            </td>

                            <td>

                                {{ $payment->payment_date }}

                            </td>

                            <td>

                                <a
                                    href="{{ route('payments.edit',$payment) }}"
                                    class="btn btn-warning btn-sm">

                                    <i class="bi bi-pencil"></i>

                                </a>

                                <form
                                    action="{{ route('payments.destroy',$payment) }}"
                                    method="POST"
                                    class="d-inline">

                                    @csrf

                                    @method('DELETE')

                                    <button
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('{{ __('messages.delete_payment') }}')">

                                        <i class="bi bi-trash"></i>

                                    </button>

                                </form>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="7" class="text-center">

                                {{ __('messages.no_payments_found') }}

                            </td>

                        </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>

            {{ $payments->links() }}

        </div>

    </div>

</div>

@endsection