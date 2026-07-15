@php
    $role = auth()->user()->role ?? null;
@endphp

<aside id="sidebar" class="sidebar">

    <div class="sidebar-header">

        <div class="sidebar-logo">
            <i class="bi bi-fire"></i>
        </div>

        <div class="sidebar-title">

            <h4>LPG ERP</h4>

            <small>{{ __('messages.management_system') }}</small>

        </div>

    </div>

    <ul class="sidebar-menu">

        <li>
            <a href="{{ route('dashboard') }}"
               class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">

                <i class="bi bi-speedometer2"></i>

                <span>{{ __('messages.dashboard') }}</span>

            </a>
        </li>

        @if(in_array($role, ['director','manager']))

            <li class="menu-title">

                {{ __('messages.management') }}

            </li>

            <li>

                <a href="{{ route('products.index') }}"
                   class="{{ request()->routeIs('products.*') ? 'active' : '' }}">

                    <i class="bi bi-box-seam"></i>

                   <span>{{ __('messages.products') }}</span>

                </a>

            </li>

            <li>

                <a href="{{ route('customers.index') }}"
                   class="{{ request()->routeIs('customers.*') ? 'active' : '' }}">

                    <i class="bi bi-people"></i>

                    <span>{{ __('messages.customers') }}</span>
                </a>

            </li>

            <li>

                <a href="{{ route('orders.index') }}"
                   class="{{ request()->routeIs('orders.*') ? 'active' : '' }}">

                    <i class="bi bi-cart3"></i>

                    <span>{{ __('messages.orders') }}</span>

                </a>

            </li>

        @endif

        @if($role === 'director')

            <li class="menu-title">

                {{ __('messages.administration') }}

            </li>

            <li>

                <a href="{{ route('users.index') }}"
                   class="{{ request()->routeIs('users.*') ? 'active' : '' }}">

                    <i class="bi bi-person-gear"></i>

                    <span>{{ __('messages.users') }}</span>

                </a>

            </li>

           <li>
                <a href="{{ route('reports.index') }}">
                    <i class="bi bi-bar-chart"></i>
                   <span>{{ __('messages.reports') }}</span>
                </a>
                <a href="{{ route('reports.monthly') }}" style="text-indent: 40px;">
    <span>{{ __('messages.monthly_report') }}</span>
</a>

            </li>
            <li class="nav-item">

    <a href="{{ route('stock-history.index') }}"
       class="nav-link">

        <i class="bi bi-clock-history"></i>

        <span>{{ __('messages.stock_history') }}</span>

    </a>

</li>
<li class="nav-item">

    <a
        href="{{ route('payments.index') }}"
        class="nav-link">

        <i class="bi bi-cash-stack"></i>

       <span>
    {{ __('messages.payments') }}
</span>

    </a>

</li>
            <li>

                <a href="#">

                    <i class="bi bi-gear"></i>

                    <span>{{ __('messages.settings') }}</span>

                </a>

            </li>

        @endif

        @if($role === 'driver')

            <li class="menu-title">

                {{ __('messages.driver') }}

            </li>

            <li>

                <a href="#">

                    <i class="bi bi-truck"></i>

<span>{{ __('messages.my_orders') }}</span>
                </a>

            </li>

        @endif

    </ul>

</aside>