@extends('layouts.user.app')

@section('content')
<div class="main">
    @if($edicion)
        <div class="container-fluid">
            <div class="row mb-4">
                
                <!-- Aviso Inicial -->
                <div class="col-12 .col-sm-12 col-md-12 .col-lg-12 .col-xl-12">
                    <div class="informative text-center text-dark py-1 shadow box rounded-pill" style="background-color: #F6E5C0;">
                        <h5 class="font-weight-bold">AVISO</h5>
                        <p class="font-weight-bold">
                            <i>
                                La Revista Unimar Científica informa que ya se inició el proceso de recepción y arbitraje de Artículos Científicos para los Volúmenes 2 y 3 del presente año.<br/>
                                Para mayor información de los requisitos consultar en la pestaña de Información.
                            </i>
                        </p>
                    </div>
                </div>

                <!-- Portada de Ultima Editorial -->
                <div class="col-12 .col-sm-12 col-md-6 .col-lg-6 .col-xl-6">
                    <br>
                    <div class="edition-cover">
                        <img src="{{ route('user.edicion.imagen', ['filename' => basename($edicion->ruta_imagen)]) }}" style="display:block; width: 92%; margin:0 auto;">
                    </div>
                </div>

                <!-- Indice de los Artículos de la ultima editorial -->
                <div class="col-12 .col-sm-12 col-md-6 .col-lg-6 .col-xl-6" id="popular">
                    <div class="list-group">
                        
                        <div class="list-group-item list-group-item-action" id="popular_header_barside">
                            <div class="d-flex w-100 justify-content-between">
                                <h5><b>{{ __('Indice') }}</b></h5>
                                <i class="fas fa-list"></i>
                            </div>
                        </div>

                        <!-- articulos -->
                        @forelse($edicion->articulos as $articulo)
                            <div class="contenido-popular-bar">
                                <li class="list-group-item">
                                    <p>{{ $articulo->titulo }}</p>
                                </li>
                            </div>
                        @empty
                            <div class="contenido-popular-bar">
                                <li class="list-group-item">
                                    <p>Aun no posee artículos cargados la edición</p>
                                </li>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Nombre de la Edición -->
            <div class="edition_title">
                <h4><b>{{ $edicion->titulo }}</b></h4>
            </div>
        </div>
        
        <!-- Artículos de la Ultima Edición -->
        <hr>
        <div class="container mt-5">
            @forelse($edicion->articulos as $articulo)
                @include(('layouts.article'))
            @empty
                <div class="text-center pb-5 font-weight-bold text-gray-600">
                    La edición aun no posee artículos registrados.
                </div>
            @endforelse
        </div>
    @else
        <!-- Titulo informativo -->
        <div class="edition_title">
            <h4><b>La revista aun no tiene ninguna edición o artículo registrado</b></h4>
        </div>
    @endif
</div>
@endsection
