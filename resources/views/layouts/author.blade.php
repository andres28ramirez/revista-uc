<div class="accordion" id="myCollapsible">
    <div class="card">
        <!-- Título del acordion -->
        <div class="card-header" id="heading">
            <h2 class="mb-0">
                <button class="btn btn-block text-left" type="button"  
                        id="#collapse{{ $autor->id_autor }}" data-toggle="collapse" 
                        href="#collapse{{ $autor->id_autor }}" aria-expanded="false" 
                        aria-controls="collapse{{ $autor->id_autor }}">
                    <h6>
                        {{ $autor->nombre }}<i class="fas fa-chevron-down"></i>
                    </h6>
                </button> 
            </h2>
        </div>

        <!-- Acordión desplegable con la información -->
        <div id="collapse{{ $autor->id_autor }}" 
            class="collapse in" data-parent="#collapse{{ $autor->id_autor }}">
            <div class="card-body">
                <div class="row">
                    <!-- Información del Autor -->
                    <div class="col-md-6 col-sm-12">
                        <div class="row">
                            <div class="col-md-4 col-sm-12" id="imgcontainer">
                                <img id="imgauthor" src="{{ route('user.autor.imagen', ['filename' => basename($autor->ruta_imagen)]) }}">
                            </div>
                            <div class="col-md-8 col-sm-12" id="infoautorcontainer">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $autor->nombre }}</h5>
                                    <p class="card-text" style="white-space: pre-line"><small class="text-muted">{{ $autor->email }}</small></p>
                                    <p class="card-text" style="white-space: pre-line">{{ $autor->grado }}</p>
                                    <p class="card-text" style="white-space: pre-line">{{ $autor->sintesis }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Artículos del Autor -->
                    <div class="col-md-6 col-sm-12">
                        <br>
                        <h6>{{ __('Artículos del Autor:') }}</h6>
                        <hr>
                        @foreach($autor->articulos as $articulo)
                            <a id="link-author" href="{{ route('user.articulo', $articulo->id_articulo) }}" 
                                style= "color: inherit;">
                                {{ $articulo->titulo }}
                            </a>
                        @endforeach
                    </div> 
                </div>
            </div>
        </div>
    </div>
</div>