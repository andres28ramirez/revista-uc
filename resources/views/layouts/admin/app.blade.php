<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- METADATOS -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Panel Administrativo de la Revista Cientifíca de La Universidad de Margarita (UNIMAR)">
    <meta name="author" content="Universidad de Margarita (UNIMAR)">

    <!-- ICONO Y TITULO -->
    <title>Unimar Científica - Panel Administrativo</title>
    <link  rel="icon" href="{{asset('images/rcu-orange-isotype.png')}}" type="image/png"/>

    <!-- RECURSOS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/fontawesome.min.css">
    <link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
    <link rel="stylesheet" href="{{asset('css/sb-admin-2.min.css') }}">
    <link rel="stylesheet" href="{{asset('datatables/dataTables.bootstrap4.min.css') }}">
</head>

<body id="page-top">
    <!-- CONTENEDOR GLOBAL -->
    <div id="wrapper">
        <!-- barra lateral de navegacion -->
        @include('layouts.admin.sidebar')

        <!-- wrapper del contenido central -->
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <!-- barra superior de navegacion -->
                @include('layouts.admin.navbar')

                <!-- contenido principal debajo del navbar -->
                <div class="container-fluid">

                    <!-- header que describe en que apartado de la página nos encontramos -->
                    @include('layouts.admin.header')

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

                    <!-- contenido que cambia de acuerdo al lugar donde nos encontremos -->
                    @yield('content')
                </div>
            </div>

            @include('layouts.admin.footer');
        </div>
    </div>
    <!-- FIN CONTENEDOR GLOBAL -->

    <!-- BOTON SCROLL PARA SUBIR HASTA ARRIBA-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
    <!-- FIN BOTON DE SCROLL -->
</body>

</html>

<!-- RECURSOS -->
<script src="{{ asset('jquery/jquery.min.js') }}"></script>
<script src="{{ asset('jquery-easing/jquery.easing.min.js') }}"></script>
<script src="{{ asset('bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('js/sb-admin-2.min.js') }}"></script>

<!-- Recursos de los data table -->
<script src="{{ asset('datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('datatables/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('js/demo/datatables-demo.js') }}"></script>

<!-- Recursos de los charts -->
<script src="{{ asset('chart.js/Chart.min.js') }}"></script>
<script src="{{ asset('js/demo/chart-area-demo.js') }}"></script>
<script src="{{ asset('js/demo/chart-pie-demo.js') }}"></script>

<script>
    $(document).ready(function() {
        
    });
</script>