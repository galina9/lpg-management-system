<div class="row">

    <div class="col-md-6 mb-3">

        <label class="form-label">Full Name *</label>

        <input
            type="text"
            name="full_name"
            class="form-control @error('full_name') is-invalid @enderror"
            value="{{ old('full_name', $customer->full_name ?? '') }}">

        @error('full_name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror

    </div>

    <div class="col-md-6 mb-3">

        <label class="form-label">Phone *</label>

        <input
            type="text"
            name="phone"
            class="form-control @error('phone') is-invalid @enderror"
            value="{{ old('phone', $customer->phone ?? '') }}">

        @error('phone')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror

    </div>

    <div class="col-md-6 mb-3">

        <label class="form-label">Email</label>

        <input
            type="email"
            name="email"
            class="form-control @error('email') is-invalid @enderror"
            value="{{ old('email', $customer->email ?? '') }}">

        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror

    </div>

    <div class="col-md-6 mb-3">

        <label class="form-label">Status</label>

        <select
            name="status"
            class="form-select">

            <option value="active"
                {{ old('status', $customer->status ?? 'active') == 'active' ? 'selected' : '' }}>
                Active
            </option>

            <option value="inactive"
                {{ old('status', $customer->status ?? '') == 'inactive' ? 'selected' : '' }}>
                Inactive
            </option>

        </select>

    </div>

    <div class="col-12 mb-3">

        <label class="form-label">Address</label>

        <textarea
            name="address"
            rows="3"
            class="form-control">{{ old('address', $customer->address ?? '') }}</textarea>

    </div>

</div>