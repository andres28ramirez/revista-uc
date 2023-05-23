@extends('layouts.user.app')

@section('content')
<div class="main py-3">
<br>
    <div class="container" >
        <div class="title-sections">
            <h4 class="font-weight-bold">
                {{ __('Listado de Ediciones') }}
            </h4>
        </div>
        <hr>
        
        <!-- Listado de ediciones en la revista -->
        @forelse($ediciones as $edicion)
            @include('layouts.edition', ["edicion" => $edicion])
        @empty
            <div class="text-center pb-5 font-weight-bold text-gray-600">
                {{ __('No hay ediciones registradas en el sistema') }}.
            </div>
        @endforelse
    </div>
</div>
@endsection
