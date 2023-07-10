@extends('layouts.admin.app')

@section('title')
{{ "Archivos" }}
@endsection

@section('content')
<div class="container-fluid">

    <!-- TABLA -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Archivos o Documentos Cargados en el Sistema</h6>
        </div>

        <!-- REINICIAR FILTROS DE BUSQUEDA -->
        @if($filtrado)
            <div class="card-header pb-0" style="border-bottom: 0px;">
                <a href="{{ route('archivo.index') }}" class="btn btn-secondary btn-sm btn-icon-split">
                    <span class="icon text-white-50" style="padding: 0.75rem 0.75rem;">
                        <i class="fas fa-rotate-left"></i>
                    </span>
                    <span class="text">Eliminar filtros de busqueda</span>
                </a>
            </div>
        @endif

        <!-- FILTRO DE BUSQUEDA -->
        <div class="card-body pb-0">
            <button type="button" class="btn btn-info btn-sm mb-1" data-toggle="modal" data-target="#filtradoModal">
                Aplicar Filtros de Busqueda
            </button>
            @if($filtrado)
                <br>
                <label for="">
                    Filtro de Busqueda Aplicado por: <br>
                    <span class="font-weight-bold text-primary">{{ $name_articulo }}</span>
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
                            <th>Archivo</th>
                            <th>Nombre</th>
                            <th>Formato</th>
                            <th>Artículo</th>
                            <th>Fecha de Cargado</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($archivos as $archivo)
                            <tr class="text-center">
                                <td class="align-middle">
                                    <a href="{{ route('articulo.archivo', ['filename' => basename($archivo->ruta_archivo_es)]) }}" target="_blank" 
                                        class="btn btn-light w-100">
                                        <span class="icon text-gray-600">
                                            @switch($archivo->tipo)
                                                @case('pdf')<i class="fas fa-file-pdf"></i>@break
                                                @default <i class="fas fa-image"></i>
                                            @endswitch
                                        </span>
                                    </a>
                                </td>
                                <td class="align-middle">
                                    {{ $archivo->nombre }}
                                </td>
                                <td class="align-middle">
                                    {{ $archivo->tipo }}
                                </td>
                                <td class="align-middle">
                                    {{ $archivo->articulo->titulo }}
                                </td>
                                <td class="align-middle">
                                    {{ date_format(date_create($archivo->created_at), "F j, Y") }}
                                </td>
                                <td class="align-middle">
                                    <a href="{{ route('articulo.edit', $archivo->articulo->id_articulo) }}" class="btn btn-info btn-circle btn-sm">
                                        <i class="fas fa-pencil"></i>
                                    </a>

                                    <!-- Boton de Eliminar -->
                                    <button name="{{ $archivo->id_archivo }}"
                                        class="btn btn-danger btn-circle btn-sm btn-delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    <form id="delete-archivo-{{ $archivo->id_archivo }}" action="{{ route('archivo.delete', $archivo->id_archivo) }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $archivos->links() }}
            </div>
        </div>
    </div>

</div>
<input type="hidden" id="link_dir" value="{{ route('archivo.index') }}">

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
        $('.btn-delete').click(function(){
            var id = $(this).attr('name');

            Swal.fire({
                title: 'Estas seguro de elimnar el archivo seleccionado?',
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
                        'El archivo sera procesado para ser eliminado de los registros y del artículo.',
                        'success'
                    );
                    setTimeout(function() { 
                        $( "#delete-archivo-"+id ).submit();
                    }, 2000);
                }
            });
        });

        //Filtrat Tabla de Artículos
        $('#filter_button').click(function(){
            let link = $('#link_dir').val();
            let articulo = $('#articulo_filter option:selected').val();
            
            location.href = link+"/"+articulo;
        });
    });
</script>