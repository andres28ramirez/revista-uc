@extends('layouts.user.app')

@section('content')

    <div class="main">
        <br>
        <div class="container">
            <div class="title-sections">
                <h4>{{ __('Parametro de busqueda') }}: <b>{{ $param }}</b></h4>
            </div>
            <hr>

            <div class="container mt-5">
                @forelse($articulos as $articulo)
                    @include('layouts.article', ["artículo" => $articulo])
                @empty
                    <div class="text-center pb-5 font-weight-bold text-gray-600">
                        El parametro de busqueda no tiene registros de artículos que coincidan.
                    </div>
                @endforelse
                <br>
            </div>

            {{ $articulos->links() }}
        </div>
    </div>
@endsection