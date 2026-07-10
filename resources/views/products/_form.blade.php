<div class="row">

    <div class="col-md-6 mb-3">
        <label class="form-label">Product Name *</label>
        <input type="text"
               name="name"
               class="form-control @error('name') is-invalid @enderror"
               value="{{ old('name', $product->name ?? '') }}">

        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Product Code *</label>
        <input type="text"
               name="code"
               class="form-control @error('code') is-invalid @enderror"
               value="{{ old('code', $product->code ?? '') }}">

        @error('code')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Gas Type *</label>

        <select name="gas_type"
                class="form-select @error('gas_type') is-invalid @enderror">

            <option value="">Select...</option>

            @foreach(['LPG','Propane','Butane'] as $gas)

                <option value="{{ $gas }}"
                    {{ old('gas_type', $product->gas_type ?? '') == $gas ? 'selected' : '' }}>
                    {{ $gas }}
                </option>

            @endforeach

        </select>

        @error('gas_type')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">

        <label class="form-label">Unit *</label>

        <select name="unit"
                class="form-select">

            @foreach(['Liter','Kg'] as $unit)

                <option value="{{ $unit }}"
                    {{ old('unit', $product->unit ?? 'Liter') == $unit ? 'selected' : '' }}>
                    {{ $unit }}
                </option>

            @endforeach

        </select>

    </div>

    <div class="col-md-4 mb-3">

        <label class="form-label">Purchase Price *</label>

        <input type="number"
               step="0.01"
               name="purchase_price"
               class="form-control"
               value="{{ old('purchase_price', $product->purchase_price ?? '') }}">

    </div>

    <div class="col-md-4 mb-3">

        <label class="form-label">Sale Price *</label>

        <input type="number"
               step="0.01"
               name="sale_price"
               class="form-control"
               value="{{ old('sale_price', $product->sale_price ?? '') }}">

    </div>

    <div class="col-md-4 mb-3">

        <label class="form-label">Stock *</label>

        <input type="number"
               name="stock"
               class="form-control"
               value="{{ old('stock', $product->stock ?? 0) }}">

    </div>

    <div class="col-md-6 mb-3">

        <label class="form-label">Status *</label>

        <select name="status"
                class="form-select">

            <option value="active"
                {{ old('status', $product->status ?? 'active') == 'active' ? 'selected' : '' }}>
                Active
            </option>

            <option value="inactive"
                {{ old('status', $product->status ?? 'active') == 'inactive' ? 'selected' : '' }}>
                Inactive
            </option>

        </select>

    </div>

    <div class="col-12 mb-3">

        <label class="form-label">Description</label>

        <textarea
            name="description"
            rows="4"
            class="form-control">{{ old('description', $product->description ?? '') }}</textarea>

    </div>

</div>