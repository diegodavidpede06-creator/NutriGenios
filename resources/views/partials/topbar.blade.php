<header class="topbar">

    <div class="topbar-left">

        <button
            type="button"
            class="menu-toggle"
            id="menuToggle"
            aria-label="Abrir menú"
        >
            <span></span>
            <span></span>
            <span></span>
        </button>

        <div class="page-heading">

            <span class="page-eyebrow">
                Consultorio de nutrición
            </span>

            <h1>
                @yield('page-title', 'Panel')
            </h1>

        </div>

    </div>


    <div class="topbar-right">

        <button
            type="button"
            class="theme-toggle"
            id="themeToggle"
            aria-label="Cambiar tema"
            title="Cambiar tema"
        >
            <span class="theme-icon">☾</span>
        </button>


        @auth

            <div class="topbar-user">

                <div class="topbar-avatar">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>

                <div class="topbar-user-info">

                    <strong>
                        {{ auth()->user()->name }}
                    </strong>

                    <span>
                        @if(auth()->user()->esNutriologo())
                            Nutriólogo
                        @else
                            Cliente
                        @endif
                    </span>

                </div>

            </div>

        @endauth

    </div>

</header>