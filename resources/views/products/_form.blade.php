<div class="row">
   <div class="col-md-6 mb-3">
      <label class="form-label">{{ __('messages.product_name') }} *</label>
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
      <label class="form-label">{{ __('messages.gas_type') }}*</label>
      <select name="gas_type"
         class="form-select @error('gas_type') is-invalid @enderror">
         <option value="">{{ __('messages.select') }}</option>
         @foreach([
         'LPG' => __('messages.lpg'),
         'Propane' => __('messages.propane'),
         'Butane' => __('messages.butane'),
         ] as $value => $label)
         <option
         value="{{ $value }}"
         {{ old('gas_type', $product->gas_type ?? '') == $value ? 'selected' : '' }}>
         {{ $label }}
         </option>
         @endforeach
      </select>
      @error('gas_type')
      <div class="invalid-feedback">{{ $message }}</div>
      @enderror
   </div>
   <div class="col-md-6 mb-3">
      <label class="form-label">{{ __('messages.unit') }} *</label>
      <select name="unit"
         class="form-select">
      @foreach([
      'Liter' => __('messages.liter'),
      'Kg' => __('messages.kg')
      ] as $value => $label)
      <option value="{{ $value }}"
      {{ old('unit', $product->unit ??  'Liter') == $value ? 'selected' : '' }}>
      {{ $label }}
      </option>
      @endforeach
      </select>
   </div>
   <div class="col-md-4 mb-3">
      <label class="form-label"> {{ __('messages.purchase_price') }} *</label>
      <input type="number"
         step="0.01"
         name="purchase_price"
         class="form-control"
         value="{{ old('purchase_price', $product->purchase_price ?? '') }}">
   </div>
   <div class="col-md-4 mb-3">
      <label class="form-label">  {{ __('messages.sale_price') }} *</label>
      <input type="number"
         step="0.01"
         name="sale_price"
         class="form-control"
         value="{{ old('sale_price', $product->sale_price ?? '') }}">
   </div>
   <div class="col-md-4 mb-3">
      <label class="form-label">  {{ __('messages.stock') }} *</label>
      <input type="number"
         name="stock"
         class="form-control"
         value="{{ old('stock', $product->stock ?? 0) }}">
   </div>
   <div class="col-md-6 mb-3">
      <label class="form-label">{{ __('messages.status') }} *</label>
      <select name="status"
         class="form-select">
      <option value="active"
      {{ old('status', $product->status ?? 'active') == 'active' ? 'selected' : '' }}>
      {{ __('messages.active') }}
      </option>
      <option value="inactive"
      {{ old('status', $product->status ?? 'active') == 'inactive' ? 'selected' : '' }}>
      {{ __('messages.inactive') }}
      </option>
      </select>
   </div>
   <div class="col-12 mb-3">
      <label class="form-label">{{ __('messages.description') }}</label>
      <textarea
         name="description"
         rows="4"
         class="form-control">{{ old('description', $product->description ?? '') }}</textarea>
   </div>
</div>