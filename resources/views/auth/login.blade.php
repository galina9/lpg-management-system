<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Login - LPG ERP</title>

    @vite(['resources/js/app.js'])
</head>
<body class="bg-light">

<div class="container">

    <div class="row justify-content-center align-items-center" style="min-height:100vh;">

        <div class="col-md-5">

            <div class="card shadow">

                <div class="card-body p-4">

                    <h2 class="text-center mb-4">
                        LPG ERP
                    </h2>

                    @if(session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-3">

                            <label class="form-label">
                                Email
                            </label>

                            <input
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                class="form-control @error('email') is-invalid @enderror"
                                required
                                autofocus>

                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                        <div class="mb-3">

                            <label class="form-label">
                                Password
                            </label>

                            <input
                                type="password"
                                name="password"
                                class="form-control @error('password') is-invalid @enderror"
                                required>

                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                        <div class="form-check mb-3">

                            <input
                                class="form-check-input"
                                type="checkbox"
                                name="remember"
                                id="remember">

                            <label
                                class="form-check-label"
                                for="remember">

                                Remember me

                            </label>

                        </div>

                        <div class="d-grid">

                            <button
                                class="btn btn-primary">

                                Login

                            </button>

                        </div>

                        @if(Route::has('password.request'))

                            <div class="text-center mt-3">

                                <a href="{{ route('password.request') }}">
                                    Forgot your password?
                                </a>

                            </div>

                        @endif

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

</body>
</html>