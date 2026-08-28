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

    /*
    |--------------------------------------------------------------------------
    | Elements
    |--------------------------------------------------------------------------
    */

    const notificationButton =
        document.getElementById('notificationButton');

    const notificationDropdown =
        document.getElementById('notificationDropdown');

    const notificationList =
        document.getElementById('notificationList');

    const notificationBadge =
        document.getElementById('notificationBadge');

    const notificationSound =
        document.getElementById('notificationSound');

    const popupContainer =
        document.getElementById('statusNotificationContainer');


    /*
    |--------------------------------------------------------------------------
    | State
    |--------------------------------------------------------------------------
    */

    let knownNotificationIds = new Set();


    /*
    |--------------------------------------------------------------------------
    | Existing notifications
    |
    | These are already on the page.
    | Do NOT show popup or sound for them.
    |--------------------------------------------------------------------------
    */

    document
        .querySelectorAll('.notification-item[data-id]')
        .forEach(function (item) {

            knownNotificationIds.add(
                String(item.dataset.id)
            );

        });


    /*
    |--------------------------------------------------------------------------
    | LocalStorage
    |
    | Prevent the same notification from showing the popup
    | again after changing pages / refreshing.
    |--------------------------------------------------------------------------
    */

    const shownStorageKey =
        'progas_shown_notifications';


    function getShownNotifications()
    {
        try {

            return JSON.parse(
                localStorage.getItem(
                    shownStorageKey
                ) || '[]'
            );

        } catch (error) {

            return [];

        }
    }


    function saveShownNotification(id)
    {
        const shown =
            getShownNotifications();

        if (!shown.includes(String(id))) {

            shown.push(String(id));

            /*
            | Keep only last 100
            */

            if (shown.length > 100) {
                shown.shift();
            }

            localStorage.setItem(
                shownStorageKey,
                JSON.stringify(shown)
            );

        }
    }


    /*
    |--------------------------------------------------------------------------
    | Badge
    |--------------------------------------------------------------------------
    */

    function updateBadge(count)
    {
        count = Number(count) || 0;

        if (count > 0) {

            notificationBadge.textContent =
                count > 99 ? '99+' : count;

            notificationBadge.style.display =
                'inline-flex';

        } else {

            notificationBadge.style.display =
                'none';

        }
    }


    /*
    |--------------------------------------------------------------------------
    | Update empty message
    |--------------------------------------------------------------------------
    */

    function updateEmptyMessage()
    {
        const items =
            notificationList.querySelectorAll(
                '.notification-item'
            );

        let empty =
            document.getElementById(
                'notificationEmpty'
            );

        if (items.length === 0) {

            if (!empty) {

                empty =
                    document.createElement('div');

                empty.id =
                    'notificationEmpty';

                empty.className =
                    'notification-empty';

                empty.innerHTML = `
                    <i class="bi bi-bell-slash"></i>
                    <div>
                        {{ __('messages.no_notifications') }}
                    </div>
                `;

                notificationList.appendChild(
                    empty
                );

            }

        } else {

            if (empty) {
                empty.remove();
            }

        }
    }


    /*
    |--------------------------------------------------------------------------
    | Escape HTML
    |--------------------------------------------------------------------------
    */

    function escapeHtml(value)
    {
        const div =
            document.createElement('div');

        div.textContent =
            value ?? '';

        return div.innerHTML;
    }


    /*
    |--------------------------------------------------------------------------
    | Add notification to dropdown
    |--------------------------------------------------------------------------
    */

    function addNotification(notification)
    {
        const id =
            String(notification.id);


        /*
        | Don't add duplicates
        */

        if (
            notificationList.querySelector(
                `.notification-item[data-id="${CSS.escape(id)}"]`
            )
        ) {

            return;

        }


        const item =
            document.createElement('div');


        item.className =
            'notification-item';


        item.dataset.id =
            id;


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

                    ${escapeHtml(
                        notification.title ||
                        'Order Status Changed'
                    )}

                </div>


                <div class="notification-message">

                    ${escapeHtml(
                        notification.order_number ||
                        ''
                    )}

                </div>


                <div class="notification-message">

                    ${escapeHtml(
                        notification.old_status ||
                        ''
                    )}

                    →

                    ${escapeHtml(
                        notification.new_status ||
                        ''
                    )}

                </div>


                <small class="text-muted">

                    ${escapeHtml(
                        notification.driver_name ||
                        ''
                    )}

                    ·

                    ${escapeHtml(
                        notification.created_at ||
                        ''
                    )}

                </small>

            </div>


            <button
                type="button"
                class="notification-delete"
                data-notification-id="${escapeHtml(id)}"
                title="Delete">

                ×

            </button>

        `;


        /*
        | Put newest notification at the top
        */

        const empty =
            document.getElementById(
                'notificationEmpty'
            );


        if (empty) {
            empty.remove();
        }


        notificationList.prepend(item);


        /*
        | Keep maximum 10 in dropdown
        */

        const items =
            notificationList.querySelectorAll(
                '.notification-item'
            );


        if (items.length > 10) {

            items[items.length - 1].remove();

        }

    }


    /*
    |--------------------------------------------------------------------------
    | Play notification sound
    |--------------------------------------------------------------------------
    */

    function playNotificationSound()
    {
        if (!notificationSound) {
            return;
        }


        notificationSound.currentTime = 0;


        const promise =
            notificationSound.play();


        if (
            promise &&
            typeof promise.catch === 'function'
        ) {

            promise.catch(function (error) {

                /*
                | Browser may block autoplay.
                | After user interaction it will work.
                */

                console.log(
                    'Notification sound was blocked:',
                    error
                );

            });

        }

    }


    /*
    |--------------------------------------------------------------------------
    | Popup
    |--------------------------------------------------------------------------
    */

    function showNotificationPopup(notification)
    {
        const popup =
            document.createElement('div');


        popup.className =
            'status-notification-popup';


        popup.dataset.notificationId =
            notification.id;


        popup.dataset.orderId =
            notification.order_id || '';


        popup.innerHTML = `

            <div class="status-notification-header">

                <strong>

                    🔔 Order status changed

                </strong>


                <button
                    type="button"
                    class="status-notification-close">

                    ×

                </button>

            </div>


            <div class="status-notification-body">

                <div class="status-notification-icon">

                    <i class="bi bi-bell-fill"></i>

                </div>


                <div class="status-notification-content">

                    <div class="status-notification-order">

                        ${escapeHtml(
                            notification.order_number ||
                            ''
                        )}

                    </div>


                    <div class="status-notification-status">

                        ${escapeHtml(
                            notification.old_status ||
                            ''
                        )}

                        →

                        ${escapeHtml(
                            notification.new_status ||
                            ''
                        )}

                    </div>


                    <div class="status-notification-driver">

                        ${escapeHtml(
                            notification.driver_name ||
                            ''
                        )}

                    </div>

                </div>

            </div>

        `;


        popupContainer.appendChild(
            popup
        );


        /*
        |--------------------------------------------------------------------------
        | Popup X
        |
        | VERY IMPORTANT:
        | Do NOT delete/read the notification.
        | Only close the visual popup.
        |--------------------------------------------------------------------------
        */

        popup
            .querySelector(
                '.status-notification-close'
            )
            .addEventListener(
                'click',
                function (event) {

                    event.stopPropagation();

                    popup.remove();

                }
            );


        /*
        |--------------------------------------------------------------------------
        | Popup click → open order
        |--------------------------------------------------------------------------
        */

        popup.addEventListener(
            'click',
            function (event) {

                if (
                    event.target.closest(
                        '.status-notification-close'
                    )
                ) {

                    return;

                }


                const orderId =
                    popup.dataset.orderId;


                if (orderId) {

                    window.location.href =
                        `/orders/${orderId}`;

                }

            }
        );


        /*
        |--------------------------------------------------------------------------
        | Automatically close popup after 7 seconds
        |
        | Notification remains in database.
        |--------------------------------------------------------------------------
        */

        setTimeout(
            function () {

                if (popup.parentElement) {

                    popup.remove();

                }

            },
            7000
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Check notifications
    |--------------------------------------------------------------------------
    */

    async function checkNotifications()
    {
        try {

            const response =
                await fetch(
                    '{{ route('notifications.latest') }}',
                    {
                        method: 'GET',

                        headers: {
                            'Accept':
                                'application/json',

                            'X-Requested-With':
                                'XMLHttpRequest'
                        },

                        cache: 'no-store'
                    }
                );


            if (!response.ok) {
                return;
            }


            const notifications =
                await response.json();


            /*
            | Badge = ALL unread notifications
            */

            updateBadge(
                notifications.length
            );


            /*
            | Process notifications
            */

            notifications.forEach(
                function (notification) {

                    const id =
                        String(notification.id);


                    /*
                    | Add to dropdown if missing
                    */

                    addNotification(
                        notification
                    );


                    /*
                    | New notification?
                    */

                    if (
                        !knownNotificationIds.has(id)
                    ) {

                        knownNotificationIds.add(
                            id
                        );


                        const shown =
                            getShownNotifications();


                        /*
                        | Show popup + sound only once
                        */

                        if (
                            !shown.includes(id)
                        ) {

                            saveShownNotification(
                                id
                            );


                            showNotificationPopup(
                                notification
                            );


                            playNotificationSound();

                        }

                    }

                }
            );


            updateEmptyMessage();

        }
        catch (error) {

            console.error(
                'Notification polling error:',
                error
            );

        }

    }


    /*
    |--------------------------------------------------------------------------
    | Notification bell
    |--------------------------------------------------------------------------
    */

    notificationButton.addEventListener(
        'click',
        function (event) {

            event.stopPropagation();

            notificationDropdown.classList.toggle(
                'show'
            );

        }
    );


    /*
    |--------------------------------------------------------------------------
    | Close dropdown when clicking outside
    |--------------------------------------------------------------------------
    */

    document.addEventListener(
        'click',
        function (event) {

            if (
                !event.target.closest(
                    '.notification-wrapper'
                )
            ) {

                notificationDropdown.classList.remove(
                    'show'
                );

            }

        }
    );


    /*
    |--------------------------------------------------------------------------
    | Notification click
    |
    | Opens ONLY the order.
    |
    | Example:
    | /orders/6
    |
    | It does NOT mark it as read.
    |--------------------------------------------------------------------------
    */

    notificationList.addEventListener(
        'click',
        function (event) {

            /*
            | X button has its own behavior.
            */

            if (
                event.target.closest(
                    '.notification-delete'
                )
            ) {

                return;

            }


            const item =
                event.target.closest(
                    '.notification-item'
                );


            if (!item) {
                return;
            }


            const orderId =
                item.dataset.orderId;


            if (!orderId) {
                return;
            }


            window.location.href =
                `/orders/${orderId}`;

        }
    );


    /*
    |--------------------------------------------------------------------------
    | Delete notification
    |
    | ONLY the X deletes it.
    |--------------------------------------------------------------------------
    */

    notificationList.addEventListener(
        'click',
        async function (event) {

            const deleteButton =
                event.target.closest(
                    '.notification-delete'
                );


            if (!deleteButton) {
                return;
            }


            event.preventDefault();

            event.stopPropagation();


            const notificationId =
                deleteButton.dataset.notificationId;


            try {

                const response =
                    await fetch(
                        `/notifications/${notificationId}`,
                        {
                            method: 'DELETE',

                            headers: {

                                'X-CSRF-TOKEN':
                                    document
                                        .querySelector(
                                            'meta[name="csrf-token"]'
                                        )
                                        .getAttribute(
                                            'content'
                                        ),

                                'Accept':
                                    'application/json',

                                'X-Requested-With':
                                    'XMLHttpRequest'

                            }
                        }
                    );


                if (!response.ok) {

                    throw new Error(
                        'Notification delete failed'
                    );

                }


                /*
                | Remove from dropdown
                */

                const item =
                    deleteButton.closest(
                        '.notification-item'
                    );


                if (item) {
                    item.remove();
                }


                /*
                | Remove from known IDs
                */

                knownNotificationIds.delete(
                    String(notificationId)
                );


                /*
                | Remove from localStorage
                */

                const shown =
                    getShownNotifications()
                        .filter(
                            function (id) {

                                return String(id) !==
                                    String(notificationId);

                            }
                        );


                localStorage.setItem(
                    shownStorageKey,
                    JSON.stringify(shown)
                );


                /*
                | Recalculate badge from server
                */

                await checkNotifications();


                updateEmptyMessage();

            }
            catch (error) {

                console.error(
                    'Notification delete error:',
                    error
                );

            }

        }
    );


    /*
    |--------------------------------------------------------------------------
    | Initial badge
    |--------------------------------------------------------------------------
    */

    updateBadge(
        document.querySelectorAll(
            '.notification-item'
        ).length
    );


    /*
    |--------------------------------------------------------------------------
    | Start polling
    |
    | ONLY ONE polling interval.
    |--------------------------------------------------------------------------
    */

    checkNotifications();


    setInterval(
        checkNotifications,
        5000
    );

});

</script>