<nav class="navbar navbar-expand-md sticky-top" style="margin-bottom: 0;">
    
    <!-- Logo -->
    <ul class="navbar-nav">
        <div class="logotipo">
            <a href="{{ route('welcome') }}">
                <img src="{{ asset('images/rcu-yellow-logo.png') }}" alt="logo" width="195px" height="auto" style="margin-top:10px; margin-bottom:10px; margin-left:10px;">
            </a>
        </div>
    </ul>

    <button class="navbar-toggler" data-toggle="collapse" data-target="#collapse_target">
        <span class="navbar-toggler-icon"><i class="fa fa-bars" aria-hidden="true" style="color:#e6e6ff; margin-top:5px;"></i></span>
    </button>

    <div class="collapse navbar-collapse flex" id="collapse_target">
        <ul class="navbar-nav ml-auto justify-content-end">
            <li class="navbar-item dropdown">
                <a class="nav-link dropdown-toggle btn-group" data-toggle="dropdown" id="dropdown_target" href="#">
                    {{ __('Ámbitos de Conocimiento')}}
                    <span></span>
                </a>
                <div class=" dropdown-menu" id="lineas" arial-labelledby="dropdown_target">
                    <a class="dropdown-item" href="#">{{__('Biología')}}</a>
                    <a class="dropdown-item" href="#">{{__('Derecho')}}</a>
                    <a class="dropdown-item" href="#">{{__('Economía')}}</a>
                    <a class="dropdown-item" href="#">{{__('Educación')}}</a>
                    <a class="dropdown-item" href="#">{{__('Epistemologia')}}</a>
                    <a class="dropdown-item" href="#">{{__('Filosofía')}}</a>
                    <a class="dropdown-item" href="#">{{__('Gerencia')}}</a>
                </div>
            </li>

            <li class="navbar-item">
                <a class="nav-link"  href="#">{{__('Autores')}}</a>
            </li>

            <li class="navbar-item">
                <a class="nav-link" href="#">{{__('Listado de Ediciones')}}</a>
            </li>

            <li class="navbar-item">
                <a class="nav-link" href="#">{{__('Información')}}</a>
            </li>

            <!-- Buscador -->
            <li class="navbar-item dropdown" id="icons">
                <button class="btn dropdown-toggle" type="button" id="dropdownSearch" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-search fa-fw"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-lg-right" aria-labelledby="dropdownSearch">
                    <form class="px-4 py-3" type="get" action="">
                        <input class="input" type="text" name="query" placeholder="{{__('Buscar')}}...">
                        <button type="button" class="btn btn-success">{{__('Buscar')}}</button>
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