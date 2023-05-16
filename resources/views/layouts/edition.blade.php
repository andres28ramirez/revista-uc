<div class="accordion" id="myCollapsible">
    <div class="card">

        <!-- Título -->
        <div class="card-header" id="heading">
            <h2 class="mb-0">
                <button class="btn btn-block text-left" type="button"  id="#collapse{{ $edicion->id_edicion }}" 
                    data-toggle="collapse" href="#collapse{{ $edicion->id_edicion }}" 
                    aria-expanded="false" aria-controls="collapse{{ $edicion->id_edicion }}">
                    <h6 class="font-weight-bold">
                        {{ $edicion->titulo }}<i class="fas fa-chevron-down"></i>
                    </h6>
                </button> 
            </h2>
        </div>

        <!-- Desplegable e Información -->
        <div id="collapse{{ $edicion->id_edicion }}" class="collapse in" data-parent="#collapse{{ $edicion->id_edicion }}">
            <div class="card-body">
                <div class="row">
                    <!-- Imagen preview -->
                    <div class="col-md-4">
                        <img src="{{ route('user.edicion.imagen', ['filename' => basename($edicion->ruta_imagen)]) }}" class="img-fluid">
                    </div>

                    <!-- Data -->
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="font-weight-bold">
                                {{ $edicion->titulo }}
                            </h5>
                            <p class="mb-0" style="white-space: pre-line">
                                <b>{{ __('Fecha de Publicación') }}:</b> {{ $edicion->created_at }}
                            </p>
                            <p class="mt-0" style="white-space: pre-line">
                                {{ $edicion->descripcion }}
                            </p>
                            <a href="{{ route('user.edicion', $edicion->id_edicion) }}" type="button" class="btn btn-outline-dark">
                                {{ __('Edición Completa') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>