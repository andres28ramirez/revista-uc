@extends('layouts.admin.app')

@section('content')
<div class="container-fluid">
    
    <!-- TABLA -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                {{ $info->tipo == "comentario" ? "Edición de Comentario" : "Edición de Respuesta" }}
            </h6>
        </div>

        <div class="card-body">

            <!-- ELIMINAR COMENTARIO -->
            <div class="card-header" style="border-bottom: 0px;">
                <button name="{{ $info->id }}" class="info-delete btn btn-danger btn-icon-split">
                    <span class="icon text-white-50">
                        <i class="fas fa-trash"></i>
                    </span>
                    <span class="text">Eliminar {{ $info->tipo == "comentario" ? "Comentario" : "Respuesta" }}</span>
                </button>
                <form id="info-delete-{{ $info->id  }}" action="{{ $info->tipo == 'comentario' ? route('comentario.delete', $info->id) : route('respuesta.delete', $info->id) }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>

            <!-- EDITAR COMENTARIO -->
            <div class="card-header" style="border-bottom: 0px;">
                <form class="form-inline" action="{{ $info->tipo == 'comentario' ? route('comentario.update', $info->id) : route('respuesta.update', $info->id) }}" method="POST">
                    @csrf

                    <!-- Estado -->
                    <div class="form-group">
                        <label for="estado" class="mb-2 mr-sm-2">Cambia el estado del comentario:</label>
                        <select id="estado" class="mb-2 mr-sm-2 form-control @error('estado') is-invalid @enderror" name="estado">
                            <option value="aceptado" {{ old('estado', 'aceptado') == $info->estado ? "selected" : ""}}>Aceptado</option>
                            <option value="pendiente" {{ old('estado', 'pendiente') == $info->estado ? "selected" : ""}}>Pendiente</option>
                            <option value="rechazado" {{ old('estado', 'rechazado') == $info->estado ? "selected" : ""}}>Rechazado</option>
                        </select>
                        
                        @error('estado')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <button class="mb-2 mr-sm-2 form-control btn btn-primary">
                        Editar {{ $info->tipo == "comentario" ? "Comentario" : "Respuesta" }}
                    </button>
                </form>
            </div>

            <!-- TABLA CON EL CONTENIDO DE COMENTARIOS-->
            <div class="row container">
                
                <!-- COMENTARIO O RESPUESTA -->
                <div class="container col-12">
                    <div class="card shadow mb-4">
                        <!-- Comentario -->
                        <a href="#respuestas_comment" class="d-block card-header py-3" data-toggle="collapse"
                            role="button" aria-expanded="true" aria-controls="collapseCardExample">
                            <!-- Contenido del Comentario -->
                            <h6 class="m-0 font-weight-bold text-primary">
                                {{ $info->autor }} - {{ FormatTime::LongTimeFilter($info->created_at) }}
                                @switch($info->estado)
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
                                    {{ $info->estado }}
                                </span> 
                            </h6>
                            <span class="text-xs mt-1">
                                {{ $info->tipo == "comentario" ? $info->articulo->titulo : $info->comentario->articulo->titulo }}
                            </span>
                        </a>
                        
                        <div class="card-body row container">
                            <div class="col-12">
                                {{ $info->contenido }}
                            </div>
                        </div>

                        <!-- Respuestas del Comentario -->
                        @if($info->respuestas)
                            <div class="collapse" id="respuestas_comment">
                                <div class="card-header text-center mb-2">
                                    Respuestas al Comentario
                                </div>
                                @foreach($info->respuestas as $respuesta)
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
                                            </h6>
                                            {{ $respuesta->contenido }}
                                        </div>
                                    </li>
                                </ul>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                <!-- USUARIO DEL COMENTARIO -->
                <div class="card shadow mb-4 col-lg-6">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Autor del Comentario</h6>
                    </div>
                    <div class="card-body">
                        <!-- Nombre -->
                        <h6>    
                            <span class="font-weight-bold">Nombre del Usuario: </span>
                            {{$info->usuario->perfil->nombre." ".$info->usuario->perfil->apellido}}
                        </h6>

                        <!-- Tipo de Usuario -->
                        <h6>    
                            <span class="font-weight-bold">Tipo de Usuario: </span>
                            {{$info->usuario->perfil->tipo ? $info->usuario->perfil->tipo->nombre : "Es usuario administrativo"}}
                        </h6>
                        
                        <!-- Correo -->
                        <h6>    
                            <span class="font-weight-bold">Correo: </span>
                            {{$info->usuario->email}}
                        </h6>

                        <!-- Telefono -->
                        <h6>    
                            <span class="font-weight-bold">Teléfono: </span>
                            {{$info->usuario->telefono ? $info->usuario->telefono : "No posee teléfono registrado"}}
                        </h6>

                        <!-- Dirección -->
                        <h6>    
                            <span class="font-weight-bold">Dirección de Hogar: </span>
                            {{$info->usuario->direccion ? $info->usuario->direccion : "No posee dirección registrada"}}
                        </h6>
                    </div>
                </div>
                
                <!-- ARTICULO -->
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
            </div>

        </div>
    </div>

</div>

@endsection

<script src="{{ asset('jquery/jquery.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        //click para eliminar comentario o respuesta
        $('.info-delete').click(function(){
            var id = $(this).attr('name');

            Swal.fire({
                title: 'Estas seguro de elimnar el comentario seleccionado?',
                text: "No podras revertir esta elección, esto eliminara el comentario junto a las respuestas ancladas al mismo!",
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
                        $( "#info-delete-"+id ).submit();
                    }, 2000);
                }
            });
        });
    });
</script>