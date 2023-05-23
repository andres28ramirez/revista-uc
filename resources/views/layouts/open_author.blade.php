<div class="content">
    <!-- titulo -->
    <h6>{{ __('Información del Autor') }}</h6>
    <hr>

    <!-- Imagen -->
    <img src="{{ route('user.autor.imagen', ['filename' => basename($autor->ruta_imagen)]) }}" 
        class="img-fluid">
    
    <!-- Información -->
    <div class="info-container">
        <ul class="author-article" >
            <p class="font-weight-bold" style="white-space: pre-line">
                {{ $autor->nombre }}
            </p>

            <p style="white-space: pre-line">
                {{ $autor->grado }}
            </p>
            
            <p style="white-space: pre-line">
                <span class="font-weight-bold">{{ __('Correo') }}: </span>{{ $autor->email }}
            </p>
        </ul>

        <ul class="bio-author">
            <p style="white-space: pre-line">
                {{ $autor->sintesis }}
            </p>
        </ul>
        
        <ul class="card-body">
            <h6>
                <a class="badge">
                    @if(App::isLocale('en'))
                        {{ $articulo->conocimiento ? $articulo->conocimiento->nombre_en : "N/A" }}
                    @else
                        {{ $articulo->conocimiento ? $articulo->conocimiento->nombre : "N/A" }}
                    @endif    
                </a>
            </h6>
        </ul>
    </div>
</div>