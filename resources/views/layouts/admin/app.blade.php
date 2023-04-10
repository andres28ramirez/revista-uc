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
        <title>Unimar Científica - Panel Admin</title>
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
        <div class=".container-xl">
            @yield('content')
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