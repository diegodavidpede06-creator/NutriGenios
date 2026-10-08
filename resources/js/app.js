/*
|--------------------------------------------------------------------------
| CONFIGURACIÓN GENERAL
|--------------------------------------------------------------------------
*/

document.addEventListener('DOMContentLoaded', () => {

    /*
    |--------------------------------------------------------------------------
    | SIDEBAR
    |--------------------------------------------------------------------------
    */

    const sidebar = document.getElementById('sidebar');
    const menuToggle = document.getElementById('menuToggle');
    const sidebarClose = document.getElementById('sidebarClose');
    const sidebarOverlay = document.getElementById('sidebarOverlay');

    function openSidebar() {
        if (!sidebar) {
            return;
        }

        sidebar.classList.add('open');

        if (sidebarOverlay) {
            sidebarOverlay.classList.add('active');
        }

        document.body.classList.add('sidebar-open');
    }

    function closeSidebar() {
        if (!sidebar) {
            return;
        }

        sidebar.classList.remove('open');

        if (sidebarOverlay) {
            sidebarOverlay.classList.remove('active');
        }

        document.body.classList.remove('sidebar-open');
    }

    if (menuToggle) {
        menuToggle.addEventListener('click', () => {
            if (sidebar && sidebar.classList.contains('open')) {
                closeSidebar();
            } else {
                openSidebar();
            }
        });
    }

    if (sidebarClose) {
        sidebarClose.addEventListener('click', () => {
            closeSidebar();
        });
    }

    if (sidebarOverlay) {
        sidebarOverlay.addEventListener('click', () => {
            closeSidebar();
        });
    }


    /*
    |--------------------------------------------------------------------------
    | CERRAR SIDEBAR AL CAMBIAR DE PÁGINA EN MÓVIL
    |--------------------------------------------------------------------------
    */

    if (sidebar) {
        const sidebarLinks = sidebar.querySelectorAll('a');

        sidebarLinks.forEach((link) => {
            link.addEventListener('click', () => {
                closeSidebar();
            });
        });
    }


    /*
    |--------------------------------------------------------------------------
    | MODO CLARO / OSCURO
    |--------------------------------------------------------------------------
    */

    const themeToggle = document.getElementById('themeToggle');
    const themeIcon = document.querySelector('.theme-icon');

    const savedTheme = localStorage.getItem('nutriologia-theme');

    function setTheme(theme) {
        document.documentElement.setAttribute('data-theme', theme);

        localStorage.setItem('nutriologia-theme', theme);

        if (themeIcon) {
            if (theme === 'dark') {
                themeIcon.textContent = 'Sol';
            } else {
                themeIcon.textContent = 'Luna';
            }
        }
    }

    if (savedTheme === 'dark') {
        setTheme('dark');
    } else {
        setTheme('light');
    }

    if (themeToggle) {
        themeToggle.addEventListener('click', () => {

            const currentTheme =
                document.documentElement.getAttribute('data-theme');

            if (currentTheme === 'dark') {
                setTheme('light');
            } else {
                setTheme('dark');
            }

        });
    }


    /*
    |--------------------------------------------------------------------------
    | CERRAR SIDEBAR CON ESC
    |--------------------------------------------------------------------------
    */

    document.addEventListener('keydown', (event) => {

        if (event.key === 'Escape') {
            closeSidebar();
        }

    });


    /*
    |--------------------------------------------------------------------------
    | CAMBIO AUTOMÁTICO DE TAMAÑO
    |--------------------------------------------------------------------------
    */

    window.addEventListener('resize', () => {

        if (window.innerWidth > 900) {
            closeSidebar();
        }

    });

});