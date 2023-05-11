@extends('layouts.admin.app')

@section('content')
<div class="container-fluid">

    <!-- TABLA -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Información editable en apartado Acerca de ...</h6>
        </div>

        <!-- CREAR NUEVA INFORMACION -->
        <div class="card-header" style="border-bottom: 0px;">
            <a href="{{ route('configuración.info.create') }}" class="btn btn-success btn-icon-split">
                <span class="icon text-white-50">
                    <i class="fas fa-plus"></i>
                </span>
                <span class="text">Crear una nueva Información</span>
            </a>
        </div>

        <div class="card-body">
            <!-- TABLA CON EL CONTENIDO DE EDICIONES -->
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Archivo</th>
                            <th>Título</th>
                            <th>Contenido</th>
                            <th>Fecha de Publicación</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($informaciones as $informacion)
                            <tr class="text-center">
                                <td class="align-middle">
                                    @if($informacion->ruta_archivo)
                                        <a href="{{ route('configuracion.info.archivo', ['filename' => basename($informacion->ruta_archivo)]) }}" target="_blank" 
                                            class="btn btn-light w-100">
                                            <span class="icon text-gray-600">
                                                    @switch(pathinfo($informacion->ruta_archivo)['extension'])
                                                        @case('pdf')<i class="fas fa-file-pdf"></i>@break
                                                        @default <i class="fas fa-image"></i>
                                                    @endswitch
                                            </span>
                                        </a>
                                    @else
                                        No posee...
                                    @endif
                                </td>
                                <td class="align-middle font-weight-bold">
                                    {{ $informacion->titulo }}
                                </td>
                                <td class="align-middle text-justify">
                                    <p style="white-space: pre-line">
                                        {{ $informacion->contenido }}
                                    </p>
                                </td>
                                <td class="align-middle">
                                    {{ date_format(date_create($informacion->created_at), "F j, Y") }}
                                </td>
                                <td class="align-middle">
                                    <a href="{{ route('configuración.info.edit', $informacion->id_informacion) }}" class="btn btn-info btn-circle btn-sm">
                                        <i class="fas fa-pencil"></i>
                                    </a>

                                    <!-- Boton de Eliminar -->
                                    <button name="{{ $informacion->id_informacion }}"
                                        class="btn btn-danger btn-circle btn-sm btn-delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    <form id="delete-informacion-{{ $informacion->id_informacion }}" action="{{ route('configuración.info.delete', $informacion->id_informacion) }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $informaciones->links() }}
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
                title: 'Estas seguro de elimnar la información seleccionada?',
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
                        'La información sera procesada para ser eliminada de los registros.',
                        'success'
                    );
                    setTimeout(function() { 
                        $( "#delete-informacion-"+id ).submit();
                    }, 2000);
                }
            });
        });
    });
</script>