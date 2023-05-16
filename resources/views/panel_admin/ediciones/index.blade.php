@extends('layouts.admin.app')

@section('content')
<div class="container-fluid">
    


    <!-- TABLA -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Ediciones Cargadas</h6>
        </div>

        
        <!-- CREAR NUEVA EDICIÓN -->
        <div class="card-header py-3" style="border-bottom: 0px;">
            <a href="{{ route('edicion.create') }}" class="btn btn-success btn-icon-split">
                <span class="icon text-white-50" style="padding: 0.75rem 0.75rem;">
                    <i class="fas fa-plus"></i>
                </span>
                <span class="text">Crear una nueva edición</span>
            </a>
        </div>

        <div class="card-body">
            <!-- TABLA CON EL CONTENIDO DE EDICIONES -->
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr><th>Nro. de Publicación</th>
                            <th>Imagen</th>
                            <th>Archivo</th>
                            <th>Título</th>
                            <th>Descripción</th>
                            <th>Fecha de Edición</th>
                            <th>Nro. de Artículos</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ediciones as $edicion)
                        <tr class="text-center">
                            <td class="align-middle">
                                {{ $edicion->numero }}.º
                            </td>
                            <td class="align-middle">
                                <div class="text-center m-auto" >
                                    @if( $edicion->ruta_imagen )
                                        <img class="img-fluid img-thumbnail" 
                                        src="{{ route('edicion.imagen', ['filename' => basename($edicion->ruta_imagen)]) }}" 
                                        alt="previsual de la edición" width="100%" height="100%">
                                    @else
                                        <img class="img-fluid img-thumbnail" 
                                        src="{{ asset('images/nodisponible.png') }}" 
                                        alt="previsual de la edición" width="100%" height="100%">
                                    @endif
                                </div>
                            </td>
                            <td class="align-middle">
                                @if($edicion->ruta_archivo)
                                    <a href="{{ route('edicion.archivo', ['filename' => basename($edicion->ruta_archivo)]) }}" target="_blank" 
                                        class="btn btn-light w-100">
                                        <span class="icon text-gray-600">
                                                @switch(pathinfo($edicion->ruta_archivo)['extension'])
                                                    @case('pdf')<i class="fas fa-file-pdf"></i>@break
                                                    @default <i class="fas fa-image"></i>
                                                @endswitch
                                        </span>
                                    </a>
                                @else
                                    N/A
                                @endif
                            </td>
                            <td class="align-middle">
                                {{ $edicion->titulo }}
                            </td>
                            <td class="align-middle">
                                {{ $edicion->descripcion }}
                            </td>
                            <td class="align-middle">
                                {{ date_format(date_create($edicion->fecha), "F j, Y") }}
                            </td>
                            <td class="align-middle">
                                <a href="{{ route('articulo.index', $edicion->id_edicion) }}" class="btn btn-warning btn-icon-split">
                                    <span class="icon text-white font-weight-bold">
                                        {{ $edicion->articulos->count() }}
                                    </span>
                                    <span class="text">Ver</span>
                                </a>
                            </td>
                            <td class="align-middle">
                                <a href="{{ route('edicion.edit', $edicion->id_edicion) }}" class="btn btn-info btn-circle btn-sm">
                                    <i class="fas fa-pencil"></i>
                                </a>

                                <!-- Boton de Eliminar -->
                                <button name="{{ $edicion->id_edicion }}"
                                    class="btn btn-danger btn-circle btn-sm btn-delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                                <form id="delete-edicion-{{ $edicion->id_edicion }}" action="{{ route('edicion.delete', $edicion->id_edicion) }}" method="POST" style="display: none;">
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
                        $( "#delete-edicion-"+id ).submit();
                    }, 2000);
                }
            });
        });
    });
</script>