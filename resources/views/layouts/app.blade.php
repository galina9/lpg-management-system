
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>ProGas</title>

    @vite(['resources/js/app.js'])
</head>

<body>

    @include('components.navbar')

    <div class="layout-wrapper">

        @include('components.sidebar')

        <main id="main-content">

            <div class="page-wrapper">

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
{{-- Notification Toast --}}
<div id="notification-container"></div>

<audio id="notification-sound" preload="auto">
    <source src="/sounds/notification.mp3" type="audio/mpeg">
</audio>

<style>
    #notification-container {
        position: fixed;
        right: 20px;
        bottom: 20px;
        z-index: 9999;
        width: 350px;
    }

    .notification-toast {
        background: white;
        border-radius: 12px;
        padding: 16px;
        margin-top: 10px;
        box-shadow: 0 8px 25px rgba(0,0,0,.18);
        border-left: 4px solid #0d6efd;
        animation: notificationSlide .3s ease;
    }

    .notification-toast-title {
        font-weight: 700;
        margin-bottom: 6px;
    }

    .notification-toast-close {
        float: right;
        border: none;
        background: transparent;
        font-size: 20px;
        cursor: pointer;
    }

    @keyframes notificationSlide {
        from {
            transform: translateX(120%);
            opacity: 0;
        }

        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {

    let knownNotifications = new Set();

    function checkNotifications() {

        fetch('{{ route('notifications.latest') }}')
            .then(response => response.json())
            .then(notifications => {

                notifications.forEach(notification => {

                    if (!knownNotifications.has(notification.id)) {

                        knownNotifications.add(notification.id);

                        showNotification(notification);

                    }

                });

            })
            .catch(error => {
                console.error('Notification error:', error);
            });
    }


    function showNotification(notification) {

        const container =
            document.getElementById('notification-container');

        const toast =
            document.createElement('div');

        toast.className = 'notification-toast';

        toast.innerHTML = `
            <button
                class="notification-toast-close"
                onclick="this.parentElement.remove()">
                ×
            </button>

            <div class="notification-toast-title">
                🔔 Order status changed
            </div>

            <div>
                <strong>Order:</strong>
                #${notification.order_number}
            </div>

            <div>
                <strong>Driver:</strong>
                ${notification.driver_name}
            </div>

            <div>
                <strong>Status:</strong>
                ${notification.old_status}
                →
                ${notification.new_status}
            </div>

            <div class="text-muted small mt-1">
                ${notification.created_at}
            </div>
        `;

        container.appendChild(toast);


        // Notification sound
        const sound =
            document.getElementById('notification-sound');

        sound.currentTime = 0;

        sound.play().catch(() => {
            console.log(
                'Browser blocked notification sound until user interaction.'
            );
        });


        // Automatically disappear after 8 seconds
        setTimeout(() => {

            toast.remove();

        }, 8000);
    }


    // First check
    checkNotifications();


    // Check every 5 seconds
    setInterval(checkNotifications, 5000);

});
</script>    
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</body>

</html>