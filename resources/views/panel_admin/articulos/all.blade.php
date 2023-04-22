@extends('layouts.admin.app')

@section('content')
<div class="container-fluid">
    
    <!-- TABLA -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Artículos Cargados</h6>
        </div>

        <!-- CREAR NUEVA EDICIÓN -->
        <div class="card-header py-3" style="border-bottom: 0px;">
            <a href="{{ route('articulo.create') }}" class="btn btn-success btn-icon-split">
                <span class="icon text-white-50" style="padding: 0.75rem 0.75rem;">
                    <i class="fas fa-plus"></i>
                </span>
                <span class="text">Crear un nuevo Artículo</span>
            </a>
        </div>

        <div class="card-body">
            <!-- TABLA CON EL CONTENIDO DE EDICIONES -->
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Imagen</th>
                            <th>Título</th>
                            <th>Edición</th>
                            <th>Autor</th>
                            <th>Area</th>
                            <th>Fecha de Publicación</th>
                            <th>Nro. de Comentarios</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($articulos as $articulo)
                        <tr class="text-center">
                            <td class="align-middle">
                                <div class="text-center m-auto" >
                                    <img class="img-fluid img-thumbnail" 
                                    src="{{ route('articulo.imagen', ['filename' => basename($articulo->ruta_imagen_es)]) }}" 
                                    alt="previsual de la edición" width="100%" height="100%">
                                </div>
                            </td>
                            <td class="align-middle">
                                {{ $articulo->titulo }}
                            </td>
                            <td class="align-middle">
                                {{ $articulo->edicion->titulo }}
                            </td>
                            <td class="align-middle">
                                {{ $articulo->FK_id_autor ? $articulo->autor->nombre : "Sin Autor" }}
                            </td>
                            <td class="align-middle">
                                {{ $articulo->FK_id_conocimiento ? $articulo->conocimiento->nombre : "Sin Area" }}
                            </td>
                            <td class="align-middle">
                                {{ date_format(date_create($articulo->created_at), "F j, Y") }}
                            </td>
                            <td class="align-middle">
                                <a href="#" class="btn btn-warning btn-icon-split">
                                    <span class="icon text-white font-weight-bold">
                                        {{ $articulo->comentarios->count() }}
                                    </span>
                                    <span class="text">
                                        <i class="fas fa-comment"></i>
                                    </span>
                                </a>
                            </td>
                            <td class="align-middle">
                                <a href="{{ route('articulo.view', $articulo->id_articulo) }}" class="btn btn-success btn-circle btn-sm">
                                    <i class="fas fa-eye"></i>
                                </a>

                                <a href="{{ route('articulo.edit', $articulo->id_articulo) }}" class="btn btn-info btn-circle btn-sm">
                                    <i class="fas fa-pencil"></i>
                                </a>

                                <!-- Boton de Eliminar -->
                                <button name="{{ $articulo->id_articulo }}"
                                    class="btn btn-danger btn-circle btn-sm btn-delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                                <form id="delete-articulo-{{ $articulo->id_articulo }}" action="{{ route('articulo.delete', $articulo->id_articulo) }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
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
                title: 'Estas seguro de elimnar la edición?',
                text: "No podras revertir esta elección, esto borrara todos los artículos anclados a la edición!",
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
                        'La edición sera procesada para ser eliminada de los registros.',
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