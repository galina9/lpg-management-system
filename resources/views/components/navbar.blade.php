<nav class="navbar fixed-top">

    <div class="container-fluid">

        {{-- =========================================================
             LEFT
        ========================================================== --}}

        <div class="navbar-left">

            <button
                class="menu-toggle"
                id="sidebarToggle"
                type="button">

                <i class="bi bi-list"></i>

            </button>

            <a
                href="{{ route('dashboard') }}"
                class="logo">

                ProGas

            </a>

        </div>


        {{-- =========================================================
             RIGHT
        ========================================================== --}}

        <div class="navbar-right">


            {{-- =====================================================
                 LANGUAGE
            ====================================================== --}}

            <div class="dropdown">

                <button
                    class="btn btn-light dropdown-toggle"
                    type="button"
                    data-bs-toggle="dropdown">

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

                        <a
                            class="dropdown-item"
                            href="{{ route('language.switch', 'en') }}">

                            🇬🇧 English

                        </a>

                    </li>

                    <li>

                        <a
                            class="dropdown-item"
                            href="{{ route('language.switch', 'ru') }}">

                            🇷🇺 Русский

                        </a>

                    </li>

                </ul>

            </div>


            {{-- =====================================================
                 NOTIFICATIONS
            ====================================================== --}}

            <div class="notification-wrapper">

                <button
                    class="icon-btn"
                    id="notificationButton"
                    type="button"
                    aria-label="Notifications">

                    <i class="bi bi-bell"></i>

                    <span
                        class="notification-badge"
                        id="notificationBadge"
                        style="display: none;">

                        0

                    </span>

                </button>


                {{-- =================================================
                     NOTIFICATION DROPDOWN
                ================================================== --}}

                <div
                    class="notification-dropdown"
                    id="notificationDropdown">

                    <div class="notification-header">

                        <strong>
                            {{ __('messages.notifications') }}
                        </strong>

                    </div>


                    <div
                        class="notification-list"
                        id="notificationList">

                        @forelse(
                            auth()->user()
                                ->unreadNotifications
                                ->take(10)
                            as $notification
                        )

                            <div
                                class="notification-item"
                                data-id="{{ $notification->id }}"
                                data-order-id="{{ $notification->data['order_id'] ?? '' }}"
                                style="cursor: pointer;">

                                <div class="notification-icon">

                                    <i class="bi bi-truck"></i>

                                </div>


                                <div class="notification-content">

                                    <div class="notification-title">

                                        {{ $notification->data['title'] ?? 'Order Status Changed' }}

                                    </div>


                                    <div class="notification-message">

                                        {{ $notification->data['order_number'] ?? '' }}

                                    </div>


                                    <div class="notification-message">

                                        {{ $notification->data['old_status'] ?? '' }}

                                        →

                                        {{ $notification->data['new_status'] ?? '' }}

                                    </div>


                                    <small class="text-muted">

                                        {{ $notification->data['driver_name'] ?? '' }}

                                        ·

                                        {{ $notification->created_at->diffForHumans() }}

                                    </small>

                                </div>


                                {{-- DELETE ONLY THIS NOTIFICATION --}}

                                <button
                                    type="button"
                                    class="notification-delete"
                                    data-notification-id="{{ $notification->id }}"
                                    title="Delete">

                                    ×

                                </button>

                            </div>

                        @empty

                            <div
                                class="notification-empty"
                                id="notificationEmpty">

                                <i class="bi bi-bell-slash"></i>

                                <div>
                                    {{ __('messages.no_notifications') }}
                                </div>

                            </div>

                        @endforelse

                    </div>

                </div>

            </div>


            {{-- =====================================================
                 USER
            ====================================================== --}}

            <div class="dropdown">

                <button
                    class="btn btn-light dropdown-toggle"
                    type="button"
                    data-bs-toggle="dropdown">

                    <i class="bi bi-person-circle"></i>

                    <span class="d-none d-md-inline ms-2">

                        {{ auth()->user()->name }}

                    </span>

                </button>


                <ul class="dropdown-menu dropdown-menu-end">

                    <li>

                        <a
                            class="dropdown-item"
                            href="{{ route('profile.edit') }}">

                            <i class="bi bi-person me-2"></i>

                            {{ __('messages.profile') }}

                        </a>

                    </li>


                    <li>

                        <hr class="dropdown-divider">

                    </li>


                    <li>

                        <form
                            method="POST"
                            action="{{ route('logout') }}">

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


{{-- =============================================================
     STATUS NOTIFICATION POPUPS
============================================================= --}}

<div id="statusNotificationContainer"></div>


{{-- =============================================================
     NOTIFICATION SOUND
     
     FILE:
     public/sounds/notification.mp3
============================================================= --}}

<audio
    id="notificationSound"
    preload="auto">

    <source
        src="{{ asset('sounds/notification.mp3') }}"
        type="audio/mpeg">

