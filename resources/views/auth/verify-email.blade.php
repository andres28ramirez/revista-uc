<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- METADATOS -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Apartado de verificación de correo de la revista cientifíca">
    <meta name="author" content="Universidad de Margarita (UNIMAR)">

    <!-- ICONO Y TITULO -->
    <title>Unimar Científica - Verificación</title>
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
                        <!-- IMAGEN -->
                        <div style="background-image: url({{asset('images/logo-unimar.png')}}) !important; background-size: 75%; background-repeat: no-repeat;"
                            class="col-lg-6 d-none d-lg-block bg-password-image"></div>
                        <div class="col-lg-6 bg-white">
                            <div class="p-5">
                                <div class="text-center">
                                    <p class="text-gray-900 mb-2">
                                        {{ __('Gracias por registrarte! Antes de comenzar, ¿podría verificar su dirección de correo electrónico haciendo clic en el enlace que le acabamos de enviar? Si no recibiste el correo electrónico, con gusto te enviaremos otro.') }}
                                    </p>
                                </div>

                                @if (session('status') == 'verification-link-sent')
                                    <div class="alert alert-success mb-4 font-medium text-center" role="alert">
                                        {{ __('Se ha enviado un nuevo enlace de verificación a la dirección de correo electrónico que proporcionó durante el registro.') }}
                                    </div>
                                @endif

                                <div class="mt-4 flex items-center justify-between">
                                    <form method="POST" action="{{ route('verification.send') }}">
                                        @csrf

                                        <button type="submit" class="btn btn-primary btn-user btn-block mb-2">
                                            {{ __('Resend Verification Email') }}
                                        </button>
                                    </form>

                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf

                                        <button type="submit" class="btn btn-secondary btn-user btn-block">
                                            {{ __('Cerrar Sesión') }}
                                        </button>
                                    </form>
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