<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Unimar Científica</title>
        <link  rel="icon" href="{{asset('images/rcu-orange-isotype.png')}}" type="image/png"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css') }}">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('css/styles.css') }}">

    </head>

    <body>
        <div class=".container-xl">
            @include('layouts.user.navbar');

            <!-- ALERTA DE ERRORES -->
            @if(Session::has('bderror'))
                <div class="pt-2 container font-weight-bold text-center" style="background-color: #ac2925; color: #ffffff; margin-bottom: 1%">
                    {{ Session::get('bderror') }}
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

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
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