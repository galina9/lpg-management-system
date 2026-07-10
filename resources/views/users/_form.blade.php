<div class="row">

    <div class="col-md-6 mb-3">

        <label class="form-label">Name *</label>

        <input
            type="text"
            name="name"
            class="form-control @error('name') is-invalid @enderror"
            value="{{ old('name', $user->name ?? '') }}">

        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror

    </div>

    <div class="col-md-6 mb-3">

        <label class="form-label">Email *</label>

        <input
            type="email"
            name="email"
            class="form-control @error('email') is-invalid @enderror"
            value="{{ old('email', $user->email ?? '') }}">

        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror

    </div>

    <div class="col-md-6 mb-3">

        <label class="form-label">
            Password {{ isset($user) ? '(leave blank to keep current)' : '*' }}
        </label>

        <input
            type="password"
            name="password"
            class="form-control @error('password') is-invalid @enderror">

        @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror

    </div>

    <div class="col-md-6 mb-3">

        <label class="form-label">Role *</label>

        <select name="role" class="form-select">

            <option value="director"
                {{ old('role', $user->role ?? '') == 'director' ? 'selected' : '' }}>
                Executive Director
            </option>

            <option value="manager"
                {{ old('role', $user->role ?? '') == 'manager' ? 'selected' : '' }}>
                Manager
            </option>

            <option value="driver"
                {{ old('role', $user->role ?? 'driver') == 'driver' ? 'selected' : '' }}>
                Driver
            </option>

        </select>

    </div>

    <div class="col-md-6 mb-3">

        <label class="form-label">Status</label>

        <select name="status" class="form-select">

            <option value="1"
                {{ old('status', $user->status ?? 1) == 1 ? 'selected' : '' }}>
                Active
            </option>

            <option value="0"
                {{ old('status', $user->status ?? 1) == 0 ? 'selected' : '' }}>
                Inactive
            </option>

        </select>

    </div>

</div>