</audio>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const notificationButton =
        document.getElementById('notificationButton');

    const notificationDropdown =
        document.getElementById('notificationDropdown');

    const notificationList =
        document.getElementById('notificationList');

    const notificationBadge =
        document.getElementById('notificationBadge');

    const statusNotificationContainer =
        document.getElementById('statusNotificationContainer');

    const notificationSound =
        document.getElementById('notificationSound');


    /*
    |--------------------------------------------------------------------------
    | Keep track of notifications already shown as popup
    |--------------------------------------------------------------------------
    */

    let shownNotifications =
        new Set();


    /*
    |--------------------------------------------------------------------------
    | Notification dropdown
    |--------------------------------------------------------------------------
    */

    if (notificationButton && notificationDropdown) {

        notificationButton.addEventListener(
            'click',
            function (event) {

                event.stopPropagation();

                notificationDropdown.classList.toggle('show');

            }
        );


        document.addEventListener(
            'click',
            function (event) {

                if (
                    !notificationDropdown.contains(event.target) &&
                    !notificationButton.contains(event.target)
                ) {

                    notificationDropdown.classList.remove('show');

                }

            }
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Update bell badge
    |--------------------------------------------------------------------------
    */

    function updateBadge(count) {

        if (!notificationBadge) {
            return;
        }


        count = parseInt(count) || 0;


        if (count > 0) {

            notificationBadge.textContent = count;

            notificationBadge.style.display =
                'inline-flex';

        } else {

            notificationBadge.textContent = '0';

            notificationBadge.style.display =
                'none';

        }

    }


    /*
    |--------------------------------------------------------------------------
    | Delete notification
    |--------------------------------------------------------------------------
    | Միայն փոքր ×-ը ջնջում է notification-ը
    |--------------------------------------------------------------------------
    */

    function deleteNotification(id, element) {

        fetch('/notifications/' + id, {

            method: 'DELETE',

            headers: {

                'X-CSRF-TOKEN':
                    document
                        .querySelector(
                            'meta[name="csrf-token"]'
                        )
                        .getAttribute('content'),

                'Accept':
                    'application/json',

            }

        })

        .then(response => {

            if (!response.ok) {
                throw new Error('Delete failed');
            }

            return response.json();

        })

        .then(data => {

            if (element) {
                element.remove();
            }


            /*
            |--------------------------------------------------------------------------
            | Re-read actual unread count from server
            |--------------------------------------------------------------------------
            */

            loadNotifications(false);

        })

        .catch(error => {

            console.error(
                'Notification delete error:',
                error
            );

        });

    }


    /*
    |--------------------------------------------------------------------------
    | Open notification
    |--------------------------------------------------------------------------
    | Սեղմելը ՉԻ ջնջում և ՉԻ markAsRead անում
    |--------------------------------------------------------------------------
    */

    if (notificationList) {

        notificationList.addEventListener(
            'click',
            function (event) {


                /*
                |--------------------------------------------------------------------------
                | Delete button
                |--------------------------------------------------------------------------
                */

                const deleteButton =
                    event.target.closest(
                        '.notification-delete'
                    );


                if (deleteButton) {

                    event.preventDefault();

                    event.stopPropagation();


                    const item =
                        deleteButton.closest(
                            '.notification-item'
                        );


                    if (!item) {
                        return;
                    }


                    const id =
                        item.dataset.id;


                    deleteNotification(
                        id,
                        item
                    );


                    return;
                }


                /*
                |--------------------------------------------------------------------------
                | Notification itself
                |--------------------------------------------------------------------------
                */

                const item =
                    event.target.closest(
                        '.notification-item'
                    );


                if (!item) {
                    return;
                }


                const orderId =
                    item.dataset.orderId;


                if (orderId) {

                    window.location.href =
                        '/orders/' + orderId;

                }

            }
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Create bottom popup
    |--------------------------------------------------------------------------
    */

    function showNotificationPopup(notification) {

        if (!statusNotificationContainer) {
            return;
        }


        /*
        |--------------------------------------------------------------------------
        | Prevent duplicate popup
        |--------------------------------------------------------------------------
        */

        if (
            shownNotifications.has(
                notification.id
            )
        ) {

            return;

        }


        shownNotifications.add(
            notification.id
        );


        const popup =
            document.createElement('div');

        popup.className =
            'status-notification-popup';


        popup.innerHTML = `

            <div class="status-notification-icon">
                <i class="bi bi-truck"></i>
            </div>


            <div class="status-notification-content">

                <div class="status-notification-title">
                    Order Status Changed
                </div>


                <div class="status-notification-order">
                    ${notification.order_number || ''}
                </div>


                <div class="status-notification-status">

                    ${notification.old_status || ''}

                    <span>→</span>

                    ${notification.new_status || ''}

                </div>


                <small>

                    ${notification.driver_name || ''}

                    ·

                    ${notification.created_at || ''}

                </small>

            </div>


            <button
                type="button"
                class="status-notification-close"
                aria-label="Close">

                ×

            </button>

        `;


        /*
        |--------------------------------------------------------------------------
        | Click popup → open order
        |--------------------------------------------------------------------------
        */

        popup.addEventListener(
            'click',
            function (event) {

                /*
                | Don't open order when × is clicked
                */

                if (
                    event.target.closest(
                        '.status-notification-close'
                    )
                ) {

                    return;

                }


                if (notification.order_id) {

                    window.location.href =
                        '/orders/' +
                        notification.order_id;

                }

            }
        );


        /*
        |--------------------------------------------------------------------------
        | Close popup only
        |--------------------------------------------------------------------------
        | IMPORTANT:
        | Notification-ը չի ջնջվում
        | Notification-ը չի markAsRead արվում
        |--------------------------------------------------------------------------
        */

        const closeButton =
            popup.querySelector(
                '.status-notification-close'
            );


        if (closeButton) {

            closeButton.addEventListener(
                'click',
                function (event) {

                    event.preventDefault();

                    event.stopPropagation();

                    popup.remove();

                }
            );

        }


        statusNotificationContainer.appendChild(
            popup
        );


        /*
        |--------------------------------------------------------------------------
        | Sound
        |--------------------------------------------------------------------------
        */

        if (notificationSound) {

            notificationSound.currentTime = 0;

            notificationSound.play()
                .catch(function (error) {

                    console.log(
                        'Notification sound blocked:',
                        error
                    );

                });

        }

    }


    /*
    |--------------------------------------------------------------------------
    | Render notification in dropdown
    |--------------------------------------------------------------------------
    */

    function addNotificationToDropdown(
        notification
    ) {

        if (!notificationList) {
            return;
        }


        /*
        |--------------------------------------------------------------------------
        | Don't duplicate
        |--------------------------------------------------------------------------
        */

        if (
            notificationList.querySelector(
                '[data-id="' +
                notification.id +
                '"]'
            )
        ) {

            return;

        }


        /*
        |--------------------------------------------------------------------------
        | Remove empty message
        |--------------------------------------------------------------------------
        */

        const empty =
            document.getElementById(
                'notificationEmpty'
            );


        if (empty) {
            empty.remove();
        }


        const item =
            document.createElement('div');


        item.className =
            'notification-item';


        item.dataset.id =
            notification.id;


        item.dataset.orderId =
            notification.order_id || '';


        item.style.cursor =
            'pointer';


        item.innerHTML = `

            <div class="notification-icon">

                <i class="bi bi-truck"></i>

            </div>


            <div class="notification-content">

                <div class="notification-title">

                    ${notification.title ||
                    'Order Status Changed'}

                </div>


                <div class="notification-message">

                    ${notification.order_number || ''}

                </div>


                <div class="notification-message">

                    ${notification.old_status || ''}

                    →

                    ${notification.new_status || ''}

                </div>


                <small class="text-muted">

                    ${notification.driver_name || ''}

                    ·

                    ${notification.created_at || ''}

                </small>

            </div>


            <button
                type="button"
                class="notification-delete"
                data-notification-id="${notification.id}"
                title="Delete">

                ×

            </button>

        `;


        notificationList.prepend(
            item
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Load notifications
    |--------------------------------------------------------------------------
    */

    function loadNotifications(
        showPopup = true
    ) {

        fetch('/notifications/latest', {

            headers: {

                'Accept':
                    'application/json',

            }

        })

        .then(response => {

            if (!response.ok) {
                throw new Error(
                    'Notification request failed'
                );
            }

            return response.json();

        })

        .then(data => {

            /*
            |--------------------------------------------------------------------------
            | IMPORTANT
            |--------------------------------------------------------------------------
            | web.php-ն վերադարձնում է object,
            | ոչ թե ուղղակի array
            |--------------------------------------------------------------------------
            */

            const notifications =
                data.notifications || [];


            /*
            |--------------------------------------------------------------------------
            | Update bell number
            |--------------------------------------------------------------------------
            */

            updateBadge(
                data.unread_count
            );


            /*
            |--------------------------------------------------------------------------
            | Add notifications to dropdown
            |--------------------------------------------------------------------------
            */

            notifications.forEach(
                function (notification) {

                    addNotificationToDropdown(
                        notification
                    );

                }
            );


            /*
            |--------------------------------------------------------------------------
            | Show popup ONLY for new notifications
            |--------------------------------------------------------------------------
            */

            if (showPopup) {

                notifications.forEach(
                    function (notification) {

                        showNotificationPopup(
                            notification
                        );

                    }
                );

            }

        })

        .catch(error => {

            console.error(
                'Notification loading error:',
                error
            );

        });

    }


    /*
    |--------------------------------------------------------------------------
    | Initial load
    |--------------------------------------------------------------------------
    */

    loadNotifications(false);


    /*
    |--------------------------------------------------------------------------
    | Check for new notifications
    |--------------------------------------------------------------------------
    | Ամեն 5 վայրկյանը մեկ
    |--------------------------------------------------------------------------
    */

    setInterval(
        function () {

            loadNotifications(true);

        },
        5000
    );


});
</script>