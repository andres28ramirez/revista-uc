@extends('layouts.user.app')

@section('content')

    <div class="main">
        <br>
        <div class="container">
            <div class="title-sections">
                <h4>{{ __('Ámbitos de Conocimiento') }}</h4>
            </div>
            <hr>

            <div class="container mt-5">
                @forelse($conocimiento->articulos as $articulo)
                    @include('layouts.article', ["artículo" => $articulo])
                @empty
                    <div class="text-center pb-5 font-weight-bold text-gray-600">
                        {{ __('El conocimiento aun no posee artículos registrados.') }}
                    </div>
                @endforelse
                <br>
            </div>
        </div>
    </div>
@endsection