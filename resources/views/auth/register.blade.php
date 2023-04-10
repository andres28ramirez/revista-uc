<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- METADATOS -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Registro por página alterna de la revista cientifíca | UNIMAR">
    <meta name="author" content="Universidad de Margarita (UNIMAR)">

    <!-- ICONO Y TITULO -->
    <title>Unimar Científica - Registro</title>
    <link  rel="icon" href="{{asset('images/rcu-orange-isotype.png')}}" type="image/png"/>

    <!-- RECURSOS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/fontawesome.min.css">
    <link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link rel="stylesheet" href="{{asset('css/sb-admin-2.min.css') }}">

</head>

<body>
<div class="container mt-5 bg-primary">
    <!-- Outer Row -->
    <div class="row justify-content-center">
        <div class="col-xl-10 col-lg-12 col-md-9">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <div class="row">
                        <!-- IMAGEN DE RESETAR CONTRASEÑA -->
                        <div class="col-lg-6 d-none d-lg-block bg-password-image"></div>
                        <div class="col-lg-6 bg-white">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 font-weight-bold mb-2">{{ __('Registro') }}</h1>
                                </div>

                                @if(Session::has('status'))
                                    <div class="alert alert-success" role="alert">
                                        {{ Session::get('status') }}    
                                    </div>
                                @endif

                                <form class="user" method="POST" action="{{ route('register') }}">
                                    @csrf
                                    
                                    <!-- NOMBRE -->
                                    <div class="nombre">
                                        <div class="form-group">
                                            <input id="name" type="text" class="form-control form-control-user py-0 {{ $errors->register->first('name') ? 'is-invalid' : '' }}" 
                                                name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="{{__('Nombre')}}...">
                                            @if($errors->register->first('name'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ __($errors->register->first('name')) }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <!-- APELLIDO -->
                                    <div class="apellido">
                                        <div class="form-group">
                                            <input id="lastname" type="text" class="form-control form-control-user py-0 {{$errors->register->first('lastname') ? 'is-invalid' : ''}} " name="lastname" value="{{ old('lastname') }}" required autocomplete="lastname" autofocus placeholder="{{__('Apellido')}}...">
                                                @if($errors->register->first('lastname'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ __($errors->register->first('lastname')) }}</strong>
                                                    </span>
                                                @endif
                                        </div>
                                    </div>
                                    
                                    <!-- TELEFONO -->
                                    <div class="telefono row mb-3" style="box-shadow: 0px 0px !important;">
                                        <div class="col-4">
                                            <select id="code" type="text" class="form-control form-control-user py-0" name="code">
                                                <option value="412" {{ old('code') == "412" ? "selected" : ""}}>412</option>
                                                <option value="414" {{ old('code') == "414" ? "selected" : ""}}>414</option>
                                                <option value="424" {{ old('code') == "424" ? "selected" : ""}}>424</option>
                                                <option value="416" {{ old('code') == "416" ? "selected" : ""}}>416</option>
                                                <option value="426" {{ old('code') == "426" ? "selected" : ""}}>426</option>
                                            </select>
                                        </div>
                                        <div class="col">
                                            <input id="telephone" type="text" class="form-control form-control-user py-0 {{$errors->register->first('telephone') ? 'is-invalid' : ''}}" name="telephone" value="{{ old('telephone') }}" autofocus placeholder="{{__('Teléfono')}}...">
                                        </div>
                                        <div class="col-12">
                                            @if($errors->register->first('telephone'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ __($errors->register->first('telephone')) }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <!-- TIPO DE USUARIO -->
                                    <div class="tipo">
                                        <div class="form-group">
                                            <select id="user_tipo" type="text" class="form-control form-control-user py-0" name="user_tipo" required>
                                                <?php $type_users = \App\Models\Usuario_Tipo::orderBy('nombre', 'asc')->get() ?>
                                                <option value="" selected>{{__('Selecciona un tipo de Usuario')}}...</option>
                                                @foreach($type_users as $type)
                                                    <option value="{{ $type->id_tipo }}" {{ old('user_tipo') == $type->id_tipo ? "selected" : ""}}>{{ $type->nombre }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <!-- DIRECCIÓN -->
                                    <div class="direccion">
                                        <h6 style="font-size: 0.85rem !important;">{{__('Dirección')}} *Opcional:</h6>
                                        <div class="form-group">
                                            <textarea class="form-control form-control-user py-0 {{$errors->register->first('address') ? 'is-invalid' : ''}}" id="" name="address">{{ old('address') }}</textarea>
                                                @if($errors->register->first('address'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ __($errors->register->first('address')) }}</strong>
                                                    </span>
                                                @endif
                                        </div>
                                    </div>

                                    <!-- CORREO ELECTRÓNICO -->
                                    <div class="form-group">
                                        <input type="email" class="form-control form-control-user py-0 {{$errors->register->first('email') ? 'is-invalid' : ''}}"
                                            id="exampleInputEmail" aria-describedby="emailHelp"
                                            name="email"
                                            value="{{ old('email') }}" required
                                            placeholder="{{__('Correo Electrónico')}}...">

                                        @if($errors->register->first('email'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ __($errors->register->first('email')) }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <!-- CONTRASEÑA -->
                                    <div class="contraseña">
                                        <div class="form-group">
                                            <input id="password" type="password" class="form-control form-control-user py-0 {{$errors->register->first('password') ? 'is-invalid' : ''}}" name="password" required autocomplete="new-password" autofocus placeholder="{{__('Contraseña')}}...">
                                                @if($errors->register->first('password'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ __($errors->register->first('password')) }}</strong>
                                                    </span>
                                                @endif
                                        </div>
                                    </div>

                                    <!-- CONFIRMAR -->
                                    <div class="confirmar">
                                        <div class="form-group">
                                            <input id="password-confirm" type="password" class="form-control form-control-user py-0 {{$errors->register->first('password_confirmation') ? 'is-invalid' : ''}}" name="password_confirmation" required autocomplete="new-password" autofocus placeholder="{{__('Confirmación de Contraseña')}}...">
                                                @if($errors->register->first('password_confirmation'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ __($errors->register->first('password_confirmation')) }}</strong>
                                                    </span>
                                                @endif
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-primary btn-user btn-block">
                                        {{__('Enviar')}}
                                    </button>
                                </form>

                                <hr>
                                <div class="text-center">
                                    <a class="small" href="{{ route('login') }}">{{__('Ya posees una cuenta? Inicia Sesión')}}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>

<!-- RECURSOS -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
<script src="{{ asset('js/script.js') }}"></script>

<script>
    $(document).ready(function() {
        //enseña el modal de login si hubo un error
        
    });
</script>

