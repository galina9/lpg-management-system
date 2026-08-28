<div class="row">

    <div class="col-md-6 mb-3">

        <label class="form-label">
            {{ __('messages.full_name') }} *
        </label>

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

        <label class="form-label">
            {{ __('messages.phone') }} *
        </label>

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

        <label class="form-label">
            {{ __('messages.email') }}
        </label>

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

        <label class="form-label">
            {{ __('messages.status') }}
        </label>

        <select
            name="status"
            class="form-select">

            <option value="active"
                {{ old('status', $customer->status ?? 'active') == 'active' ? 'selected' : '' }}>
                {{ __('messages.active') }}
            </option>

            <option value="inactive"
                {{ old('status', $customer->status ?? '') == 'inactive' ? 'selected' : '' }}>
                {{ __('messages.inactive') }}
            </option>

        </select>

    </div>


    {{-- Region --}}

    <div class="col-md-6 mb-3">

        <label class="form-label">
            {{ __('messages.region') }}
        </label>

        <input
            type="text"
            name="region"
            class="form-control @error('region') is-invalid @enderror"
            value="{{ old('region', $customer->region ?? '') }}"
            placeholder="{{ __('messages.region') }}">

        @error('region')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror

    </div>


    {{-- City --}}

    <div class="col-md-6 mb-3">

        <label class="form-label">
            {{ __('messages.city') }}
        </label>

        <input
            type="text"
            name="city"
            class="form-control @error('city') is-invalid @enderror"
            value="{{ old('city', $customer->city ?? '') }}"
            placeholder="{{ __('messages.city') }}">

        @error('city')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror

    </div>


    {{-- Address --}}

    <div class="col-md-6 mb-3">

        <label class="form-label">
            {{ __('messages.address') }}
        </label>

        <input
            type="text"
            name="address"
            class="form-control @error('address') is-invalid @enderror"
            value="{{ old('address', $customer->address ?? '') }}"
            placeholder="{{ __('messages.address') }}">

        @error('address')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror

    </div>


    {{-- Apartment --}}

    <div class="col-md-6 mb-3">

        <label class="form-label">
            {{ __('messages.apartment') }}
        </label>

        <input
            type="text"
            name="apartment"
            class="form-control @error('apartment') is-invalid @enderror"
            value="{{ old('apartment', $customer->apartment ?? '') }}"
           placeholder="{{ __('messages.apartment') }}">

        @error('apartment')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror

    </div>

</div>