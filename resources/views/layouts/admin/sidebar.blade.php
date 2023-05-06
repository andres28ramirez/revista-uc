<ul class="navbar-nav sidebar sidebar-dark accordion" style="background-color: #084456;" id="accordionSidebar">

    <!-- Sidebar - Marca -->
    <a class="sidebar-brand d-flex justify-content-center" style="height: auto" href="{{ route('dashboard') }}">
        <div class="d-block">
            <img src="{{asset('images/rcu-orange-isotype.png')}}" 
                style="width: 100%"
                class="img-fluid ${3|rounded-top,rounded-right,rounded-bottom,rounded-left,rounded-circle,|}" 
                alt="icono de unimar científica">
        </div>
        <div class="sidebar-brand-text mx-3 my-auto">Unimar Científica</div>
    </a>

    <!-- Divisor -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ request()->is('*/dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Panel Inicial</span></a>
    </li>

    <!-- Divisor -->
    <hr class="sidebar-divider">

    <!-- Titulo de Nav Items -->
    <div class="sidebar-heading">
        Ediciones y Artículos
    </div>

    <!-- Nav Item - Ediciones -->
    <li class="nav-item {{ request()->is('*/edicion') || request()->is('*/edicion/*') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
            aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-book"></i>
            <span>Ediciones</span>
        </a>
        <div id="collapseTwo" class="collapse {{ request()->is('*/edicion') || request()->is('*/edicion/*') ? 'show' : '' }}" 
            aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item {{ request()->is('*/edicion') ? 'active' : '' }}" href="{{ route('edicion.index') }}">Ver Ediciones</a>
                <a class="collapse-item {{ request()->is('*/edicion/create') ? 'active' : '' }}" href="{{ route('edicion.create') }}">Crear Nueva Edición</a>
                <a class="collapse-item {{ request()->is('*/edicion/stats') ? 'active' : '' }}" href="cards.html">Estadísticas</a>
                <a class="collapse-item {{ request()->is('*/edicion/conocimiento') ? 'active' : '' }}" href="{{ route('edicion.conocimiento') }}">Area de Conocimiento</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Artículos -->
    <li class="nav-item {{ request()->is('*/articulos') || request()->is('*/articulos/*') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
            aria-expanded="true" aria-controls="collapseUtilities">
            <i class="fas fa-fw fa-solid fa-newspaper"></i>
            <span>Artículos</span>
        </a>
        <div id="collapseUtilities" class="collapse {{ request()->is('*/articulos') || request()->is('*/articulos/*') || request()->is('*/autor') || request()->is('*/autor/*') ? 'show' : '' }}" aria-labelledby="headingUtilities"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item {{ request()->is('*/articulos') || request()->is('*/articulos/todos') ? 'active' : '' }}" href="{{ route('articulo.index') }}">Ver Artículos</a>
                <a class="collapse-item {{ request()->is('*/articulos/create') ? 'active' : '' }}" href="{{ route('articulo.create') }}">Crear Artículo</a>
                <a class="collapse-item {{ request()->is('*/autor') || request()->is('*/autor/*') ? 'active' : '' }}" href="{{ route('autor.index') }}">Autores</a>
                <a class="collapse-item" href="utilities-animation.html">Estadísticas</a>
                <a class="collapse-item {{ request()->is('*/comentario') || request()->is('*/comentario/*') || request()->is('*/respuesta/*') ? 'active' : '' }}" href="{{ route('comentario.index') }}">Ultimos Comentarios</a>
                <a class="collapse-item {{ request()->is('*/archivo') || request()->is('*/archivo/*') ? 'active' : '' }}" href="{{ route('archivo.index') }}">Documentos o Archivos</a>
            </div>
        </div>
    </li>

    <!-- Divisor -->
    <hr class="sidebar-divider">

    <!-- Titulo de Nav Items -->
    <div class="sidebar-heading">
        Usuarios y Config.
    </div>

    <!-- Nav Item - Usuarios -->
    <li class="nav-item {{ request()->is('*/usuarios') || request()->is('*/usuarios/*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('usuario.index') }}">
            <i class="fas fa-fw fa-users"></i>
            <span>Usuarios</span></a>
    </li>

    <!-- Nav Item - Configuraciones -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseConfig"
            aria-expanded="true" aria-controls="collapseConfig">
            <i class="fas fa-fw fa-wrench"></i>
            <span>Configuración</span>
        </a>
        <div id="collapseConfig" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="login.html">Roles</a>
                <a class="collapse-item" href="login.html">Tipos de Usuario</a>
                <a class="collapse-item" href="login.html">Módulos</a>
                <a class="collapse-item" href="register.html">Información Editable</a>
                <a class="collapse-item" href="forgot-password.html">Banners o Carrousels</a>
            </div>
        </div>
    </li>

    <!-- Divisor -->
    <hr class="sidebar-divider">

    <!-- Nav Item - Reportes -->
    <li class="nav-item">
        <a class="nav-link" href="tables.html">
            <i class="fas fa-fw fa-bell"></i>
            <span>Notificaciones</span></a>
    </li>

    <!-- Nav Item - Graficos y Estadisticas -->
    <li class="nav-item">
        <a class="nav-link" href="charts.html">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Estadísticas Generales</span></a>
    </li>

    <!-- Nav Item - Reportes -->
    <li class="nav-item">
        <a class="nav-link" href="tables.html">
            <i class="fas fa-fw fa-table"></i>
            <span>Generador de Reportes</span></a>
    </li>

    <!-- Divisor -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>