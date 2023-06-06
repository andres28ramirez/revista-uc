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
                <h6>
                    <a href="#" class="badge">
                    @if(App::isLocale('en'))
                        {{ $articulo->conocimiento ? $articulo->conocimiento->nombre_en : "N/A" }}
                    @else
                        {{ $articulo->conocimiento ? $articulo->conocimiento->nombre : "N/A" }}
                    @endif
                    </a>
                </h6>
                
                <!-- Título -->
                <h5><b>{{ App::isLocale('en') && $articulo->titulo_en ? $articulo->titulo_en : $articulo->titulo  }}</b></h5>

                <!-- Autores -->
                <p style="white-space: pre-line">
                    @forelse($articulo->autores as $autor)
                        <span class="d-block my-0">{{ $autor->autor->nombre }}</span>
                    @empty
                        <span>N/A</span>
                    @endforelse
                </p>

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