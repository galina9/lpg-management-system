<div class="row">

    <div class="col-md-6 mb-3">

        <label class="form-label">Order *</label>

        <select
            name="order_id"
            class="form-select @error('order_id') is-invalid @enderror">

            <option value="">Select Order</option>

            @foreach($orders as $order)

                <option
                    value="{{ $order->id }}"
                    {{ old('order_id', $payment->order_id ?? $selectedOrder->id ?? '') == $order->id ? 'selected' : '' }}>

                    {{ $order->order_number }}
                    -
                    {{ $order->customer?->full_name }}

                </option>

            @endforeach

        </select>

        @error('order_id')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror

    </div>

    <div class="col-md-6 mb-3">

        <label class="form-label">Amount *</label>

        <input
            type="number"
            step="0.01"
            name="amount"
            class="form-control @error('amount') is-invalid @enderror"
            value="{{ old('amount', $payment->amount ?? '') }}">

        @error('amount')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror

    </div>

    <div class="col-md-6 mb-3">

        <label class="form-label">Payment Method *</label>

        <select
            name="method"
            class="form-select @error('method') is-invalid @enderror">

            @foreach(['Cash','Card','Bank Transfer'] as $method)

                <option
                    value="{{ $method }}"
                    {{ old('method', $payment->method ?? '') == $method ? 'selected' : '' }}>

                    {{ $method }}

                </option>

            @endforeach

        </select>

    </div>

    <div class="col-md-6 mb-3">

        <label class="form-label">Status *</label>

        <select
            name="status"
            class="form-select @error('status') is-invalid @enderror">

            @foreach(['Paid','Partial','Unpaid'] as $status)

                <option
                    value="{{ $status }}"
                    {{ old('status', $payment->status ?? '') == $status ? 'selected' : '' }}>

                    {{ $status }}

                </option>

            @endforeach

        </select>

    </div>

    <div class="col-md-6 mb-3">

        <label class="form-label">Payment Date *</label>

        <input
            type="date"
            name="payment_date"
            class="form-control @error('payment_date') is-invalid @enderror"
            value="{{ old('payment_date', $payment->payment_date ?? now()->toDateString()) }}">

    </div>

    <div class="col-md-12 mb-3">

        <label class="form-label">Note</label>

        <textarea
            name="note"
            rows="3"
            class="form-control">{{ old('note', $payment->note ?? '') }}</textarea>

    </div>

</div>