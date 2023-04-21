@extends('layouts.admin.app')

@section('content')
<div class="container-fluid">
    
    <!-- TABLA -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                "Crear un nuevo Artículo"
            </h6>
        </div>

        <!-- CREAR NUEVA EDICIÓN -->
        <div class="card-header py-3" style="border-bottom: 0px;">
            <a href="{{ route('articulo.all') }}" class="btn btn-secondary btn-icon-split">
                <span class="icon text-white-50">
                    <i class="fas fa-rotate-left"></i>
                </span>
                <span class="text">Regresar a todos los artículos</span>
            </a>
        </div>

        <div class="card-body container">
            <div class="row">
                <!-- formulario de creación o update de edición -->
                <div class="col-sm">
                    <form method="POST" enctype="multipart/form-data" action="{{ route('articulo.store') }}">
                        @csrf
                        
                        <!-- titulo -->
                        <div class="form-group">
                            <label for="titulo">Título:</label>
                            <input type="text" class="form-control @error('titulo') is-invalid @enderror" 
                                id="titulo" 
                                name="titulo"
                                value="{{ old('titulo') }}" required
                                placeholder="Título de la Edición...">
                            
                            @error('titulo')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Contenido del Artículo -->
                        <div class="form-group">
                            <label for="descripcion">Contenido:</label>
                            <textarea class="form-control @error('descripcion') is-invalid @enderror"
                                name="descripcion" id="descripcion" required
                                cols="30" rows="5">{{ old('descripcion') }}</textarea>
                            
                            @error('descripcion')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- edición del artículo -->
                        <div class="form-group">
                            <label for="edicion">¿A que edición pertence el artículo?</label>
                            <select id="edicion" class="form-control @error('edicion') is-invalid @enderror" name="edicion">
                                <option value="">Selecciona una Edición...</option>
                                @foreach($ediciones as $edicion)
                                    <option value="{{ $edicion->id_edicion }}" {{ old('edicion') == $edicion->id_edicion ? "selected" : ""}}>{{ $edicion->titulo }}</option>
                                @endforeach
                            </select>
                            
                            @error('edicion')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Autor del Artículo -->
                        <div class="form-group">
                            <label for="autor">Autor del Artículo:</label>
                            <select id="autor" class="form-control @error('autor') is-invalid @enderror" name="autor">
                                <option value="">Selecciona un Autor...</option>
                                @foreach($autores as $autor)
                                    <option value="{{ $autor->id_autor }}" {{ old('autor') == $autor->id_autor ? "selected" : ""}}>{{ $autor->nombre }}</option>
                                @endforeach
                                <option value="null">No posee Autor</option>
                            </select>
                            
                            @error('autor')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Area de Conocimiento del Artículo -->
                        <div class="form-group">
                            <label for="area">Area de Conocimiento:</label>
                            <select id="area" class="form-control @error('area') is-invalid @enderror" name="area">
                                <option value="">Selecciona un Area de Conocimiento...</option>
                                @foreach($areas as $area)
                                    <option value="{{ $area->id_conocimiento }}" {{ old('area') == $area->id_conocimiento ? "selected" : ""}}>{{ $area->nombre }}</option>
                                @endforeach
                            </select>
                            
                            @error('area')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Imagen del Archivo español -->
                        <div class="form-group">
                            <label for="ruta_imagen_es">Caratula del Artículo: Opcional*</label>

                            <div class="custom-file">
                                <input type="file" accept="image/png, image/jpeg, image/jpg" name="ruta_imagen_es"
                                    class="custom-file-input @error('ruta_imagen_es') is-invalid @enderror" id="archivo">
                                @error('ruta_imagen_es')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <label class="custom-file-label" for="ruta_imagen_es">Selecciona un archivo</label>
                            </div>
                        </div>

                        <!-- Archivos del Artículo Anclados que se vayan a cargar -->
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