@php
    $order = $order ?? null;
@endphp

<div class="row">

    {{-- Product --}}
    <div class="col-md-6 mb-3">

        <label class="form-label">
            {{ __('messages.product') }} *
        </label>

        <select
            name="product_id"
            class="form-select @error('product_id') is-invalid @enderror">

            @foreach($products as $product)

                <option
                    value="{{ $product->id }}"
                    data-stock="{{ $product->stock }}"
                    {{ old('product_id', $order?->product_id ?? '') == $product->id ? 'selected' : '' }}>

                    {{ $product->name }}

                </option>

            @endforeach

        </select>

        @error('product_id')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror

    </div>


    {{-- Driver --}}
    <div class="col-md-6 mb-3">

        <label class="form-label">
            {{ __('messages.driver') }}
        </label>

        <select
            name="driver_id"
            class="form-select @error('driver_id') is-invalid @enderror">

            <option value="">
                {{ __('messages.driver') }}
            </option>

            @foreach($drivers as $driver)

                <option
                    value="{{ $driver->id }}"
                    {{ old('driver_id', $order?->driver_id ?? '') == $driver->id ? 'selected' : '' }}>

                    {{ $driver->name }}

                </option>

            @endforeach

        </select>

        @error('driver_id')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror

    </div>


    {{-- Customer --}}
    <div class="col-md-6 mb-3">

        <label class="form-label">
            {{ __('messages.customer') }} *
        </label>

        <select
            name="customer_id"
            class="form-select @error('customer_id') is-invalid @enderror">

            <option value="">
                {{ __('messages.customer') }} *
            </option>

            @foreach($customers as $customer)

                <option
                    value="{{ $customer->id }}"
                    {{ old('customer_id', $order?->customer_id ?? '') == $customer->id ? 'selected' : '' }}>

                    {{ $customer->full_name }}
                    ({{ $customer->phone }})

                </option>

            @endforeach

        </select>

        @error('customer_id')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror

    </div>


    {{-- Quantity --}}
    <div class="col-md-3 mb-3">

        <label class="form-label">
            {{ __('messages.quantity') }} *
        </label>

        <input
            type="number"
            step="0.01"
            name="quantity"
            id="quantity"
            class="form-control @error('quantity') is-invalid @enderror"
            value="{{ old('quantity', $order?->quantity ?? 1) }}">

        @error('quantity')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror

    </div>


    {{-- Available Stock --}}
    <div class="col-md-3 mb-3">

        <label class="form-label">
            {{ __('messages.available_stock') }}
        </label>

        <input
            id="available_stock"
            class="form-control"
            readonly>

    </div>


    {{-- Unit Price --}}
    <div class="col-md-3 mb-3">

        <label class="form-label">
            {{ __('messages.unit_price') }}
        </label>

        <input
            type="number"
            step="0.01"
            name="unit_price"
            id="unit_price"
            class="form-control @error('unit_price') is-invalid @enderror"
            value="{{ old('unit_price', $order?->unit_price ?? '') }}">

        @error('unit_price')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror

    </div>


    {{-- Total Price --}}
    <div class="col-md-3 mb-3">

        <label class="form-label">
            {{ __('messages.total_price') }}
        </label>

        <input
            type="number"
            step="0.01"
            name="total_price"
            id="total_price"
            class="form-control"
            value="{{ old('total_price', $order?->total_price ?? '') }}"
            readonly>

    </div>


    {{-- Order Date --}}
    <div class="col-md-3 mb-3">

        <label class="form-label">
            {{ __('messages.order_date') }} *
        </label>

        <input
            type="date"
            name="order_date"
            class="form-control @error('order_date') is-invalid @enderror"
            value="{{ old('order_date', $order?->order_date ?? now()->toDateString()) }}">

        @error('order_date')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror

    </div>


    {{-- Status --}}
    <div class="col-md-6 mb-3">

        <label class="form-label">
            {{ __('messages.status') }} *
        </label>

        <select name="status" class="form-select">

            <option value="Pending"
                {{ old('status', $order?->status ?? 'Pending') === 'Pending' ? 'selected' : '' }}>
                {{ __('messages.pending') }}
            </option>

            <option value="Assigned"
                {{ old('status', $order?->status ?? '') === 'Assigned' ? 'selected' : '' }}>
                {{ __('messages.assigned') }}
            </option>

            <option value="On Delivery"
                {{ old('status', $order?->status ?? '') === 'On Delivery' ? 'selected' : '' }}>
                {{ __('messages.on_delivery') }}
            </option>

            <option value="Delivered"
                {{ old('status', $order?->status ?? '') === 'Delivered' ? 'selected' : '' }}>
                {{ __('messages.delivered') }}
            </option>

            <option value="Cancelled"
                {{ old('status', $order?->status ?? '') === 'Cancelled' ? 'selected' : '' }}>
                {{ __('messages.cancelled') }}
            </option>

        </select>

        @error('status')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror

    </div>

</div>


<script>

const product = document.querySelector('select[name="product_id"]');
const qty = document.querySelector('input[name="quantity"]');
const stock = document.getElementById('available_stock');
const price = document.getElementById('unit_price');
const total = document.getElementById('total_price');


function calculate() {

    const option = product.options[product.selectedIndex];

    if (!option) {
        stock.value = '';
        total.value = '';
        return;
    }

    const available = parseFloat(option.dataset.stock || 0);
    const quantity = parseFloat(qty.value || 0);
    const unit = parseFloat(price.value || 0);

    stock.value = available;

    if (!isNaN(unit) && !isNaN(quantity)) {

        total.value = (unit * quantity).toFixed(2);

    } else {

        total.value = '';

    }
}


product.addEventListener('change', calculate);

qty.addEventListener('input', calculate);

price.addEventListener('input', calculate);


calculate();

</script>