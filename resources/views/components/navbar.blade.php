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

                    @switch(app()->getLocale())

                        @case('hy')
                            HY
                            @break

                        @case('ru')
                            RU
                            @break

                        @default
                            EN

                    @endswitch

                </span>

                </button>

                <ul class="dropdown-menu dropdown-menu-end">

                    <li>
                        <a
                            class="dropdown-item"
                            href="{{ route('language.switch', 'hy') }}">

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

                            {{ __('messages.profile') }}

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

                                {{ __('messages.logout') }}

                            </button>

                        </form>

                    </li>

                </ul>

            </div>

        </div>

    </div>

</nav>