<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- METADATOS -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Inicio de Sesión por página alterna de la revista cientifíca | UNIMAR">
    <meta name="author" content="Universidad de Margarita (UNIMAR)">

    <!-- ICONO Y TITULO -->
    <title>Unimar Científica - Login</title>
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
                        <div style="background-image: url({{asset('images/logo-unimar.png')}}) !important; background-size: 75%; background-repeat: no-repeat;"
                            class="col-lg-6 d-none d-lg-block bg-password-image"></div>
                        <div class="col-lg-6 bg-white">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-2">{{ __('Bienvenido de nuevo') }}</h1>
                                </div>

                                @if(Session::has('status'))
                                    <div class="alert alert-success" role="alert">
                                        {{ Session::get('status') }}    
                                    </div>
                                @endif

                                <form class="user" method="POST" action="{{ route('login') }}">
                                    @csrf
                                    
                                    <!-- CORREO ELECTRÓNICO -->
                                    <div class="form-group">
                                        <input type="email" class="form-control form-control-user @error('email') is-invalid @enderror"
                                            id="exampleInputEmail" aria-describedby="emailHelp"
                                            name="email"
                                            value="{{ old('email') }}" required
                                            placeholder="{{__('Correo Electrónico')}}...">

                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            <input type="hidden" id="loginerror" value=1>
                                        @enderror
                                    </div>

                                    <!-- PASSWORD -->
                                    <div class="form-group">
                                        <input type="password" class="form-control form-control-user @error('password') is-invalid @enderror"
                                            id="password" aria-describedby="password"
                                            name="password" required
                                            placeholder="{{__('Contraseña')}}...">

                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            <input type="hidden" id="loginerror" value=1>
                                        @enderror
                                    </div>

                                    <button type="submit" class="btn btn-primary btn-user btn-block">
                                        {{__('Iniciar Sesión')}}
                                    </button>
                                </form>

                                <hr>
                                <div class="text-center">
                                    <a class="small" href="{{ route('register') }}">{{__('Crear una Cuenta!')}}</a>
                                </div>
                                <div class="text-center">
                                    @if (Route::has('password.request'))
                                    <a class="small" href="{{ route('password.request') }}">{{__('¿Olvidó su contraseña?')}}</a>
                                    @endif
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
