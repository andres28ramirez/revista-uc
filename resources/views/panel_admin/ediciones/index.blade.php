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
                <span class="icon text-white-50">
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
                                {{ $edicion->titulo }}
                            </td>
                            <td class="align-middle">
                                {{ $edicion->descripcion }}
                            </td>
                            <td class="align-middle">
                                {{ date_format(date_create($edicion->fecha), "F j, Y") }}
                            </td>
                            <td class="align-middle">
                                {{ $edicion->articulos->count() }}
                            </td>
                            <td class="align-middle">
                                <a href="{{ route('edicion.edit', $edicion->id_edicion) }}" class="btn btn-info btn-circle btn-sm">
                                    <i class="fas fa-pencil"></i>
                                </a>
                                <a href="{{ route('edicion.delete', $edicion->id_edicion) }}" class="btn btn-danger btn-circle btn-sm">
                                    <i class="fas fa-trash"></i>
                                </a>
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