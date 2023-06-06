@extends('layouts.admin.app')

@section('content')
<div class="container-fluid">
    


    <!-- TABLA -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Autores Registrados</h6>
        </div>

        
        <!-- CREAR NUEVA AUTOR -->
        <div class="card-header py-3" style="border-bottom: 0px;">
            <a href="{{ route('autor.create') }}" class="btn btn-success btn-icon-split">
                <span class="icon text-white-50" style="padding: 0.75rem 0.75rem;">
                    <i class="fas fa-plus"></i>
                </span>
                <span class="text">Almacenar un nuevo Autor</span>
            </a>
        </div>

        <div class="card-body">
            <!-- TABLA CON EL CONTENIDO DE AUTORES -->
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Imagen</th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Grado</th>
                            <th>Síntesis</th>
                            <th>Artículos Cargados</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($autores as $autor)
                        <tr class="text-center">
                            <td class="align-middle">
                                <div class="text-center m-auto" >
                                    <img class="img-fluid img-thumbnail" 
                                    src="{{ route('autor.imagen', ['filename' => basename($autor->ruta_imagen)]) }}" 
                                    alt="previsual de la edición" width="100%" height="100%">
                                </div>
                            </td>
                            <td class="align-middle">
                                {{ $autor->nombre }}
                            </td>
                            <td class="align-middle">
                                {{ $autor->email ? $autor->email : "No tiene registrado" }}
                            </td>
                            <td class="align-middle">
                                {{ $autor->grado }}
                            </td>
                            <td class="align-middle text-justify">
                                {{ $autor->sintesis }}
                            </td>
                            <td class="align-middle">
                                <a href="{{ route('articulo.all', $autor->id_autor) }}" class="btn btn-warning btn-icon-split">
                                    <span class="icon text-white font-weight-bold">
                                        {{ $autor->articles->count() }}
                                    </span>
                                    <span class="text">Ver</span>
                                </a>
                            </td>
                            <td class="align-middle">
                                <a href="{{ route('autor.edit', $autor->id_autor) }}" class="btn btn-info btn-circle btn-sm">
                                    <i class="fas fa-pencil"></i>
                                </a>

                                <!-- Boton de Eliminar -->
                                <button name="{{ $autor->id_autor }}"
                                    class="btn btn-danger btn-circle btn-sm btn-delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                                <form id="delete-autor-{{ $autor->id_autor }}" action="{{ route('autor.delete', $autor->id_autor) }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $autores->links() }}
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
                title: 'Estas seguro de elimnar al autor?',
                text: "No podras revertir esta elección, esto borrara al autor y dejara los artículos de el sin autor!",
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
                        'El autor sera procesado para ser eliminado de los registros.',
                        'success'
                    );
                    setTimeout(function() { 
                        $( "#delete-autor-"+id ).submit();
                    }, 2000);
                }
            });
        });
    });
</script>