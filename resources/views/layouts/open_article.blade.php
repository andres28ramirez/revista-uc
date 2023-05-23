<br>
<!-- Titulo -->
<div class="container">
    <div class="title-article mb-1">
        <h2>{{ App::isLocale('en') && $articulo->titulo_en ? $articulo->titulo_en : $articulo->titulo }}</h2>
    </div>
</div>

<!-- Imagen previsual -->
<div class="img-article">
    <img src="{{ route('user.articulo.imagen', ['filename' => basename($articulo->ruta_imagen_es)]) }}">
</div>

<br>

<!-- Texto del Artículo -->
<div class="resume-article">
    <div class="container">
        <p class="font-weight-bold font-italic" style="white-space: pre-line">{{ __('Resumen') }}:</p>
        <div>
            {{ App::isLocale('en') && $articulo->contenido_en ? $articulo->contenido_en : $articulo->contenido }}
        </div>
    </div>
</div>

<!-- Boton de Abrir contenido del artículo -->
<div class="col-12 text-center px-4">
    @forelse($articulo->archivos as $archivo)
        <a href="{{ route('user.articulo.archivo', ['filename' => basename($archivo->ruta_archivo_es)]) }}" target="_blank" 
            class="btn btn-light btn-icon-split mb-1">
            <span class="icon text-gray-600" style="width: 50px;">
                @switch($archivo->tipo)
                    @case('pdf')<i class="fas fa-file-pdf"></i>@break
                    @default <i class="fas fa-image"></i>
                @endswitch
            </span>
            <span class="text">{{ $archivo->nombre }}</span>
        </a>
    @empty
        {{ __('No posee archivos linkeados') }}...
    @endforelse
</div>
<br>