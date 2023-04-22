@extends('layouts.admin.app')

@section('content')
<link  rel="stylesheet" href="{{asset('css/input_files.css')}}"/>

<div class="container-fluid">
    
    <!-- TABLA -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                Crear un nuevo Artículo
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
                            <label for="contenido">Contenido:</label>
                            <textarea class="form-control @error('contenido') is-invalid @enderror"
                                name="contenido" id="contenido" required
                                cols="30" rows="5">{{ old('contenido') }}</textarea>
                            
                            @error('contenido')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- edición del artículo -->
                        <div class="form-group">
                            <label for="edicion">¿A que edición pertence el artículo?</label>
                            <select id="edicion" class="form-control @error('FK_id_edicion') is-invalid @enderror" name="FK_id_edicion" required>
                                <option value="">Selecciona una Edición...</option>
                                @foreach($ediciones as $edicion)
                                    <option value="{{ $edicion->id_edicion }}" {{ old('FK_id_edicion') == $edicion->id_edicion ? "selected" : ""}}>{{ $edicion->titulo }}</option>
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
                            <label for="autor">Autor del Artículo: Opcional*</label>
                            <select id="autor" class="form-control @error('FK_id_autor') is-invalid @enderror" name="FK_id_autor">
                                <option value="">Selecciona un Autor...</option>
                                @foreach($autores as $autor)
                                    <option value="{{ $autor->id_autor }}" {{ old('FK_id_autor') == $autor->id_autor ? "selected" : ""}}>{{ $autor->nombre }}</option>
                                @endforeach
                            </select>
                            
                            @error('FK_id_autor')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Area de Conocimiento del Artículo -->
                        <div class="form-group">
                            <label for="area">Area de Conocimiento: Opcional*</label>
                            <select id="area" class="form-control @error('FK_id_conocimiento') is-invalid @enderror" name="FK_id_conocimiento">
                                <option value="">Selecciona un Area de Conocimiento...</option>
                                @foreach($areas as $area)
                                    <option value="{{ $area->id_conocimiento }}" {{ old('FK_id_conocimiento') == $area->id_conocimiento ? "selected" : ""}}>{{ $area->nombre }}</option>
                                @endforeach
                            </select>
                            
                            @error('FK_id_conocimiento')
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

                        <!-- Documentos del Artículo -->
                        <div class="form-group">
                            <label for="ruta_imagen_es">Archivos Adjuntos al Artículo:</label>

                            <div class="form-group files">
                                <input type="file" class="form-control @error('archivos.*') is-invalid @enderror" 
                                    name="archivos[]" multiple="" id="archivos">
                                @error('archivos.*')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div id="files_names">

                            </div>
                        </div>

                        <button type="submit" class="btn btn-success mt-2">
                            Crear Artículo
                        </button>
                    </form>
                </div>

                <!-- previsualización -->
                <div class="col-sm">
                    <div class="text-center">
                        <h5>Previsualización del Contenido</h5>
                    </div>
                    
                    <div class="card-body">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary" id="preTitulo">
                                    {{ old("titulo", "Título") }}
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="text-center">
                                    <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" width="100%" height="100%"
                                        src="{{ asset('images/nodisponible.png') }}" id="preImagen">
                                </div>
                                <div class="text-center">
                                    <h6 class="text-dark">
                                        <span id="preAutor">{{ old("autor", "Autor") }}</span> - 
                                        <span id="preArea" class="badge badge-pill badge-primary">{{ old("area", "Area") }}</span>
                                    </h6>
                                </div>
                                <h6 class="text-dark">
                                    <span class="font-weight-bold">Edición</span>:
                                    <span id="preEdicion">{{ old("edicion", "Nombre") }}</span>
                                </h6>
                                <p id="preDescrip" class="text-justify">
                                    Resumen...
                                </p>
                                <div class="d-block">
                                    <button class="btn btn-info btn-circle">
                                        <i class="fas fa-comment"></i>
                                    </button>
                                    0 Comentarios
                                </div>
                                <div class="d-block text-center">
                                    <a target="_blank" rel="nofollow" href="#">
                                        Abrir Artículo &rarr;
                                    </a>
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

            $('#contenido').change(function() {
                $('#preDescrip').text($(this).val());
            });
            
            $('#edicion').change(function() {
                let texto = $( "#edicion option:selected" ).text();
                $('#preEdicion').text(texto);
            });
            
            $('#autor').change(function() {
                let texto = $( "#autor option:selected" ).text();
                $('#preAutor').text(texto);
            });
            
            $('#area').change(function() {
                let texto = $( "#area option:selected" ).text();
                $('#preArea').text(texto);
            });

        //previsualizacion de imagenes
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

        //recoger nombre de los archivos
            $('#archivos').change(function() {
                var files = $('#archivos').get(0).files;

                $('#files_names').empty();
                $.each(files, function(_, file) {
                    $('#files_names').append('<label class="d-block">'+file.name+'</label>');
                });
            });
    });
</script>