@extends('layouts.admin.app')

@section('content')
<div class="container-fluid">
    
    <!-- TABLA -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                {{ $informacion ? "Editando Información seleccionada" : "Crear una nueva Info en Acerca de..."}}
            </h6>
        </div>

        <!-- CREAR NUEVA EDICIÓN -->
        <div class="card-header py-3" style="border-bottom: 0px;">
            <a href="{{ route('configuracion.informaciones') }}" class="btn btn-secondary btn-icon-split">
                <span class="icon text-white-50">
                    <i class="fas fa-rotate-left"></i>
                </span>
                <span class="text">Regresar a todas las informaciones</span>
            </a>
        </div>

        <div class="card-body container">
            <div class="row">
                <!-- formulario de creación o update de información -->
                <div class="col-sm">
                    <form method="POST" enctype="multipart/form-data" action="{{ $informacion ? route('configuración.info.update', $informacion->id_informacion) : route('configuración.info.store') }}">
                        @csrf
                        
                        <!-- titulo -->
                        <div class="form-group">
                            <label for="titulo">Título:</label>
                            <input type="text" class="form-control @error('titulo') is-invalid @enderror" 
                                id="titulo" 
                                name="titulo"
                                value="{{ $informacion ? old('titulo', $informacion->titulo) : old('titulo') }}" required
                                placeholder="Título de preliminar para la información...">
                            
                            @error('titulo')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Contenido de la Información -->
                        <div class="form-group">
                            <label for="contenido">Contenido:</label>
                            <textarea class="form-control @error('contenido') is-invalid @enderror"
                                name="contenido" id="contenido" required
                                cols="30" rows="5">{{ $informacion ? old('contenido', $informacion->contenido) : old('contenido') }}</textarea>
                            
                            @error('contenido')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        @if($informacion->ruta_archivo)
                            <!-- Opciones de editar archivos o no -->
                            <label for="">¿Deseas editar el archivo?</label>
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

                            <!-- Documentos Cargado -->
                            <label for="">Archivo Cargado:</label>
                            <div class="row mb-2">
                                <div class="col-12">
                                    <div id="div_arch_{{ $informacion->id_informacion }}">
                                        <input type="hidden" name="loaded" id="archivo_{{ $informacion->id_informacion }}"
                                        value="{{ $informacion->ruta_archivo }}">
                                        <a href="{{ route('configuracion.info.archivo', ['filename' => basename($informacion->ruta_archivo)]) }}" target="_blank" 
                                            class="btn btn-light btn-icon-split mb-1">
                                            <span class="icon text-gray-600" style="width: 50px;">
                                                @switch(pathinfo($informacion->ruta_archivo)['extension'])
                                                    @case('pdf')<i class="fas fa-file-pdf"></i>@break
                                                    @default <i class="fas fa-image"></i>
                                                @endswitch
                                            </span>
                                            <span class="text">Documento Cargado...</span>
                                        </a>
                                        <a style="display: none" name="{{ $informacion->id_informacion }}"
                                            class="btn btn-danger btn-circle btn-sm load_archives btn_erase">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Documento de la Información -->
                        <div class="form-group load_archives" 
                            style="display: <?php echo $informacion->ruta_archivo ? 'none' : '' ?>">
                            <label for="ruta_archivo">Archivo anclado a la información: Opcional*</label>

                            <div class="custom-file">
                                <input type="file" name="ruta_archivo"
                                    class="custom-file-input @error('ruta_archivo') is-invalid @enderror" id="archivo">
                                @error('ruta_archivo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <label class="custom-file-label" for="ruta_archivo">Selecciona un archivo</label>
                            </div>
                            <div id="files_names">

                            </div>
                        </div>

                        <button type="submit" class="btn btn-success mt-2">
                            {{ $informacion ? "Editar Información" : "Crear Información" }}
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
                            <div class="col-12">
                                <div class="card-body">
                                    <h6 class="font-weight-bold" id="preTitulo">{{ $informacion ? $informacion->titulo : "Título de la Información" }}</h6>
                                    <p><b>Fecha de Publicación: </b> <span id="preFecha">{{date('Y-m-d')}}</span></p>
                                    <p id="preDescrip" style="white-space: pre-line">
                                        {{ $informacion ? $informacion->contenido : "Texto de la Información" }}
                                    </p>
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

            $('#archivo').change(function() {
                var files = $('#archivo').get(0).files;

                $('#files_names').empty();
                $.each(files, function(_, file) {
                    $('#files_names').append('<label class="d-block">'+file.name+'</label>');
                });
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

        //delete de archivo que ya este almacenado
            $('.btn_erase').click(function() {
                let id = $(this).attr('name');

                $('#div_arch_'+id).fadeOut();
                $('#archivo_'+id).remove();
            });
    });
</script>