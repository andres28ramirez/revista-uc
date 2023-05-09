@extends('layouts.admin.app')

@section('content')
<div class="container-fluid">
    
    <!-- TABLA -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                Modificación de la Información del Perfil
            </h6>
        </div>

        <div class="card-body container">
            <div class="row">
                <!-- formulario de creación o update de usuario -->
                <div class="col-lg-6">
                    <form method="POST" enctype="multipart/form-data" action="{{ route('perfil.update') }}">
                        @csrf
                        
                        <!-- Nombre -->
                        <div class="form-group">
                            <label for="nombre">Nombres:</label>
                            <input type="text" class="form-control @error('nombre') is-invalid @enderror" 
                                id="nombre" 
                                name="nombre"
                                value="{{ $usuario ? old('nombre', $usuario->perfil->nombre) : old('nombre') }}" required
                                placeholder="Nombre del Usuario...">
                            
                            @error('nombre')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Apellido -->
                        <div class="form-group">
                            <label for="apellido">Apellidos:</label>
                            <input type="text" class="form-control @error('apellido') is-invalid @enderror" 
                                id="apellido" 
                                name="apellido"
                                value="{{ $usuario ? old('apellido', $usuario->perfil->apellido) : old('apellido') }}" required
                                placeholder="Apellido del Usuario...">
                            
                            @error('apellido')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Correo -->
                        <div class="form-group">
                            <label for="email">Correo Electrónico:</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                id="email" 
                                name="email"
                                value="{{ $usuario ? old('email', $usuario->email) : old('email') }}" required
                                placeholder="Email del Usuario...">
                            
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Dirección de Hogar -->
                        <div class="form-group">
                            <label for="direccion">Dirección: <em>*Opcional</em></label>
                            <textarea class="form-control @error('direccion') is-invalid @enderror"
                                name="direccion" id="direccion"
                                cols="30" rows="5">{{ $usuario ? old('direccion', $usuario->perfil->direccion) : old('direccion') }}</textarea>
                            @error('direccion')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Telefono de Hogar -->
                        <div class="form-group row">
                            <label for="" class="col-12">Teléfono: <em>*Opcional</em></label>
                            <div class="input-group col-4">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fas fa-phone"></i></div>
                                </div>
                                <select id="code" type="text" class="form-control" name="code">
                                    <option value="412" {{ old('code', $usuario ? substr($usuario->perfil->telefono, 0, 3) : "") == "412" ? "selected" : ""}}>412</option>
                                    <option value="414" {{ old('code', $usuario ? substr($usuario->perfil->telefono, 0, 3) : "") == "414" ? "selected" : ""}}>414</option>
                                    <option value="424" {{ old('code', $usuario ? substr($usuario->perfil->telefono, 0, 3) : "") == "424" ? "selected" : ""}}>424</option>
                                    <option value="416" {{ old('code', $usuario ? substr($usuario->perfil->telefono, 0, 3) : "") == "416" ? "selected" : ""}}>416</option>
                                    <option value="426" {{ old('code', $usuario ? substr($usuario->perfil->telefono, 0, 3) : "") == "426" ? "selected" : ""}}>426</option>
                                </select>
                            </div>

                            <div class="col-8">
                                <input id="telefono" type="text" class="form-control @error('telefono') 'is-invalid' @enderror" name="telefono" 
                                        value="{{ $usuario ? old('telefono', substr($usuario->perfil->telefono, 3)) : old('telefono') }}" placeholder="Teléfono del Usuario...">
                            </div>
                            <div class="col-12">
                                @error('telefono')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Solo en edición de usuario contraseña -->
                        @if($usuario)
                            <label for="">¿Deseas modificar la contraseña?</label>
                            <div class="form-group">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="editPass" id="inlineRadio1" value="1">
                                    <label class="form-check-label" for="inlineRadio1">Si</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="editPass" id="inlineRadio2" value="0" checked="checked">
                                    <label class="form-check-label" for="inlineRadio2">No</label>
                                </div>
                            </div>
                        @endif

                        <!-- Contraseña -->
                        <div class="form-group edit_password" style="<?php echo $usuario ? 'display: none' : '' ?>">
                            <h6>Nueva Contraseña:</h6>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fa fa-lock"></i></div>
                                </div>
                                <input id="password" type="password" class="form-control @error('password') 'is-invalid' @endif" name="password" autocomplete="new-password" autofocus placeholder="Contraseña">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Confirmar contraseña -->
                        <div class="form-group edit_password" style="<?php echo $usuario ? 'display: none' : '' ?>">
                            <h6>Confirmación de Contraseña:</h6>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fa fa-lock"></i></div>
                                </div>
                                <input id="password-confirm" type="password" class="form-control @error('password-confirm') 'is-invalid' @enderror" name="password_confirmation" autocomplete="new-password" autofocus placeholder="Confirmación de Contraseña...">
                                @error('password-confirm')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Contraseña Vieja para convalidar cambios -->
                        <div class="form-group">
                            <h6>Ingresa tu antigua Contraseña para validar los cambios:</h6>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fa fa-lock"></i></div>
                                </div>
                                <input id="last_password" type="password" class="form-control @error('last_password') 'is-invalid' @endif" name="last_password" autocomplete="last_password" required placeholder="Digitá tu antigua contraseña">
                                @error('last_password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <button type="submit" class="btn btn-success mt-2">
                            {{ "Editar Información" }}
                        </button>
                    </form>
                </div>

                <!-- previsualización -->
                <div class="col-lg-6">
                    <div class="text-center">
                        <h5>Previsualización del Contenido</h5>
                    </div>
                    
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="card-body">
                                    <p><b>Nombres: </b> <span id="preNombre">{{ $usuario ? $usuario->perfil->nombre : old("nombre", "Will Andres") }}</span></p>
                                    <p><b>Apellidos: </b> <span id="preApellido">{{ $usuario ? $usuario->perfil->apellido : old("apellido", "Smith Cuccittini") }}</span></p>
                                    <p><b>Email: </b> <span id="preEmail">{{ $usuario ? $usuario->email : old("email", "ejemplo@unimar.edu.ve") }}</span></p>
                                    <p><b>Dirección: </b><br> <span id="preDireccion">{{ $usuario ? $usuario->perfil->direccion : old("direccion", "...") }}</span></p>
                                    <p><b>Teléfono: </b> <span id="preTelefono">{{ $usuario ? $usuario->perfil->telefono : old("telefono", "0412-1234567") }}</span></p>
                                    <p><b>Tipo de Usuario: </b> <span id="preTipo">{{ $usuario ? $usuario->perfil->tipo->nombre : old("FK_id_tipo", "Estudiante") }}</span></p>
                                    <p><b>Rol de Usuario: </b> <span id="preRol">{{ $usuario ? $usuario->urol->rol->nombre : old("FK_id_rol", "Usuario") }}</span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>

</div>

@if($errors->any())
    <input type="hidden" id="errores_show" value=1>
@endif

@endsection

<script src="{{ asset('jquery/jquery.min.js') }}"></script>
<script>
    $(document).ready(function() {
        //Nombre del Usuario
        $('#nombre').change(function() {
            $('#preNombre').text($(this).val());
        });

        $('#apellido').change(function() {
            $('#preApellido').text($(this).val());
        });

        $('#email').change(function() {
            $('#preEmail').text($(this).val());
        });

        $('#direccion').change(function() {
            $('#preDireccion').text($(this).val());
        });

        $('#telefono').change(function() {
            let telefono = $(this).val();
            let code = $('#code').val();
            $('#preTelefono').text(code+"-"+telefono);
        });
        
        $('#FK_id_tipo').change(function() {
            let texto = $( "#FK_id_tipo option:selected" ).text();
            $('#preTipo').text(texto);
        });

        $('#FK_id_rol').change(function() {
            let texto = $( "#FK_id_rol option:selected" ).text();
            $('#preRol').text(texto);
        });

        //activar la edición de password
        $('input[name="editPass"]').change(function() {
            let selected = $('input[name="editPass"]:checked').val();
            
            if(selected == 1){
                $('.edit_password').slideDown();
            }
            else{
                $('.edit_password').slideUp();
            }
        });

        //enseña los factous
        if($('#errores_show').length > 0){
            $('.invalid-feedback').css('display', 'block');
        }
    });
</script>