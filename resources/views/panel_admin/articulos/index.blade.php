@extends('layouts.admin.app')

@section('content')
<div class="container-fluid">
    


    <!-- TABLA -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Artículos y Ediciones cargadas en sistema</h6>
        </div>

        <!-- VER TODOS LOS ARTÍCULOS -->
        <div class="card-header" style="border-bottom: 0px; margin-bottom: -1%">
            <a href="{{ route('articulo.all') }}" class="btn btn-primary btn-icon-split">
                <span class="icon text-white-50">
                    <i class="fas fa-eye"></i>
                </span>
                <span class="text">Ver todos los Artículos</span>
            </a>
        </div>

        <!-- CREAR NUEVA EDICIÓN -->
        @if($ediciones->count() > 0)
            <div class="card-header" style="border-bottom: 0px;">
                <a href="{{ route('articulo.create') }}" class="btn btn-success btn-icon-split">
                    <span class="icon text-white-50">
                        <i class="fas fa-plus"></i>
                    </span>
                    <span class="text">Crear un nuevo Artículo</span>
                </a>
            </div>
        @endif

        <div class="card-body">
            <!-- Acordion de Ediciones -->
            <div id="accordion-ediciones">
                <div class="card">
                    <div class="card-header text-center" id="headingOne" style="cursor: pointer"
                    data-toggle="collapse" data-target="#acordionEdiciones" aria-expanded="true" aria-controls="collapseAccordion">
                        <h6 class="mb-0">
                            <span class="w-100">
                                <span class="font-weight-bold">Todas las Ediciones</span><br>(Presiona sobre uno de ellos para ver todos sus artículos)
                            </span>
                        </h6>
                    </div>

                    <div id="acordionEdiciones" class="collapse" aria-labelledby="headingOne" data-parent="#acordionEdiciones">
                        @forelse($ediciones as $edicion)
                            <a class="text-dark"
                                href="{{ route('articulo.all', $edicion->id_edicion) }}">
                                <div class="card-body border">
                                    {{ $edicion->titulo }} - Nro. Artículos en la edicion (<span class="font-weight-bold">{{ $edicion->articulos->count() }}</span>).
                                </div>
                            </a>
                        @empty
                            <div class="card-body border">
                                No hay ediciones cargadas, por favor carga alguna para que puedas gestionar nuevos artículos...
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Ultimos 6 Artículos Cargados en el sistema -->
            <div class="py-4">
                <h6 class="m-0 font-weight-bold text-primary">Ultimos 6 Artículos Cargados</h6>
            </div>

            <div class="row justify-content-center">

                <!-- Artículo -->
                <div class="col-lg-6">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Título</h6>
                        </div>
                        <div class="card-body">
                            <div class="text-center">
                                <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" width="100%" height="100%"
                                    src="{{ asset('images/nodisponible.png') }}" alt="...">
                            </div>
                            <h6 class="text-dark">Edición - PRUEBA</h6>
                            <p>
                                Add some quality, svg illustrations to your project courtesy of a
                                constantly updated collection of beautiful svg images that you can use
                                completely free and without attribution!
                            </p>
                            <div class="d-block">
                                <button class="btn btn-info btn-circle">
                                    <i class="fas fa-comment"></i>
                                </button>
                                25 Comentarios
                            </div>
                            <div class="d-block text-center">
                                <a target="_blank" rel="nofollow" href="#">
                                    Abrir Artículo &rarr;
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
        </div>
    </div>

</div>
@endsection

<script src="{{ asset('jquery/jquery.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        
        $('.btn-delete').click(function(){
            var id = $(this).attr('name');

            Swal.fire({
                title: 'Estas seguro de elimnar la edición?',
                text: "No podras revertir esta elección, esto borrara todos los artículos anclados a la edición!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#084456',
                cancelButtonColor: '#bbbbbb',
                confirmButtonText: 'Si, eliminalo!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire(
                        'Eliminando!',
                        'La edición sera procesada para ser eliminada de los registros.',
                        'success'
                    );
                    setTimeout(function() { 
                        $( "#delete-edicion-"+id ).submit();
                    }, 2000);
                }
            });
        });
    });
</script>