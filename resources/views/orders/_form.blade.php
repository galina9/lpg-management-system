<div class="row">

    <div class="col-md-6 mb-3">

        <label class="form-label">Product *</label>

        <select name="product_id"
                class="form-select @error('product_id') is-invalid @enderror">

            @foreach($products as $product)

<option
    value="{{ $product->id }}"
    data-price="{{ $product->sale_price }}"
    data-stock="{{ $product->stock }}"
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

    <label class="form-label">
        Driver
    </label>

    <select
        name="driver_id"
        class="form-select @error('driver_id') is-invalid @enderror">

        <option value="">
            Select Driver
        </option>

        @foreach($drivers as $driver)

            <option
                value="{{ $driver->id }}"
                {{ old('driver_id', $order->driver_id ?? '') == $driver->id ? 'selected' : '' }}>

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

    <label class="form-label">
        Available Stock
    </label>

    <input
        id="available_stock"
        class="form-control"
        readonly>

</div>
        <div class="col-md-3 mb-3">

        <label class="form-label">
            Unit Price
        </label>

        <input
            id="unit_price"
            class="form-control"
            readonly>

    </div>

    <div class="col-md-3 mb-3">

        <label class="form-label">
            Total Price
        </label>

        <input
            id="total_price"
            class="form-control"
            readonly>

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

            <option value="Pending">Pending</option>
            <option value="Assigned">Assigned</option>
            <option value="On Delivery">On Delivery</option>
            <option value="Delivered">Delivered</option>
            <option value="Cancelled">Cancelled</option>

        </select>

    </div>

</div>

<script>

const stock = document.getElementById('available_stock');

function calculate(){

    const option = product.options[product.selectedIndex];

    const unit = parseFloat(option.dataset.price || 0);

    const available = parseFloat(option.dataset.stock || 0);

    const quantity = parseFloat(qty.value || 0);

    stock.value = available;

    price.value = unit.toFixed(2);

    total.value = (unit * quantity).toFixed(2);

}

</script>