<div class="card mb-3">
    <div class="row no-gutters">
        <div class="col-md-4">
            <a href="{{ route('user.articulo', $articulo->id_articulo) }}">
                <img src="{{ route('user.articulo.imagen', ['filename' => basename($articulo->ruta_imagen_es)]) }}" class="img-fluid">
            </a>
        </div>
        <div class="col-md-8">
            <div class="card-body">
                <!-- Conocimiento -->
                <h6><a href="#" class="badge">{{ $articulo->conocimiento ? $articulo->conocimiento->nombre : "N/A" }}</a></h6>
                
                <!-- Título -->
                <h5><b>{{ $articulo->titulo }}</b></h5>

                <!-- Autor -->
                <p style="white-space: pre-line">{{ $articulo->autor ? $articulo->autor->nombre : "N/A" }}</p>

                <!-- Fecha de creación del Artículo -->
                <p class="card-text" style="white-space: pre-line">
                    <small class="text-muted">{{ $articulo->created_at }} - {{ FormatTime::LongTimeFilter($articulo->created_at) }}</small>
                </p>

                <!-- Link para ver detail del artilcle -->
                <a type="button" class="btn btn-outline-dark" href="{{route('user.articulo', $articulo->id_articulo)}}">
                    {{ __('Abrir Artículo') }}
                </a>
            </div>
        </div>
    </div>
</div>