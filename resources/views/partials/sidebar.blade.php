<aside class="sidebar" id="sidebar">

    {{-- =========================================================
         ENCABEZADO
    ========================================================== --}}
    <div class="sidebar-header">

        <a href="{{ route('inicio') }}" class="brand">

            <div class="brand-icon">
                N
            </div>

            <div class="brand-text">
                <strong>Nutriología</strong>
                <span>Consultorio</span>
            </div>

        </a>

        <button
            type="button"
            class="sidebar-close"
            id="sidebarClose"
            aria-label="Cerrar menú"
        >
            ×
        </button>

    </div>


    @auth

        {{-- =====================================================
             PERFIL DEL USUARIO
        ====================================================== --}}
        <div class="sidebar-profile">

            <div class="profile-avatar">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>

            <div class="profile-info">

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


        {{-- =====================================================
             NAVEGACIÓN
        ====================================================== --}}
        <nav class="sidebar-nav">


            {{-- =================================================
                 CLIENTE
            ================================================== --}}
            @if(auth()->user()->esCliente())

                <div class="nav-section">
                    <span>MI ESPACIO</span>
                </div>


                {{-- INICIO --}}
                <a
                    href="{{ route('cliente.dashboard') }}"
                    class="nav-link {{ request()->routeIs('cliente.dashboard') ? 'active' : '' }}"
                >
                    <span class="nav-icon">⌂</span>
                    <span>Inicio</span>
                </a>


                {{-- MIS CITAS --}}
                <a
                    href="{{ route('cliente.citas') }}"
                    class="nav-link {{ request()->routeIs('cliente.citas') || request()->routeIs('cliente.citas.mostrar') || request()->routeIs('cliente.citas.cancelar') ? 'active' : '' }}"
                >
                    <span class="nav-icon">◷</span>
                    <span>Mis citas</span>
                </a>


                {{-- AGENDAR CITA --}}
                <a
                    href="{{ route('cliente.citas.crear') }}"
                    class="nav-link {{ request()->routeIs('cliente.citas.crear') ? 'active' : '' }}"
                >
                    <span class="nav-icon">＋</span>
                    <span>Agendar cita</span>
                </a>


                {{-- FORMULARIO CLÍNICO
                     Se utiliza URL directa para evitar
                     el error de nombre de ruta. --}}
                <a
                    href="{{ url('/cliente/formulario-clinico') }}"
                    class="nav-link {{ request()->routeIs('cliente.formulario.*') ? 'active' : '' }}"
                >
                    <span class="nav-icon">▣</span>
                    <span>Formulario clínico</span>
                </a>


                {{-- MI CUENTA --}}
                <div class="nav-section">
                    <span>MI CUENTA</span>
                </div>


                {{-- MI PERFIL --}}
                <a
                    href="{{ route('cliente.perfil') }}"
                    class="nav-link {{ request()->routeIs('cliente.perfil*') ? 'active' : '' }}"
                >
                    <span class="nav-icon">◉</span>
                    <span>Mi perfil</span>
                </a>

            @endif



            {{-- =================================================
                 NUTRIÓLOGO / SUPERUSUARIO
            ================================================== --}}
            @if(auth()->user()->esNutriologo())

                <div class="nav-section">
                    <span>CONSULTORIO</span>
                </div>


                {{-- DASHBOARD --}}
                <a
                    href="{{ route('nutriologo.dashboard') }}"
                    class="nav-link {{ request()->routeIs('nutriologo.dashboard') ? 'active' : '' }}"
                >
                    <span class="nav-icon">⌂</span>
                    <span>Dashboard</span>
                </a>


                {{-- CITAS --}}
                <a
                    href="{{ route('nutriologo.citas') }}"
                    class="nav-link {{ request()->routeIs('nutriologo.citas*') ? 'active' : '' }}"
                >
                    <span class="nav-icon">◷</span>
                    <span>Citas</span>
                </a>


                {{-- CLIENTES --}}
                <a
                    href="{{ route('nutriologo.clientes') }}"
                    class="nav-link {{ request()->routeIs('nutriologo.clientes*') || request()->routeIs('nutriologo.formularios.*') ? 'active' : '' }}"
                >
                    <span class="nav-icon">♙</span>
                    <span>Clientes</span>
                </a>


                {{-- PUBLICACIONES --}}
                <a
                    href="{{ route('nutriologo.publicaciones') }}"
                    class="nav-link {{ request()->routeIs('nutriologo.publicaciones*') ? 'active' : '' }}"
                >
                    <span class="nav-icon">▤</span>
                    <span>Publicaciones</span>
                </a>


                {{-- CUENTA --}}
                <div class="nav-section">
                    <span>CUENTA</span>
                </div>


                {{-- PERFIL DEL NUTRIÓLOGO --}}
                <a
                    href="{{ route('nutriologo.perfil') }}"
                    class="nav-link {{ request()->routeIs('nutriologo.perfil*') ? 'active' : '' }}"
                >
                    <span class="nav-icon">◉</span>
                    <span>Mi perfil</span>
                </a>

            @endif



            {{-- =================================================
                 SITIO PÚBLICO
            ================================================== --}}
            <div class="nav-section">
                <span>SITIO</span>
            </div>


            <a
                href="{{ route('inicio') }}"
                class="nav-link"
            >
                <span class="nav-icon">↗</span>
                <span>Ver sitio público</span>
            </a>


        </nav>


        {{-- =====================================================
             CERRAR SESIÓN
        ====================================================== --}}
        <div class="sidebar-footer">

            <form
                action="{{ route('logout') }}"
                method="POST"
            >

                @csrf

                <button
                    type="submit"
                    class="logout-button"
                >

                    <span class="nav-icon">⇥</span>

                    <span>
                        Cerrar sesión
                    </span>

                </button>

            </form>

        </div>


    @else

        {{-- =====================================================
             USUARIO NO AUTENTICADO
        ====================================================== --}}
        <div class="sidebar-guest">

            <a
                href="{{ route('login') }}"
                class="button button-primary"
            >
                Iniciar sesión
            </a>

            <a
                href="{{ route('registro') }}"
                class="button button-secondary"
            >
                Crear cuenta
            </a>

        </div>

    @endauth

</aside>


{{-- =========================================================
     OVERLAY PARA MENÚ MÓVIL
========================================================== --}}
<div
    class="sidebar-overlay"
    id="sidebarOverlay"
></div>