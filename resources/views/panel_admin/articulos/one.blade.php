@extends('layouts.admin.app')

@section('content')
<div class="container-fluid">
    
    <!-- TABLA -->
    <div class="card shadow mb-4">
        
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Artículo con sus comentarios</h6>
        </div>

        <div class="card-header" style="border-bottom: 0px; margin-bottom: -1%">
            <!-- EDITAR ARTÍCULO -->
            <a href="{{ route('articulo.edit', $articulo->id_articulo) }}" class="btn btn-primary btn-icon-split">
                <span class="icon text-white-50">
                    <i class="fas fa-pencil"></i>
                </span>
                <span class="text">Editar Artículo</span>
            </a>

            <!-- ELIMINAR ARTÍCULO -->
            <button class="btn btn-danger btn-icon-split btn-delete" name="{{ $articulo->id_articulo }}">
                <span class="icon text-white-50">
                    <i class="fas fa-trash"></i>
                </span>
                <span class="text">Eliminar Artículo</span>
            </button>

            <form id="delete-articulo-{{ $articulo->id_articulo }}" action="{{ route('articulo.delete', $articulo->id_articulo) }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>

        <div class="card-body">

            <div class="row justify-content-center">

                <!-- Artículo -->
                <div class="col-lg-6">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                {{ $articulo->titulo }}
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="text-center">
                                <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" width="100%" height="100%"
                                    src="{{ route('articulo.imagen', ['filename' => basename($articulo->ruta_imagen_es)]) }}" alt="...">
                            </div>
                            <div class="text-center">
                                <h6 class="text-dark">
                                        <hr>
                                    @forelse($articulo->autores as $autor)
                                        <span class="d-block">{{ $autor->autor->nombre }}</span><hr>
                                    @empty
                                        <span>Sin Autor</span>
                                    @endforelse
                                    <div class="d-block">
                                        <span class="badge badge-pill badge-primary">
                                            {{ $articulo->FK_id_conocimiento ? $articulo->conocimiento->nombre : "Sin Area" }}
                                        </span>
                                    </div>
                                </h6>
                            </div>
                            <h6 class="text-dark">
                                <span class="font-weight-bold">Edición</span>:
                                <span id="preEdicion">{{ $articulo->edicion->titulo }}</span>
                            </h6>
                            <p class="text-justify">{{ $articulo->contenido }}</p>
                        </div>
                        <div class="card-footer">
                            <label for="">Archivos del Artículo:</label>
                            <div class="row">
                                <div class="col-12">
                                    @forelse($articulo->archivos as $archivo)
                                        <a href="{{ route('articulo.archivo', ['filename' => basename($archivo->ruta_archivo_es)]) }}" target="_blank" 
                                            class="btn btn-light btn-icon-split mb-1">
                                            <span class="icon text-gray-600" style="width: 50px;">
                                                @switch($archivo->tipo)
                                                    @case('pdf')<i class="fas fa-file-pdf"></i>@break
                                                    @default <i class="fas fa-image"></i>
                                                @endswitch
                                            </span>
                                            <span class="text">{{ $archivo->nombre }}</span>
                                        </a>
                                    @empty
                                        No posee archivos linkeados...
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Comentarios -->
                <div class="col-lg-6">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                COMENTARIOS
                            </h6>
                        </div>
                        <div class="card-body">
                            @if($articulo->comentarios->count() > 0)
                                @include(('layouts.comments'))
                            @else
                                No hay comentarios cargados en el artículo
                            @endif
                        </div>
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
        
        $('.btn-delete').click(function(){
            var id = $(this).attr('name');

            Swal.fire({
                title: 'Estas seguro de elimnar el artículo?',
                text: "No podras revertir esta elección, esto borrara todos los comentarios y archivos anclados al mismo!",
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
                        'El artículo sera procesado para ser eliminada de los registros.',
                        'success'
                    );
                    setTimeout(function() { 
                        $( "#delete-articulo-"+id ).submit();
                    }, 2000);
                }
            });
        });
    });
</script>