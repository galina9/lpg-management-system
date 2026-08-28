<div class="row">

    <div class="col-md-6 mb-3">

        <label class="form-label">
            {{ __('messages.name') }} *
        </label>

        <input
            type="text"
            name="name"
            class="form-control @error('name') is-invalid @enderror"
            value="{{ old('name', $user->name ?? '') }}">

        @error('name')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror

    </div>


    <div class="col-md-6 mb-3">

        <label class="form-label">
            {{ __('messages.email') }} *
        </label>

        <input
            type="email"
            name="email"
            class="form-control @error('email') is-invalid @enderror"
            value="{{ old('email', $user->email ?? '') }}">

        @error('email')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror

    </div>


    <div class="col-md-6 mb-3">

        <label class="form-label">

            {{ __('messages.password') }}

            @if(isset($user))
                ({{ __('messages.leave_blank_to_keep_current') }})
            @else
                *
            @endif

        </label>

        <input
            type="password"
            name="password"
            class="form-control @error('password') is-invalid @enderror">

        @error('password')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror

    </div>


    <div class="col-md-6 mb-3">

        <label class="form-label">
            {{ __('messages.role') }} *
        </label>

        <select name="role" class="form-select">

            <option value="director"
                {{ old('role', $user->role ?? '') == 'director' ? 'selected' : '' }}>

                {{ __('messages.executive_director') }}

            </option>

            <option value="manager"
                {{ old('role', $user->role ?? '') == 'manager' ? 'selected' : '' }}>

                {{ __('messages.manager') }}

            </option>

            <option value="driver"
                {{ old('role', $user->role ?? 'driver') == 'driver' ? 'selected' : '' }}>

                {{ __('messages.driver') }}

            </option>

        </select>

    </div>


    <div class="col-md-6 mb-3">

        <label class="form-label">
            {{ __('messages.status') }}
        </label>

        <select name="status" class="form-select">

            <option value="1"
                {{ old('status', $user->status ?? 1) == 1 ? 'selected' : '' }}>

                {{ __('messages.active') }}

            </option>

            <option value="0"
                {{ old('status', $user->status ?? 1) == 0 ? 'selected' : '' }}>

                {{ __('messages.inactive') }}

            </option>

        </select>

    </div>

</div>