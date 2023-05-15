<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="Panel Web de la Revista Cientifíca de La Universidad de Margarita (UNIMAR)">
        <meta name="author" content="Universidad de Margarita (UNIMAR)">

        <title>Unimar Científica</title>
        <link  rel="icon" href="{{asset('images/rcu-orange-isotype.png')}}" type="image/png"/>

        <!-- RECURSOS -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/fontawesome.min.css">
        <link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css') }}">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
        <link rel="stylesheet" href="{{asset('css/comments.css') }}">
        <link rel="stylesheet" href="{{ asset('css/styles.css') }}">

    </head>

    <body>
        <div class=".container-xl">
            @include('layouts.user.navbar');
            
            <!-- alerta de finalización de procesos o notificaciones -->
            @if(Session::has('bderror'))
                <div class="pt-2 container font-weight-bold text-center alert alert-danger" style="margin-bottom: 1%">
                    {{ Session::get('bderror') }}
                </div>
            @endif

            @if(Session::has('success'))
                <div class="pt-2 container font-weight-bold text-center alert alert-success" style="margin-bottom: 1%">
                    {{ Session::get('success') }}
                </div>
            @endif
            
            @if(Session::has('warning'))
                <div class="pt-2 container font-weight-bold text-center alert alert-warning" style="margin-bottom: 1%">
                    {{ Session::get('warning') }}
                </div>
            @endif

            @yield('content')
            
            @include('layouts.user.footer');

            @include('layouts.user.login')

            @include('layouts.user.register')
        </div>

        <!-- Input para los errores del login o del registro -->
        @if($errors->any())
            <input type="hidden" id="loginerror" value=1>
        @endif
        @if($errors->register->any())
            <input type="hidden" id="registererror" value=1>
        @endif
    </body>
</html>

<!-- RECURSOS -->
<script src="{{ asset('jquery/jquery.min.js') }}"></script>
<script src="{{ asset('jquery-easing/jquery.easing.min.js') }}"></script>
<script src="{{ asset('bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('js/sb-admin-2.min.js') }}"></script>
<script src="{{ asset('js/script.js') }}"></script>

<script>
    $(document).ready(function() {
        //enseña el modal de login si hubo un error
        if($('#loginerror').length > 0){
            $('#loginModal').modal('show');
            $('.invalid-feedback').css('display', 'block');
        }

        if($('#registererror').length > 0){
            $('#singinModal').modal('show');
            $('.invalid-feedback').css('display', 'block');
        }
    });
</script>