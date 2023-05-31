@extends('layouts.user.app')

@section('content')
<div class="main py-3">
    <!-- Apartado de la ediciópn abierta -->
    <div class="container-fluid">
        <!-- Nombre de la Edición -->
        <div class="edition_title">
            <h4 class="font-weight-bold">
                {{ App::isLocale('en') && $edicion->titulo_en ? $edicion->titulo_en : $edicion->titulo }}
            </h4>
        </div>
        <hr>

        <!-- informació de la edicion -->
        @include('layouts.open_edition', ["edicion" => $edicion])

        <!-- Boton de Descarga de la Edición Completa -->
        @if(Auth::user() && $edicion->ruta_archivo)
            <hr>
                <div class="edition_title text-center"> 
                    <a href="{{ route('user.edicion.archivo', ['filename' => basename($edicion->ruta_archivo), 'id_edicion' => $edicion->id_edicion]) }}" type="button" 
                        class="btn btn-outline-dark" target="_blank">
                        <i class="fas fa-download"></i> {{ __('Edición Completa') }}
                    </a>
                </div>
            <hr>
		@endif
    </div>

    <!-- Artículos anclados a la edición -->
    <div class="container mt-5">
        @forelse($edicion->articulos as $articulo)
            @include('layouts.article', ["artículo" => $articulo])
        @empty
            <div class="text-center pb-5 font-weight-bold text-gray-600">
                {{ __('La edición aun no posee artículos registrados') }}.
            </div>
        @endforelse
    </div>
</div>
@endsection