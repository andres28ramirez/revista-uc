@extends('layouts.admin.app')

@section('title')
{{ "Autores" }}
@endsection

@section('content')
<div class="container-fluid">
    
    <!-- TABLA -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                {{ $autor ? "Editando Autor Seleccionado" : "Almacenando nuevo Autor"}}
            </h6>
        </div>

        <!-- CREAR NUEVO AUTOR -->
        <div class="card-header py-3" style="border-bottom: 0px;">
            <a href="{{ route('autor.index') }}" class="btn btn-secondary btn-icon-split">
                <span class="icon text-white-50">
                    <i class="fas fa-rotate-left"></i>
                </span>
                <span class="text">Regresar a todas los autores</span>
            </a>
        </div>

        <div class="card-body container">
            <div class="row">
                <!-- formulario de creación o update de autor -->
                <div class="col-sm">
                    <form method="POST" enctype="multipart/form-data" action="{{ $autor ? route('autor.update', $autor->id_autor) : route('autor.store') }}">
                        @csrf
                        
                        <!-- nombre -->
                        <div class="form-group">
                            <label for="nombre">Nombre Completo:</label>
                            <input type="text" class="form-control @error('nombre') is-invalid @enderror" 
                                id="nombre" 
                                name="nombre"
                                value="{{ $autor ? old('nombre', $autor->nombre) : old('nombre') }}" required
                                placeholder="Nombre del Autor...">
                            
                            @error('nombre')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Email del Autor -->
                        <div class="form-group">
                            <label for="email">Correo Electrónico: <em>Opcional *</em></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                id="email" 
                                name="email"
                                value="{{ $autor ? old('email', $autor->email) : old('email') }}"
                                placeholder="Digita el correo del Autor...">
                            
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Grado Educativo -->
                        <div class="form-group">
                            <label for="grado">Grado - Institución de la que proviene:</label>
                            <input type="text" class="form-control @error('grado') is-invalid @enderror" 
                                id="grado" 
                                name="grado"
                                value="{{ $autor ? old('grado', $autor->grado) : old('grado') }}" required
                                placeholder="Grado del Autor...">
                            
                            @error('grado')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Sintesis del Autor -->
                        <div class="form-group">
                            <label for="sintesis">Descripción:</label>
                            <textarea class="form-control @error('sintesis') is-invalid @enderror"
                                name="sintesis" id="sintesis" required
                                cols="30" rows="5">{{ $autor ? old('sintesis', $autor->sintesis) : old('sintesis') }}</textarea>
                            
                            @error('sintesis')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Imagen del Autor -->
                        <div class="form-group">
                            <label for="ruta_imagen">Imagen del Autor: <em>Opcional *</em></label>

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
                            {{ $autor ? "Editar Autor" : "Crear Autor" }}
                        </button>
                    </form>
                </div>

                <!-- previsualización -->
                <div class="col-sm">
                    <div class="text-center">
                        <h5>Previsualización del Autor</h5>
                    </div>
                    
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 text-center">
                                <img id="preImagen" 
                                    src="{{ $autor ? route('autor.imagen', ['filename' => basename($autor->ruta_imagen)]) : asset('images/nodisponible.png') }}" 
                                    class="img-fluid rounded-circle" height="200" width="200">
                            </div>
                            <div class="col-12">
                                <div class="card-body">
                                    <div class="text-center">
                                        <h6 class="font-weight-bold" id="preNombre">{{ $autor ? $autor->nombre : old("nombre", "Nombre del Autor") }}</h6>
                                        <p id="preGrado">
                                            {{ $autor ? $autor->grado : old("grado", "Institución del Autor") }}
                                        </p>
                                    </div>
                                    <p><b>Correo: </b> <span id="preEmail">{{ $autor ? $autor->email : old("email", "Opcional...") }}</span></p>
                                    <p id="preSintesis" class="text-justify">
                                        {{ $autor ? $autor->sintesis : old("sintesis", "Resumen del Autor...") }}
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
        $('#nombre').change(function() {
            $('#preNombre').text($(this).val());
        });

        $('#grado').change(function() {
            $('#preGrado').text($(this).val());
        });

        $('#sintesis').change(function() {
            $('#preSintesis').text($(this).val());
        });
        
        $('#email').change(function() {
            $('#preEmail').text($(this).val());
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