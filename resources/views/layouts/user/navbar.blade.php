<nav class="navbar navbar-expand-md sticky-top" style="margin-bottom: 0;">
    
    <!-- Logo -->
    <ul class="navbar-nav">
        <div class="logotipo">
            <a href="{{ route('welcome') }}">
                <img src="{{ asset('images/rcu-yellow-logo.png') }}" alt="logo" width="195px" height="auto" style="margin-top:10px; margin-bottom:10px; margin-left:10px;">
            </a>
        </div>
    </ul>

    <!-- Icono desplegable del menu en tamaño de pantalla -->
    <button class="navbar-toggler" data-toggle="collapse" data-target="#collapse_target">
        <span class="navbar-toggler-icon"><i class="fa fa-bars" aria-hidden="true" style="color:#e6e6ff; margin-top:5px;"></i></span>
    </button>

    <!-- Opciones de la barra de navegación -->
    <div class="collapse navbar-collapse flex" id="collapse_target">
        <ul class="navbar-nav ml-auto justify-content-end">
            <!-- Menu de Areas de Conocimiento -->
            <li class="navbar-item dropdown">
                <a class="nav-link dropdown-toggle btn-group" data-toggle="dropdown" id="dropdown_target" href="#">
                    {{ __('Ámbitos de Conocimiento')}}
                    <span></span>
                </a>
                <!-- Opciones -->
                <div class="dropdown-menu" id="lineas" arial-labelledby="dropdown_target">
                    <ul class="p-0 scrollable-menu" role="menu">
                    @foreach($conocimientos as $conocimiento)
                        <a class="d-block overflow-hidden" href="{{route('user.conocimiento.articulos', $conocimiento->id_conocimiento)}}">
                            {{  App::isLocale('en') && $conocimiento->nombre_en ? $conocimiento->nombre_en : $conocimiento->nombre }}
                        </a>
                    @endforeach
                    </ul>
                </div>
            </li>

            <!-- Autores -->
            <li class="navbar-item">
                <a class="nav-link"  href="{{ route('user.autores') }}">
                    {{__('Autores')}}
                </a>
            </li>

            <!-- Ediciones -->
            <li class="navbar-item">
                <a class="nav-link" href="{{ route('user.ediciones') }}">
                    {{__('Archivos')}}
                </a>
            </li>

            <!-- Información o Acerca de... -->
            <li class="navbar-item">
                <a class="nav-link" href="{{ route('user.informaciones') }}">
                    {{__('Acerca de...')}}
                </a>
            </li>

            <!-- Buscador -->
            <li class="navbar-item dropdown" id="icons">
                <button class="btn dropdown-toggle" type="button" id="dropdownSearch" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-search fa-fw"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-lg-right" aria-labelledby="dropdownSearch">
                    <form class="px-4 py-3" method="get" action="{{ route('user.search') }}">
                        <input class="input" type="text" name="parametro" placeholder="{{__('Buscar')}}...">
                        <button type="submit" class="btn btn-success">{{__('Buscar')}}</button>
                    </form>
                </div>
            </li>

            <!-- Cambio de Idiomas -->
            <li class="navbar-item dropdown" id="icons">
                <button class="btn dropdown-toggle" type="button" id="dropdownLanguajeButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-globe fa-fw">{{ App::getLocale() }}</i>
                </button>
                <div class="dropdown-menu dropdown-menu-lg-right" aria-labelledby="dropdownLanguajeButton" style="text-align: center;">
                    <a class="dropdown-item" href="{{ route('change.lang', ['locale' => 'es']) }}""> <img src="{{ asset('images/spanish-icon.png') }}" alt="lang" width="16px" height="auto"> {{__('Español')}}</a>
                    <a class="dropdown-item" href="{{ route('change.lang', ['locale' => 'en']) }}"> <img src="{{ asset('images/english-icon.png') }}" alt="lang" width="16px" height="auto"> {{__('Ingles')}}</a>
                </div>
            </li>

            <!-- Usuario Loggueado -->
            @guest
                <!-- Menu de login o Registro -->
                <li class="nav-item dropdown" id="icons">
                    <button class="btn dropdown-toggle" type="button" id="dropdownSingin" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-user-circle fa-fw"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-lg-right" aria-labelledby="dropdownSingin"  style="text-align: center;">
                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#loginModal">{{__('Iniciar Sesión')}}</a>
                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#singinModal">{{__('Registro')}}</a>
                    </div>
                </li>
            @else
                <!-- Botones de Usuario y Cerrar Sesión -->
                <li class="nav-item dropdown">
                    <button class="btn dropdown-toggle" type="button" id="dropdownSingUp" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color:#fff; margin-top:5px;">
                        {{ Auth::user()->name }}
                        <span class="caret">
                    </button>

                    <div class="dropdown-menu dropdown-menu-lg-right" aria-labelledby="dropdownSingUp">

                        @if(Auth::user()->urol->rol->nombre == "Administrador")
                            <a class="dropdown-item" href="{{ route('dashboard') }}">{{__('Panel Administrativo')}}</a>
                        @endif

                        <!-- LOGOUT -->
                        <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                            {{ __('Cerrar Sesión') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>
            @endguest
        </ul>
    </div>
</nav>