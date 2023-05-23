@extends('layouts.user.app')

@section('content')
<div class="main">
    <br>
    <div class="container">
        <div class="title-author">
            <h4>{{ __('Catálogo de Autores') }}</h4>
        </div>
        <hr>
        <div class="list-group">
            @forelse($autores as $autor)
                @include('layouts.author', ["autor" => $autor])
            @empty
                <div class="text-center pb-5 font-weight-bold text-gray-600">
                    {{ __('No hay autores registrados en el sistema') }}.
                </div>
            @endforelse
        </div>
    </div>
    <br>
</div>
@endsection 