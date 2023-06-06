@extends('layouts.admin.app')

@section('content')
<div class="container-fluid">
    


    <!-- TABLA -->
    <div class="card shadow mb-4">
        @if(!$nombre)
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Artículos y Ediciones cargadas en sistema</h6>
            </div>
        @else
            <div class="card-header py-3 text-center">
                <h4 class="m-0 font-weight-bold text-primary">{{ $nombre }}</h4>
            </div>
        @endif

        <!-- BOTON DE VOLVER -->
        @if($nombre)
            <div class="card-header" style="border-bottom: 0px; margin-bottom: -1%">
                <a href="{{ route('articulo.index') }}" class="btn btn-secondary btn-icon-split">
                    <span class="icon text-white-50">
                        <i class="fas fa-rotate-left"></i>
                    </span>
                    <span class="text">Volver al Inicio</span>
                </a>
            </div>
        @endif

        <!-- VER TODOS LOS ARTÍCULOS -->
        <div class="card-header" style="border-bottom: 0px; margin-bottom: -1%">
            <a href="{{ route('articulo.all') }}" class="btn btn-primary btn-icon-split">
                <span class="icon text-white-50">
                    <i class="fas fa-eye"></i>
                </span>
                <span class="text">Ver todos los Artículos</span>
            </a>
        </div>

        <!-- CREAR NUEVO ARTICULO -->
        @if($ediciones->count() > 0)
            <div class="card-header" style="border-bottom: 0px;">
                <a href="{{ route('articulo.create') }}" class="btn btn-success btn-icon-split">
                    <span class="icon text-white-50">
                        <i class="fas fa-plus"></i>
                    </span>
                    <span class="text">Crear un nuevo Artículo</span>
                </a>
            </div>
        @endif

        <div class="card-body">
            <!-- Acordion de Ediciones -->
            <div id="accordion-ediciones">
                <div class="card">
                    <div class="card-header text-center" id="headingOne" style="cursor: pointer"
                    data-toggle="collapse" data-target="#acordionEdiciones" aria-expanded="true" aria-controls="collapseAccordion">
                        <h6 class="mb-0">
                            <span class="w-100">
                                <span class="font-weight-bold">Todas las Ediciones</span><br>(Presiona sobre uno de ellos para ver todos sus artículos)
                            </span>
                        </h6>
                    </div>

                    <div id="acordionEdiciones" class="collapse" aria-labelledby="headingOne" data-parent="#acordionEdiciones">
                        @forelse($ediciones as $edicion)
                            <a class="text-dark"
                                href="{{ route('articulo.index', $edicion->id_edicion) }}">
                                <div class="card-body border {{ $nombre == $edicion->titulo ? 'bg-gray-200' : '' }}">
                                    {{ $edicion->titulo }} - Nro. Artículos en la edicion (<span class="font-weight-bold">{{ $edicion->articulos->count() }}</span>).
                                </div>
                            </a>
                        @empty
                            <div class="card-body border">
                                No hay ediciones cargadas, por favor carga alguna para que puedas gestionar nuevos artículos...
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Ultimos 6 Artículos o Todos Cargados en el sistema -->
            <div class="py-4">
                <h6 class="m-0 font-weight-bold text-primary">
                    {{
                        $nombre ? "Todos los Artículos de la Edición seleccionada" :
                        "Ultimos 6 Artículos Cargados"
                    }}
                </h6>
            </div>

            <div class="row justify-content-center">

                <!-- Artículo -->
                @forelse($articulos as $articulo)
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
                                <p class="text-justify">
                                    {{ substr($articulo->contenido, 0, 400) }}...
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
                        </div>
                    </div>
                @empty
                    <div class="col-lg-6">
                        <h6>No hay publicaciones de artículos cargados en el sistema</h6>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

</div>
@endsection

<script src="{{ asset('jquery/jquery.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        
    });
</script>