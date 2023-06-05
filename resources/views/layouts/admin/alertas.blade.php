
<li class="nav-item dropdown no-arrow mx-1">
    <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-bell fa-fw"></i>
        <!-- Counter - Alerts -->
        <?php $notificaciones = \Auth::user()->notificaciones->whereNull('read_at') ?>
        @if($notificaciones->count() < 3)
            <span class="badge badge-danger badge-counter">{{ $notificaciones->count() }}</span>
        @else
            <span class="badge badge-danger badge-counter">3+</span>
        @endif
    </a>
    <!-- Dropdown - Alerts -->
    <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
        aria-labelledby="alertsDropdown">
        <h6 class="dropdown-header">
            Notificaciones del Sistema
        </h6>

        <!-- notificacion -->
        <?php $cantidad = 0; ?>
        @forelse($notificaciones as $noti)
            @if($cantidad > 2) @break @endif
            <?php $cantidad++; ?>

            <form id="form_red{{$cantidad}}" action="{{ route('notificacion.redireccion') }}" method="post">
                @csrf
                <input type="hidden" name="ruta" value="{{ $noti->notificacion->ruta }}">
                <input type="hidden" name="notificacion" value="{{ $noti->id_usuario_notificacion }}">
                <a class="dropdown-item d-flex align-items-center" onclick="ruta_redireccion('form_red{{$cantidad}}')">
                    <div class="mr-3">
                        <div class="icon-circle bg-primary">
                            <i class="fas {{ $noti->notificacion->icono }} text-white"></i>
                        </div>
                    </div>
                    <div>
                        <!-- Fecha de la Notificación -->
                        <div class="small text-gray-500">
                            {{ date_format(date_create($noti->notificacion->created_at), "F j, Y") }}
                        </div>
                        <!-- Texto Notificación -->
                        <div>
                            {{ $noti->notificacion->titulo }}
                        </div>
                    </div>
                </a>
            </form>
        @empty
            <a class="dropdown-item d-flex align-items-center" href="#">
                No hay notificaciones sin leer...
            </a>
        @endforelse
        <a class="dropdown-item text-center small text-gray-500" href="{{ route('notificacion.index') }}">
            Todas las Notificaciones
        </a>
    </div>
</li>

<script src="{{ asset('jquery/jquery.min.js') }}"></script>
<script>
    function ruta_redireccion(form){
        $('#'+form).submit();
    }
</script>