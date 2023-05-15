<div class="content">
    <!-- titulo -->
    <h6>Información del Autor</h6>
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
                <span class="font-weight-bold">{{ __('Correo:') }}</span>{{ $autor->email }}
            </p>
        </ul>

        <ul class="bio-author">
            <p style="white-space: pre-line">
                {{ $autor->sintesis }}
            </p>
        </ul>
        
        <ul class="card-body">
            <h6>
                <a class="badge">{{ $articulo->conocimiento ? $articulo->conocimiento->nombre : "N/A" }}</a>
            </h6>
        </ul>
    </div>
</div>