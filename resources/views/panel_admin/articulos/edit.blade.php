@extends('layouts.admin.app')

@section('content')
<link  rel="stylesheet" href="{{asset('css/input_files.css')}}"/>

<div class="container-fluid">
    
    <!-- TABLA -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                Editar información del artículo seleccionado
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
                    <form method="POST" enctype="multipart/form-data" action="{{ route('articulo.update', $articulo->id_articulo) }}">
                        @csrf
                        
                        <!-- titulo -->
                        <div class="form-group">
                            <label for="titulo">Título:</label>
                            <input type="text" class="form-control @error('titulo') is-invalid @enderror" 
                                id="titulo" 
                                name="titulo"
                                value="{{ old('titulo', $articulo->titulo) }}" required
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
                                cols="30" rows="5">{{ old('contenido', $articulo->contenido) }}</textarea>
                            
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
                                    <option value="{{ $edicion->id_edicion }}" {{ old('FK_id_edicion', $articulo->FK_id_edicion) == $edicion->id_edicion ? "selected" : ""}}>{{ $edicion->titulo }}</option>
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
                                    <option value="{{ $autor->id_autor }}" {{ old('FK_id_autor', $articulo->FK_id_autor) == $autor->id_autor ? "selected" : ""}}>{{ $autor->nombre }}</option>
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
                                    <option value="{{ $area->id_conocimiento }}" {{ old('FK_id_conocimiento', $articulo->FK_id_conocimiento) == $area->id_conocimiento ? "selected" : ""}}>{{ $area->nombre }}</option>
                                @endforeach
                            </select>
                            
                            @error('FK_id_conocimiento')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Fecha de Publicación o aceptado el artículo -->
                        <!-- <div class="form-group">
                            <label for="publicated_at">Fecha de Publicación: Opcional*</label>
                            <input type="date" class="form-control @error('publicated_at') is-invalid @enderror" 
                                id="publicated_at" name="publicated_at"
                                value="{{ old('publicated_at', $articulo->publicated_at) }}">
                            
                            @error('publicated_at')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div> -->

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

                    <!-- SECCIÓN CARGA DEL ARTÍCULO EN INGLES -->
                        <hr>
                        <!-- Opciones de cargar contenido en ingles -->
                        @if(!$articulo->titulo_en)
                            <label for="">¿Ya el artículo posee contenido en ingles?</label>
                            <div class="form-group">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="editEnglish" id="inlineEng1" value="1">
                                    <label class="form-check-label" for="inlineEng1">Si</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="editEnglish" id="inlineEng2" value="0" checked="checked">
                                    <label class="form-check-label" for="inlineEng2">No</label>
                                </div>
                            </div>
                        @endif

                        <div class="form-group load_english" 
                            style="display: <?php echo $articulo->titulo_en ? '' : 'none'?>">
                            <!-- Título en Ingles -->
                            <div class="form-group">
                                <label for="titulo">Title of the Article:</label>
                                <input type="text" class="form-control @error('titulo_en') is-invalid @enderror" 
                                    id="titulo_en" 
                                    name="titulo_en"
                                    value="{{ old('titulo_en', $articulo->titulo_en) }}" 
                                    placeholder="Title of the Article...">
                                
                                @error('titulo_en')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <!-- Contenido en Ingles -->
                            <div class="form-group">
                                <label for="contenido_en">Content:</label>
                                <textarea class="form-control @error('contenido_en') is-invalid @enderror"
                                    name="contenido_en" id="contenido_en" 
                                    cols="30" rows="5">{{ old('contenido_en', $articulo->contenido_en) }}</textarea>
                                
                                @error('contenido_en')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <hr>
                    <!-- FIN SECCIÓN CARGA DEL ARTÍCULO EN INGLES -->

                        <!-- Opciones de editar archivos o no -->
                        <label for="">¿Deseas editar los archivos?</label>
                        <div class="form-group">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="editArchive" id="inlineRadio1" value="1">
                                <label class="form-check-label" for="inlineRadio1">Si</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="editArchive" id="inlineRadio2" value="0" checked="checked">
                                <label class="form-check-label" for="inlineRadio2">No</label>
                            </div>
                        </div>

                        <!-- Documentos Cargados -->
                        <label for="">Archivos del Artículo:</label>
                        <div class="row mb-2">
                            <div class="col-12">
                                @forelse($articulo->archivos as $archivo)
                                    <div id="div_arch_{{ $archivo->id_archivo }}">
                                        <input type="hidden" name="loaded[]" id="archivo_{{ $archivo->id_archivo }}"
                                        value="{{ $archivo->ruta_archivo_es }}">
                                        <a href="{{ route('articulo.archivo', ['filename' => basename($archivo->ruta_archivo_es)]) }}" target="_blank" 
                                            class="btn btn-light btn-icon-split mb-1">
                                            <span class="icon text-gray-600" style="width: 50px;">
                                                @switch($archivo->tipo)
                                                    @case('pdf')<i class="fas fa-file-pdf"></i>@break
                                                    @default <i class="fas fa-image"></i>
                                                @endswitch
                                            </span>
                                            <span class="text">{{ $archivo->nombre }}</span>
                                        </a>
                                        <a style="display: none" name="{{ $archivo->id_archivo }}"
                                            class="btn btn-danger btn-circle btn-sm load_archives btn_erase">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                @empty
                                    No posee archivos linkeados...
                                @endforelse
                            </div>
                        </div>

                        <!-- Documentos del Artículo -->
                        <div class="form-group load_archives" style="display: none">
                            <div class="form-group files">
                                <input type="file" class="form-control @error('archivos.*') is-invalid @enderror" 
                                    name="archivos[]" multiple="" id="archivos" accept=".pdf, .html">
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
                            Editar Artículo
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
                                    {{ old("titulo", $articulo->titulo) }}
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="text-center">
                                    <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" width="100%" height="100%"
                                        src="{{ route('articulo.imagen', ['filename' => basename($articulo->ruta_imagen_es)]) }}" id="preImagen">
                                </div>
                                <div class="text-center">
                                    <h6 class="text-dark">
                                        <span id="preAutor">{{ old("autor", $articulo->autor ? $articulo->autor->nombre : "Sin Autor") }}</span> - 
                                        <span id="preArea" class="badge badge-pill badge-primary">{{ old("area", $articulo->conocimiento->nombre) }}</span>
                                    </h6>
                                </div>
                                <h6 class="text-dark">
                                    <span class="font-weight-bold">Edición</span>:
                                    <span id="preEdicion">{{ old("edicion", $articulo->edicion->titulo) }}</span>
                                </h6>
                                <p id="preDescrip" class="text-justify">
                                    {{ old("contenido", $articulo->contenido) }}
                                </p>
                                <div class="d-block">
                                    <button class="btn btn-info btn-circle">
                                        <i class="fas fa-comment"></i>
                                    </button>
                                    {{ $articulo->comentarios->count() }} Comentarios
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

        //activar la edición de los archivos
            $('input[name="editArchive"]').change(function() {
                let selected = $('input[name="editArchive"]:checked').val();
                
                if(selected == 1){
                    $('.load_archives').slideDown();
                }
                else{
                    $('.load_archives').slideUp();
                }
            });

        //activar la edición del contenido en ingles
            $('input[name="editEnglish"]').change(function() {
                let selected = $('input[name="editEnglish"]:checked').val();
                
                if(selected == 1){
                    $('.load_english').slideDown();
                }
                else{
                    $('.load_english').slideUp();
                }
            });

        //delete de archivo que ya este almacenado
            $('.btn_erase').click(function() {
                let id = $(this).attr('name');

                $('#div_arch_'+id).fadeOut();
                $('#archivo_'+id).remove();
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