@extends('layouts.admin.app')

@section('content')
<div class="container-fluid">
    
    <!-- TABLA -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                {{ $edicion ? "Editando Edición" : "Crear una nueva Edición"}}
            </h6>
        </div>

        <!-- CREAR NUEVA EDICIÓN -->
        <div class="card-header py-3" style="border-bottom: 0px;">
            <a href="{{ route('edicion.index') }}" class="btn btn-secondary btn-icon-split">
                <span class="icon text-white-50">
                    <i class="fas fa-rotate-left"></i>
                </span>
                <span class="text">Regresar a todas las ediciones</span>
            </a>
        </div>

        <div class="card-body container">
            <div class="row">
                <!-- formulario de creación o update de edición -->
                <div class="col-sm">
                    <form method="POST" enctype="multipart/form-data" action="{{ $edicion ? route('edicion.update', $edicion->id_edicion) : route('edicion.store') }}">
                        @csrf
                        
                        <!-- titulo -->
                        <div class="form-group">
                            <label for="titulo">Título:</label>
                            <input type="text" class="form-control @error('titulo') is-invalid @enderror" 
                                id="titulo" 
                                name="titulo"
                                value="{{ $edicion ? old('titulo', $edicion->titulo) : old('titulo') }}" required
                                placeholder="Título de la Edición...">
                            
                            @error('titulo')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- numero de publicacion -->
                        <div class="form-group">
                            <label for="numero">Número de Publicación / <em>sirve como ordenamiento</em>:</label>
                            <input type="number" min="1" 
                                class="form-control @error('numero') is-invalid @enderror" 
                                id="numero" 
                                name="numero"
                                value="{{ $edicion ? old('numero', $edicion->numero) : old('numero') }}" required
                                placeholder="Digita el número de la edición...">
                            
                            @error('numero')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Fecha de la publicación -->
                        <div class="form-group">
                            <label for="fecha">Fecha de Publicación:</label>
                            <input type="date" min="1" 
                                class="form-control @error('fecha') is-invalid @enderror" 
                                id="fecha" 
                                name="fecha"
                                value="{{ $edicion ? old('fecha', $edicion->fecha) : old('fecha', date('Y-m-d')) }}" required
                                placeholder="Digita el número de la edición...">
                            
                            @error('fecha')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Descripcion de la edicion -->
                        <div class="form-group">
                            <label for="descripcion">Descripción:</label>
                            <textarea class="form-control @error('descripcion') is-invalid @enderror"
                                name="descripcion" id="descripcion" required
                                cols="30" rows="5">{{ $edicion ? old('descripcion', $edicion->descripcion) : old('descripcion') }}</textarea>
                            
                            @error('descripcion')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Imagen del Archivo -->
                        <div class="form-group">
                            <label for="ruta_imagen">Caratula de la Edición: Opcional*</label>

                            <div class="custom-file">
                                <input type="file" accept="image/png, image/jpeg, image/jpg" name="ruta_imagen"
                                    class="custom-file-input @error('ruta_imagen') is-invalid @enderror" id="archivo">
                                @error('ruta_imagen')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <label class="custom-file-label" for="ruta_imagen">Selecciona un archivo</label>
                            </div>

                            
                        </div>
                        <button type="submit" class="btn btn-success mt-2">
                            {{ $edicion ? "Editar Edición" : "Crear Edición" }}
                        </button>
                    </form>
                </div>

                <!-- previsualización -->
                <div class="col-sm">
                    <div class="text-center">
                        <h5>Previsualización del Contenido</h5>
                    </div>
                    
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 text-center">
                                <img id="preImagen" 
                                    src="{{ $edicion ? route('edicion.imagen', ['filename' => basename($edicion->ruta_imagen)]) : asset('images/nodisponible.png') }}" 
                                    class="img-fluid" height="300" width="300">
                            </div>
                            <div class="col-12">
                                <div class="card-body">
                                    <h6 class="font-weight-bold" id="preTitulo">{{ $edicion ? $edicion->titulo : "Título de la Edición" }}</h6>
                                    <p><b>Fecha de Publicación: </b> <span id="preFecha">{{ $edicion ? date_format(date_create($edicion->fecha), "Y-m-d") : date('Y-m-d')}}</span></p>
                                    <p id="preDescrip">{{ $edicion ? $edicion->descripcion : "Texto con la descripción" }}</p>
                                    <a href="#" type="button" class="btn btn-outline-dark">Edición Completa</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<input type="hidden" id="imagenPreview" value="{{ asset('images/nodisponible.png') }}">
@endsection

<script src="{{ asset('jquery/jquery.min.js') }}"></script>
<script>
    $(document).ready(function() {
        //Edicion de la previsualizacion
        $('#titulo').change(function() {
            $('#preTitulo').text($(this).val());
        });

        $('#fecha').change(function() {
            $('#preFecha').text($(this).val());
        });

        $('#descripcion').change(function() {
            $('#preDescrip').text($(this).val());
        });
        
        $('#numero').change(function() {
            var numero = $(this).val();

            if(numero < 1){
                $(this).val(null);
            }
        });

        function readImage(input){
            var url = input.value;
            var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
            
            if(input.files && input.files[0] && (ext == "png" || ext == "jpeg" || ext == "jpg")){
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#preImagen').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            } else {
                var src = $('#imagenPreview').val();
                $('#preImagen').attr('src', src);
                input.value = null;
            }
        }

        $('#archivo').change(function() {
            readImage(this);
        });
    });
</script>