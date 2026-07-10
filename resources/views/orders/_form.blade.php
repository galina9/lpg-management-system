<div class="row">

    <div class="col-md-6 mb-3">

        <label class="form-label">Product *</label>

        <select name="product_id"
                class="form-select @error('product_id') is-invalid @enderror">

            <option value="">Select Product</option>

            @foreach($products as $product)

                <option value="{{ $product->id }}"
                    {{ old('product_id', $order->product_id ?? '') == $product->id ? 'selected' : '' }}>

                    {{ $product->name }}

                </option>

            @endforeach

        </select>

        @error('product_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror

    </div>

    <div class="col-md-6 mb-3">

        <label class="form-label">Customer Name *</label>

        <input
            type="text"
            name="customer_name"
            class="form-control @error('customer_name') is-invalid @enderror"
            value="{{ old('customer_name', $order->customer_name ?? '') }}">

        @error('customer_name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror

    </div>

    <div class="col-md-6 mb-3">

        <label class="form-label">Customer Phone *</label>

        <input
            type="text"
            name="customer_phone"
            class="form-control @error('customer_phone') is-invalid @enderror"
            value="{{ old('customer_phone', $order->customer_phone ?? '') }}">

        @error('customer_phone')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror

    </div>

    <div class="col-md-3 mb-3">

        <label class="form-label">Quantity *</label>

        <input
            type="number"
            step="0.01"
            name="quantity"
            class="form-control @error('quantity') is-invalid @enderror"
            value="{{ old('quantity', $order->quantity ?? 1) }}">

        @error('quantity')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror

    </div>

    <div class="col-md-3 mb-3">

        <label class="form-label">Order Date *</label>

        <input
            type="date"
            name="order_date"
            class="form-control @error('order_date') is-invalid @enderror"
            value="{{ old('order_date', isset($order) ? $order->order_date : now()->toDateString()) }}">

        @error('order_date')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror

    </div>

    <div class="col-md-6 mb-3">

        <label class="form-label">Status *</label>

        <select
            name="status"
            class="form-select">

            <option value="Pending"
                {{ old('status', $order->status ?? 'Pending') == 'Pending' ? 'selected' : '' }}>
                Pending
            </option>

            <option value="Completed"
                {{ old('status', $order->status ?? '') == 'Completed' ? 'selected' : '' }}>
                Completed
            </option>

            <option value="Cancelled"
                {{ old('status', $order->status ?? '') == 'Cancelled' ? 'selected' : '' }}>
                Cancelled
            </option>

        </select>

    </div>

</div>