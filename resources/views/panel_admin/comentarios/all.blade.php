@extends('layouts.admin.app')

@section('title')
{{ "Comentarios" }}
@endsection

@section('content')
<div class="container-fluid">

    <!-- TABLA -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Comentarios Cargados en el Sistema</h6>
        </div>

        <!-- REINICIAR FILTROS DE BUSQUEDA -->
        @if($filtrado)
            <div class="card-header pb-0" style="border-bottom: 0px;">
                <a href="{{ route('comentario.all') }}" class="btn btn-secondary btn-sm btn-icon-split">
                    <span class="icon text-white-50" style="padding: 0.75rem 0.75rem;">
                        <i class="fas fa-rotate-left"></i>
                    </span>
                    <span class="text">Eliminar filtros de busqueda</span>
                </a>
            </div>
        @endif

        <!-- FILTRO DE BUSQUEDA -->
        <div class="card-body pb-0">
            <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#filtradoModal">
                Aplicar Filtros de Busqueda
            </button>
            @if($filtrado)
                <label for="">
                    Filtro de Busqueda Aplicado por:
                    @if($id_usuario)<span class="font-weight-bold text-primary"> Usuario /</span>@endif
                    @if($id_articulo)<span class="font-weight-bold text-primary"> Articulo /</span>@endif
                    @if($id_estado)<span class="font-weight-bold text-primary"> Estado</span>@endif
                </label>
            @else
                <label for="">
                    No hay filtros aplicados en el reporte de la tabla...
                </label>
            @endif
        </div>

        <div class="card-body">
            <!-- TABLA CON EL CONTENIDO DE COMENTARIOS-->
            <div class="row container">
                <!-- TABLA CON LOS COMENTARIOS -->
                <div class="container col-12">
                    @forelse($comentarios as $key => $comentario)
                        
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
                            No hay comentarios en el sistema o bajo el filtro seleccionado...
                        </div>
                    @endforelse
                    {{ $comentarios->links() }}
                </div>
            </div>

        </div>
    </div>

</div>
<input type="hidden" id="link_dir" value="{{ route('comentario.all') }}">

<!-- Modal para filtrar la información -->
<div class="modal fade" id="filtradoModal" tabindex="-1" role="dialog" aria-labelledby="filtradoModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="filtradoModalLongTitle">Selecciona el filtrado para la Tabla</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Usuarios -->
                <div class="form-group">
                    <label for="autor_filter">Selecciona un Usuario: Opcional*</label>
                    <select id="autor_filter" class="form-control" name="id_autor">
                        <option value="0">Selecciona un Usuario a filtrar...</option>
                        @foreach($usuarios as $usuario)
                            <option value="{{ $usuario->id }}" {{ $id_usuario == $usuario->id ? "selected" : ""}}>{{ $usuario->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Artículos -->
                <div class="form-group">
                    <label for="articulo_filter">Selecciona un Artículo: Opcional*</label>
                    <select id="articulo_filter" class="form-control" name="id_estado">
                        <option value="0">Selecciona un Artículo a filtrar...</option>
                        @foreach($articulos as $articulo)
                            <option value="{{ $articulo->id_articulo }}" {{ $id_articulo == $articulo->id_articulo ? "selected" : ""}}>{{ $articulo->titulo }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Estado del Comentario -->
                <div class="form-group">
                    <label for="estado_filter">Selecciona un Estado de Comentario: Opcional*</label>
                    <select id="estado_filter" class="mb-2 mr-sm-2 form-control @error('id_estado') is-invalid @enderror" name="id_estado">
                        <option value="0" {{ old('id_estado') == $id_estado ? "selected" : ""}}>Selecciona una Opción...</option>
                        <option value="aceptado" {{ old('id_estado', 'aceptado') == $id_estado ? "selected" : ""}}>Aceptado</option>
                        <option value="pendiente" {{ old('id_estado', 'pendiente') == $id_estado ? "selected" : ""}}>Pendiente</option>
                        <option value="rechazado" {{ old('id_estado', 'rechazado') == $id_estado ? "selected" : ""}}>Rechazado</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="filter_button" class="btn btn-secondary">Aplicar Filtro</button>
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

        //Filtrat Tabla de Artículos
        $('#filter_button').click(function(){
            let link = $('#link_dir').val();
            let autor = $('#autor_filter option:selected').val();
            let articulo = $('#articulo_filter option:selected').val();
            let estado = $('#estado_filter option:selected').val();
            
            location.href = link+"/"+autor+"/"+articulo+"/"+estado;
        });
    });
</script>