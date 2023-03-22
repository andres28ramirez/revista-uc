<!------------------------------------------------- NAVBAR ------------------------------------------------------------>
<nav class="navbar navbar-expand-md sticky-top" style="margin-bottom: 0;">
    <!------------------------------------------------- LOGO ------------------------------------------------------------>
        <ul class="navbar-nav">
            <div class="logotipo">
                <a href="{{route('welcome')}}">
                    <img src="{{ asset('images/rcu-yellow-logo.png') }}" alt="logo" width="195px" height="auto" style="margin-top:10px; margin-bottom:10px; margin-left:10px;">
                </a>
            </div>
        </ul>
        <button class="navbar-toggler" data-toggle="collapse" data-target="#collapse_target">
            <span class="navbar-toggler-icon"><i class="fa fa-bars" aria-hidden="true" style="color:#e6e6ff; margin-top:5px;"></i></span>
        </button>

        <div class="collapse navbar-collapse flex" id="collapse_target">
        <!------------------------------------------------- ENLACES ------------------------------------------------------------>
        <ul class="navbar-nav ml-auto justify-content-end">
            <li class="navbar-item dropdown">
                <a class="nav-link dropdown-toggle btn-group" data-toggle="dropdown" id="dropdown_target" href="#">
                    @lang('data.secciones')
                    <!--<span class="caret"></span>-->
                    <span></span>
                </a>
                <div class=" dropdown-menu" id="lineas" arial-labelledby="dropdown_target">
                    <a class="dropdown-item" href="{{url('seccion', ['section' => 'biologia'])}}">@lang('data.biologia')</a>
                    <a class="dropdown-item" href="{{url('seccion', ['section' => 'derecho'])}}">@lang('data.derecho')</a>
                    <a class="dropdown-item" href="{{url('seccion', ['section' => 'economia'])}}">@lang('data.economia')</a>
                    <a class="dropdown-item" href="{{url('seccion', ['section' => 'educacion'])}}">@lang('data.educacion')</a>
                    <a class="dropdown-item" href="{{url('seccion', ['section' => 'epistemologia'])}}">@lang('data.epistemologia')</a>
                    <a class="dropdown-item" href="{{url('seccion', ['section' => 'filosofia'])}}">@lang('data.filosofia')</a>
                    <a class="dropdown-item" href="{{url('seccion', ['section' => 'gerencia'])}}">@lang('data.gerencia')</a>
                </div>
            </li>
            <li class="navbar-item">
                <a class="nav-link"  href="{{route('autores')}}">@lang('data.autores')</a>
            </li>
            <li class="navbar-item">
                <a class="nav-link" href="{{route('edicion')}}">@lang('data.ediciones')</a>
            </li>
            <li class="navbar-item">
                <a class="nav-link" href="{{route('informacion')}}">@lang('data.contacto')</a>
            </li>
            <!------------------------------------------------- BUSCADOR ------------------------------------------------------------>
            <li class="navbar-item dropdown" id="icons">
                <button class="btn dropdown-toggle" type="button" id="dropdownSearch" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-search fa-fw"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-lg-right" aria-labelledby="dropdownSearch" style="aling-items: center;">
                    <form class="px-4 py-3" type="get" action=" {{route('search')}} ">
                        <input class="input" type="text" name="query" placeholder="@lang('data.buscar')...">
                        <button type="button" class="btn btn-success">@lang('data.buscar')</button>
                    </form>
                </div>

            </li>
            <!------------------------------------------------- ICONOS DE IDIOMAS ------------------------------------------------------------>
            <li class="navbar-item dropdown" id="icons">
                <button class="btn dropdown-toggle" type="button" id="dropdownLanguajeButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-globe fa-fw">{{ App::getLocale() }}</i>
                </button>
                <div class="dropdown-menu dropdown-menu-lg-right" aria-labelledby="dropdownLanguajeButton" style="text-align: center;">
                    <a class="dropdown-item" href="{{url('lang', ['locale' => 'es'])}}"> <img src="{{ asset('images/spanish-icon.png') }}" alt="lang" width="16px" height="auto"> @lang('data.español')</a>
                    <a class="dropdown-item" href="{{url('lang', ['locale' => 'en'])}}"> <img src="{{ asset('images/english-icon.png') }}" alt="lang" width="16px" height="auto"> @lang('data.ingles')</a>
                </div>
            </li>
            <!------------------------------------------------- USUARIO ------------------------------------------------------------>
            @guest
            <li class="nav-item dropdown" id="icons">
                <button class="btn dropdown-toggle" type="button" id="dropdownSingin" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-user-circle fa-fw"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-lg-right" aria-labelledby="dropdownSingin"  style="text-align: center;">
                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#loginModal">@lang('data.iniciar_sesion')</a>
                </div>
            </li>

            @else
            <li class="nav-item dropdown">
                <button class="btn dropdown-toggle" type="button" id="dropdownSingUp" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color:#fff; margin-top:5px;">
                    {{ Auth::user()->name }}
                    <span class="caret">
                </button>

                <div class="dropdown-menu dropdown-menu-lg-right" aria-labelledby="dropdownSingUp">

                    @hasrole('Admin')
                        <a class="dropdown-item" href="{{ route('admin') }}">Panel de Administrador</a>
                    @endhasrole

                    @hasrole('comment_admin')
                        <a class="dropdown-item" href="{{ route('admin') }}">Panel de Administrador</a>
                    @endhasrole

                        <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
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