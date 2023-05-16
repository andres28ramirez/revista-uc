<div class="row mb-4">  

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