@extends('layouts.admin.app')

@section('content')
<div class="container-fluid">
    
    <!-- TABLA -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Artículos Cargados</h6>
        </div>

        <!-- REINICIAR FILTROS DE BUSQUEDA -->
        @if($filtrado)
        <div class="card-header pb-0" style="border-bottom: 0px;">
            <a href="{{ route('articulo.all') }}" class="btn btn-secondary btn-sm btn-icon-split">
                <span class="icon text-white-50" style="padding: 0.75rem 0.75rem;">
                    <i class="fas fa-rotate-left"></i>
                </span>
                <span class="text">Eliminar filtros de busqueda</span>
            </a>
        </div>
        @endif

        <!-- CREAR NUEVA EDICIÓN -->
        <div class="card-header pb-0" style="border-bottom: 0px;">
            <a href="{{ route('articulo.create') }}" class="btn btn-success btn-sm btn-icon-split">
                <span class="icon text-white-50" style="padding: 0.75rem 0.75rem;">
                    <i class="fas fa-plus"></i>
                </span>
                <span class="text">Crear un nuevo Artículo</span>
            </a>
        </div>

        <!-- FILTRO DE BUSQUEDA -->
        <div class="card-body pb-0">
            <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#filtradoModal">
                Aplicar Filtros de Busqueda
            </button>
            @if($filtrado)
                <label for="">
                    Filtro de Busqueda Aplicado por:
                    @if($id_autor)<span class="font-weight-bold text-primary"> Autor /</span>@endif
                    @if($id_conocimiento)<span class="font-weight-bold text-primary"> Conocimiento /</span>@endif
                    @if($id_edicion)<span class="font-weight-bold text-primary"> Edición</span>@endif
                </label>
            @else
                <label for="">
                    No hay filtros aplicados en el reporte de la tabla...
                </label>
            @endif
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
<input type="hidden" id="link_dir" value="{{ route('articulo.all') }}">

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
                <!-- Autor del Artículo -->
                <div class="form-group">
                    <label for="autor_filter">Selecciona un Autor: Opcional*</label>
                    <select id="autor_filter" class="form-control" name="id_autor">
                        <option value="0">Selecciona un Autor a filtrar...</option>
                        @foreach($autores as $autor)
                            <option value="{{ $autor->id_autor }}" {{ $id_autor == $autor->id_autor ? "selected" : ""}}>{{ $autor->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Area de Conocimiento -->
                <div class="form-group">
                    <label for="area_filter">Selecciona un Área de Conocimiento: Opcional*</label>
                    <select id="area_filter" class="form-control" name="id_conocimiento">
                        <option value="0">Selecciona un Área a filtrar...</option>
                        @foreach($areas as $area)
                            <option value="{{ $area->id_conocimiento }}" {{ $id_conocimiento == $area->id_conocimiento ? "selected" : ""}}>{{ $area->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Ediciones -->
                <div class="form-group">
                    <label for="edicion_filter">Selecciona una Edición: Opcional*</label>
                    <select id="edicion_filter" class="form-control" name="id_edicion">
                        <option value="0">Selecciona una Edición a filtrar...</option>
                        @foreach($ediciones as $edicion)
                            <option value="{{ $edicion->id_edicion }}" {{ $id_edicion == $edicion->id_edicion ? "selected" : ""}}>{{ $edicion->titulo }}</option>
                        @endforeach
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
        
        //Eliminar artículo
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

        //Filtrat Tabla de Artículos
        $('#filter_button').click(function(){
            let link = $('#link_dir').val();
            let autor = $('#autor_filter option:selected').val();
            let area = $('#area_filter option:selected').val();
            let edicion = $('#edicion_filter option:selected').val();
            
            location.href = link+"/"+autor+"/"+area+"/"+edicion;
        });
    });
</script>