
@extends('layouts.user.app')

@section('content')
<div class="main py-3">
    <div class="container" >
        <h4 class="font-weight-bold">{{ __('Información') }}</h4>
        <hr>
    
        @foreach ($informaciones as $informacion)
            <div class="accordion" id="myCollapsible">
                <div class="card">
                    <!-- Titulo General de la Informacion -->
                    <div class="card-header" id="heading">
                        <h2 class="mb-0">
                            <button class="btn btn-block text-left" type="button" 
                                id="#collapse{{ $informacion->id_informacion }}" data-toggle="collapse" 
                                href="#collapse{{ $informacion->id_informacion }}" aria-expanded="false" 
                                aria-controls="collapse{{ $informacion->id_informacion }}">
                                <h6 class="font-weight-bold">
                                    {{ App::isLocale('en') && $informacion->titulo_en ? $informacion->titulo_en : $informacion->titulo }}<i class="fas fa-chevron-down"></i>
                                </h6>
                            </button> 
                        </h2>
                    </div>

                    <!-- Desplegable Informativo -->
                    <div id="collapse{{ $informacion->id_informacion }}" class="collapse in" 
                        data-parent="#collapse{{ $informacion->id_informacion }}">
                        <div class="card-body">
                            <!-- Contenido -->
                            <p style="white-space: pre-line" class="text-justify">
                                {{ App::isLocale('en') && $informacion->contenido_en ? $informacion->contenido_en : $informacion->contenido }}
                            </p>

                            <!-- Archivo -->
                            @if ($informacion->ruta_archivo)
                                <div class="text-center">
                                    <a href="{{ route('configuracion.info.archivo', ['filename' => basename($informacion->ruta_archivo)]) }}"
                                        type="button" target="_blank" class="btn btn-outline-dark">
                                        {{ __('Ver más') }}
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection