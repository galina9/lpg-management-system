
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>LPG ERP</title>

    @vite(['resources/js/app.js'])
</head>

<body>

    @include('components.navbar')

    <div class="layout-wrapper">

        @include('components.sidebar')

        <main id="main-content">

            <div class="page-wrapper">

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        {{ session('success') }}

                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="alert">
                        </button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show">
                        {{ session('error') }}

                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="alert">
                        </button>
                    </div>
                @endif

                @yield('content')

            </div>

        </main>

    </div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</body>

</html>