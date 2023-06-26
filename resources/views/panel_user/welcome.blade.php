@extends('layouts.user.app')

@section('content')
<div class="main">
    @if($edicion)
        <div class="container-fluid py-3">
            
            <!-- Aviso Inicial -->
            <!-- <div class="col-12 .col-sm-12 col-md-12 .col-lg-12 .col-xl-12">
                <div class="informative text-center text-dark py-1 shadow box rounded-pill" style="background-color: #F6E5C0;">
                    <h5 class="font-weight-bold">AVISO</h5>
                    <p class="font-weight-bold">
                        <i>
                            La Revista Unimar Científica informa que ya se inició el proceso de recepción y arbitraje de Artículos Científicos para los Volúmenes 2 y 3 del presente año.<br/>
                            Para mayor información de los requisitos consultar en la pestaña de Información.
                        </i>
                    </p>
                </div>
            </div> -->

            <!-- informació de la edicion -->
            @include('layouts.open_edition', ["edicion" => $edicion])

            <!-- Nombre de la Edición -->
            <div class="edition_title">
                <h4><b>{{ App::isLocale('en') && $edicion->titulo_en ? $edicion->titulo_en : $edicion->titulo }}</b></h4>
            </div>
        </div>
        
        <!-- Artículos de la Ultima Edición -->
        <hr>
        <div class="container mt-5">
            @forelse($edicion->articulos as $articulo)
                @include('layouts.article', ["artículo" => $articulo])
            @empty
                <div class="text-center pb-5 font-weight-bold text-gray-600">
                    {{__('La edición aun no posee artículos registrados.')}}
                </div>
            @endforelse
        </div>
    @else
        <!-- Titulo informativo -->
        <div class="edition_title py-3">
            <h4><b>{{__('La revista aun no tiene ninguna edición o artículo registrado')}}</b></h4>
        </div>
    @endif
</div>
@endsection
