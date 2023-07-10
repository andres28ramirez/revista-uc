@extends('layouts.admin.app')

@section('title')
{{ "Comentarios" }}
@endsection

@section('content')
<div class="container-fluid">
    
    <!-- TABLA -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Información general y los ultimos 10 comentarios cargados</h6>
        </div>

        <div class="card-body">

            <!-- GLOBAL CON TOTALES -->
            <div class="row justify-content-center">

                <!-- COMENTARIOS ACEPTADOS -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card shadow h-100 py-2 border-left-success">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Nro. Comentarios Aceptados</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        {{ $comentarios ? $comentarios->where('estado', 'aceptado')->count() : "0" }}
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-check fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- COMENTARIOS PENDIENTES -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card shadow h-100 py-2 border-left-primary">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Nro. Comentarios Pendientes</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        {{ $comentarios ? $comentarios->where('estado', 'pendiente')->count() : "0" }}
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-list-check fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- COMENTARIOS RECHAZADOS -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card shadow h-100 py-2 border-left-danger">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Nro. Comentarios Rechazados</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        {{ $comentarios ? $comentarios->where('estado', 'rechazado')->count() : "0" }}
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-ban fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TOTAL DE COMENTARIOS -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card shadow h-100 py-2 border-left-info">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Total de Comentarios Enviados</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        {{ $comentarios ? $comentarios->count() : "0" }}
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-comment fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>

            <!-- VER TODOS LOS COMENTARIOS Y RESPUESTAS -->
            <div class="card-header" style="border-bottom: 0px;">
                <a href="{{ route('comentario.all') }}" class="btn btn-primary btn-icon-split">
                    <span class="icon text-white-50">
                        <i class="fas fa-eye"></i>
                    </span>
                    <span class="text">Ver todos los Comentarios y Respuestas</span>
                </a>
            </div>

            <!-- TABLA CON EL CONTENIDO DE COMENTARIOS-->
            <div class="row container">
                <!-- USUARIOS CON MÁS COMENTARIOS -->
                <div class="card shadow mb-4 col-lg-6">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Top 5 Usuarios con más comentarios</h6>
                    </div>
                    <div class="card-body">
                        @forelse($usuarios as $usuario)
                            <h4 class="small font-weight-bold">{{ $usuario->usuario->name }} <span
                                    class="float-right">{{ $usuario->total }}</span></h4>
                            <div class="progress mb-4">
                                <div class="progress-bar bg-gradient-secondary" role="progressbar" 
                                    style="width: <?php echo $comentarios->count() ? $usuario->total * 100 / $comentarios->count() : '0' ?>%"
                                    aria-valuenow="{{ $usuario->total || $comentarios->count() ? $usuario->total * 100 / $comentarios->count() : '0' }}" 
                                    aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        @empty
                            <p>No hay comentarios cargados actualmente...</p>
                        @endforelse
                    </div>
                </div>
                
                <!-- ARTICULO CON MAS COMENTARIOS -->
                <div class="col-lg-6">
                    <div class="card shadow mb-4 ">
                        @if($articulo)
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">
                                    {{ $articulo->titulo }}
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="text-center">
                                    <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" width="70%" height="70%"
                                        src="{{ route('articulo.imagen', ['filename' => basename($articulo->ruta_imagen_es)]) }}" alt="...">
                                </div>
                                <div class="text-center">
                                    <h6 class="text-dark">
                                        <span>{{ $articulo->FK_id_autor ? $articulo->autor->nombre : "Sin Autor" }}</span> - 
                                        <span class="badge badge-pill badge-primary">
                                            {{ $articulo->FK_id_conocimiento ? $articulo->conocimiento->nombre : "Sin Area" }}
                                        </span>
                                    </h6>
                                </div>
                                <h6 class="text-dark">
                                    <span class="font-weight-bold">Edición</span>:
                                    <span id="preEdicion">{{ $articulo->edicion->titulo }}</span>
                                </h6>
                                <p class="text-justify">
                                    {{ substr($articulo->contenido, 0, 100) }}...
                                </p>
                                <div class="d-block">
                                    <button class="btn btn-info btn-circle">
                                        <i class="fas fa-comment"></i>
                                    </button>
                                    {{ $articulo->comentarios->count() }} Comentarios
                                </div>
                                <div class="d-block text-center">
                                    <a href="{{ route('articulo.view', $articulo->id_articulo) }}">
                                        Abrir Artículo &rarr;
                                    </a>
                                </div>
                            </div>
                        @else
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">
                                    No hay artículos con comentarios aun...
                                </h6>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- TABLA CON LOS COMENTARIOS -->
                <div class="container col-12">
                    <div class="">
                        <h5>Ultimos 10 Comentarios enviados en la plataforma</h5>
                        <hr>
                    </div>

                    @forelse($comentarios as $key => $comentario)
                        @if ($key > 9) @break @endif
                        
                        <div class="card shadow mb-4">
                            <!-- Comentario -->
                            <a href="#respuesta_{{$key}}" class="d-block card-header py-3" data-toggle="collapse"
                                role="button" aria-expanded="true" aria-controls="collapseCardExample">
                                <!-- Contenido del Comentario -->
                                <h6 class="m-0 font-weight-bold text-primary">
                                    {{ $comentario->autor }} - {{ FormatTime::LongTimeFilter($comentario->created_at) }}
                                    @switch($comentario->estado)
                                        @case('rechazado')
                                            <span class="badge badge-pill badge-danger">
                                        @break
                                        @case('aceptado') 
                                            <span class="badge badge-pill badge-success">
                                        @break
                                        @default 
                                            <span class="badge badge-pill badge-primary">
                                        @break
                                    @endswitch
                                        {{ $comentario->estado }}
                                    </span> 
                                </h6>
                                <span class="text-xs mt-1">{{ $comentario->articulo->titulo }}</span>
                            </a>
                            
                            <div class="card-body row container">
                                <div class="col-10">
                                    {{ $comentario->contenido }}
                                </div>
                                <div class="col-2">
                                    <!-- Boton de Editar -->
                                    <a href="{{ route('comentario.edit', $comentario->id_comentario) }}" 
                                        class="edit_comentario btn btn-info btn-circle btn-sm">
                                        <i class="fas fa-pencil"></i>
                                    </a>

                                    <!-- Boton de Eliminar -->
                                    <button name="{{ $comentario->id_comentario  }}" class="btn btn-danger btn-circle btn-sm comentario-delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    <form id="comentario-delete-{{ $comentario->id_comentario  }}" action="{{ route('comentario.delete', $comentario->id_comentario) }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </div>

                            <!-- Respuestas del Comentario -->
                            @if($comentario->respuestas->count() > 0)
                            <div class="collapse" id="respuesta_{{$key}}">
                                <div class="card-header text-center mb-2">
                                    Respuestas al Comentario
                                </div>
                                @foreach($comentario->respuestas as $respuesta)
                                <ul>
                                    <li>
                                        <div class="card-body py-0">
                                            <h6 class="m-0">
                                                <span class="font-weight-bold">{{ $respuesta->nombre }}</span> - {{ FormatTime::LongTimeFilter($respuesta->created_at) }}
                                                @switch($respuesta->estado)
                                                    @case('rechazado')
                                                        <span class="badge badge-pill badge-danger">
                                                    @break
                                                    @case('aceptado') 
                                                        <span class="badge badge-pill badge-success">
                                                    @break
                                                    @default 
                                                        <span class="badge badge-pill badge-primary">
                                                    @break
                                                @endswitch
                                                    {{ $respuesta->estado }}
                                                </span> 

                                                <!-- Boton de Editar -->
                                                <a href="{{ route('respuesta.edit', $respuesta->id_respuesta) }}"  
                                                    class="edit_respuesta btn btn-info btn-circle btn-sm">
                                                    <i class="fas fa-pencil"></i>
                                                </a>

                                                <!-- Boton de Eliminar -->
                                                <button name="{{ $respuesta->id_respuesta }}" class="btn btn-danger btn-circle btn-sm respuesta-delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                                <form id="respuesta-delete-{{ $respuesta->id_respuesta  }}" action="{{ route('respuesta.delete', $respuesta->id_respuesta) }}" method="POST" style="display: none;">
                                                    @csrf
                                                </form>
                                            </h6>
                                            {{ $respuesta->contenido }}
                                        </div>
                                    </li>
                                </ul>
                                @endforeach
                            </div>
                            @endif
                        </div>
                    @empty
                        <div class="text-center">
                            No hay comentarios en el sistema en estos momentos...
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>

</div>

@endsection

<script src="{{ asset('jquery/jquery.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        //click para eliminar comentario
        $('.comentario-delete').click(function(){
            var id = $(this).attr('name');

            Swal.fire({
                title: 'Estas seguro de elimnar el comentario seleccionado?',
                text: "No podras revertir esta elección, esto eliminara el comentario junto a las respuestas del mismo!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#084456',
                cancelButtonColor: '#bbbbbb',
                confirmButtonText: 'Si, eliminalo!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire(
                        'Eliminando!',
                        'El comentario sera procesado para ser eliminado de los registros.',
                        'success'
                    );
                    setTimeout(function() { 
                        $( "#comentario-delete-"+id ).submit();
                    }, 2000);
                }
            });
        });

        //click para eliminar respuesta
        $('.respuesta-delete').click(function(){
            var id = $(this).attr('name');

            Swal.fire({
                title: 'Estas seguro de elimnar la respuesta?',
                text: "No podras revertir esta elección!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#084456',
                cancelButtonColor: '#bbbbbb',
                confirmButtonText: 'Si, eliminalo!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire(
                        'Eliminando!',
                        'La respuesta sera procesada para ser eliminada de los registros.',
                        'success'
                    );
                    setTimeout(function() { 
                        $( "#respuesta-delete-"+id ).submit();
                    }, 2000);
                }
            });
        });
    });
</script>