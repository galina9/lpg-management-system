import 'bootstrap';

import '../css/app.css';

document.addEventListener('DOMContentLoaded', () => {

    const sidebar = document.getElementById('sidebar');
    const toggle = document.getElementById('sidebarToggle');
    const wrapper = document.querySelector('.layout-wrapper');

    if (!sidebar || !toggle || !wrapper) {
        return;
    }

    function isMobile() {
        return window.innerWidth <= 1250;
    }

    toggle.addEventListener('click', () => {

        if (isMobile()) {

            sidebar.classList.toggle('show');

        } else {

            wrapper.classList.toggle('sidebar-collapsed');

        }

    });

    document.addEventListener('click', (e) => {

        if (!isMobile()) return;

        if (
            !sidebar.contains(e.target) &&
            !toggle.contains(e.target)
        ) {
            sidebar.classList.remove('show');
        }

    });

    window.addEventListener('resize', () => {

        if (!isMobile()) {
            sidebar.classList.remove('show');
        }

    });

});