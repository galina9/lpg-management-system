<!-- <nav class="navbar navbar-expand-lg fixed-top">

    <div class="container-fluid">

        <div class="d-flex align-items-center">

            <button id="sidebarToggle" class="btn btn-light me-3">

                <i class="bi bi-list fs-4"></i>

            </button>

            <a href="{{ route('dashboard') }}"
               class="navbar-brand fw-bold text-primary m-0">

                LPG ERP

            </a>

        </div>

        <div class="d-flex align-items-center gap-3">

            {{-- Language --}}
            <div class="dropdown">

                <button class="btn btn-light dropdown-toggle"
                        data-bs-toggle="dropdown">

                    🌐 EN

                </button>

                <ul class="dropdown-menu dropdown-menu-end">

                    <li>
                        <a class="dropdown-item" href="#">
                            🇦🇲 Հայերեն
                        </a>
                    </li>

                    <li>
                        <a class="dropdown-item" href="#">
                            🇬🇧 English
                        </a>
                    </li>

                    <li>
                        <a class="dropdown-item" href="#">
                            🇷🇺 Русский
                        </a>
                    </li>

                </ul>

            </div>

            {{-- Notifications --}}
            <button class="btn btn-light position-relative">

                <i class="bi bi-bell"></i>

                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">

                    3

                </span>

            </button>

            {{-- User --}}
            <div class="dropdown">

                <button class="btn btn-light dropdown-toggle"
                        data-bs-toggle="dropdown">

                    <i class="bi bi-person-circle me-2"></i>

                    {{ auth()->check() ? auth()->user()->name : 'Administrator' }}

                </button>

                <ul class="dropdown-menu dropdown-menu-end">

                    <li>

                        <a class="dropdown-item" href="#">

                            <i class="bi bi-person me-2"></i>

                            Profile

                        </a>

                    </li>

                    <li>

                        <hr class="dropdown-divider">

                    </li>

                    <li>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <button type="submit" class="dropdown-item text-danger">

                                <i class="bi bi-box-arrow-right me-2"></i>

                                Logout

                            </button>

                        </form>

                    </li>

                </ul>

            </div>

        </div>

    </div>

</nav> -->

<nav class="navbar fixed-top">

    <div class="container-fluid">

        <div class="navbar-left">

            <button
                class="menu-toggle"
                id="sidebarToggle">

                <i class="bi bi-list"></i>

            </button>

            <a href="{{ route('dashboard') }}" class="logo">

                LPG ERP

            </a>

        </div>

        <div class="navbar-right">

            {{-- Language --}}
            <div class="dropdown">

               <button class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown">

                    <i class="bi bi-globe"></i>

                    <span class="d-none d-md-inline ms-1">
                        EN
                    </span>

                </button>

                <ul class="dropdown-menu dropdown-menu-end">

                    <li>
                        <a class="dropdown-item" href="#">
                            🇦🇲 Հայերեն
                        </a>
                    </li>

                    <li>
                        <a class="dropdown-item" href="#">
                            🇬🇧 English
                        </a>
                    </li>

                    <li>
                        <a class="dropdown-item" href="#">
                            🇷🇺 Русский
                        </a>
                    </li>

                </ul>

            </div>

            {{-- Notifications --}}
            <button class="icon-btn">

                <i class="bi bi-bell"></i>

                <span class="notification-badge">

                    3

                </span>

            </button>

            {{-- User --}}
            <div class="dropdown">

               <button class="btn btn-light dropdown-toggle"
                        data-bs-toggle="dropdown">

                    <i class="bi bi-person-circle"></i>

                    <span class="d-none d-md-inline ms-2">
                        {{ auth()->user()->name }}
                    </span>

                </button>

                <ul class="dropdown-menu dropdown-menu-end">

                    <li>

                        <a class="dropdown-item" href="{{ route('profile.edit') }}">

                            <i class="bi bi-person me-2"></i>

                            Profile

                        </a>

                    </li>

                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li>

                        <form method="POST" action="{{ route('logout') }}">

                            @csrf

                            <button
                                type="submit"
                                class="dropdown-item text-danger">

                                <i class="bi bi-box-arrow-right me-2"></i>

                                Logout

                            </button>

                        </form>

                    </li>

                </ul>

            </div>

        </div>

    </div>

</nav>