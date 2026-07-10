const layout = document.getElementById('app-layout');
const sidebar = document.getElementById('sidebar');
const sidebarToggle = document.getElementById('sidebarToggle');

function isDesktop() {
    return window.innerWidth > 1250;
}

function initSidebar() {

    if (isDesktop()) {

        sidebar.classList.remove('show');

    } else {

        layout.classList.remove('sidebar-collapsed');

    }

}

sidebarToggle?.addEventListener('click', function () {

    if (isDesktop()) {

        layout.classList.toggle('sidebar-collapsed');

    } else {

        sidebar.classList.toggle('show');

    }

});

window.addEventListener('resize', initSidebar);

document.addEventListener('click', function (e) {

    if (!isDesktop()) {

        if (
            !sidebar.contains(e.target) &&
            !sidebarToggle.contains(e.target)
        ) {
            sidebar.classList.remove('show');
        }

    }

});

initSidebar();