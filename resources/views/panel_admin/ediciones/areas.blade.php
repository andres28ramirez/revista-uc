@extends('layouts.admin.app')

@section('content')
<div class="container-fluid">
    
    <!-- TABLA -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Areas de Conocimiento</h6>
        </div>

        <div class="card-body">

            <!-- GLOBAL CON TOTALES -->
            <div class="row justify-content-center">

                <!-- TOTAL CONOCIMIENTOS -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card shadow h-100 py-2" style="border-left: 0.25rem solid #E65100!important;">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Areas de Conocimiento</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $areas->count() }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-flask fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ARTÍCULOS CARGADOS -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card shadow h-100 py-2" style="border-left: 0.25rem solid #084456!important;">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Total de Artículos Cargados</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $articulos->count() }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-newspaper fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- CONOCIMIENTO CON MÁS ARTÍCULOS -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card shadow h-100 py-2" style="border-left: 0.25rem solid #E65100!important;">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Area con más Artículos</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        {{ $max_area ? $max_area->nombre : "Sin artículos" }}
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-vial fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>

            <!-- CREAR NUEVA AREA -->
            <div class="card-header py-3" style="border-bottom: 0px;">
                <a href="" data-toggle="modal" data-target="#createModal"
                    class="btn btn-success btn-icon-split">
                    <span class="icon text-white-50">
                        <i class="fas fa-plus"></i>
                    </span>
                    <span class="text">Crea nueva area de conocimiento</span>
                </a>
            </div>

            <!-- TABLA CON EL CONTENIDO DE CONOCIMIENTOS Y BARRA PROGRESO-->
            <div class="row container">
                <!-- BARRA PROGRESO -->
                <div class="card shadow mb-4 col-md-6">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Areas y su Nro. de Artículos</h6>
                    </div>
                    <div class="card-body">
                        @forelse($areas as $area)
                            <h4 class="small font-weight-bold">{{ $area->nombre }} <span
                                    class="float-right">{{ $area->articulos->count() }}</span></h4>
                            <div class="progress mb-4">
                                <div class="progress-bar bg-gradient-danger" role="progressbar" 
                                    style="width: <?php echo $articulos->count() ? $area->articulos->count() * 100 / $articulos->count() : '0' ?>%"
                                    aria-valuenow="{{ $articulos->count() ? $area->articulos->count() * 100 / $articulos->count() : '0' }}" 
                                    aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        @empty
                            <p>No hay conocimientos cargados actualmente...</p>
                        @endforelse
                    </div>
                </div>

                <!-- TABLA -->
                <div class="table-responsive col-md-6">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th colspan="2" class="text-center">Area</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($areas as $area)
                            <tr class="text-center">
                                <td class="align-middle" id="nombre_{{ $area->id_conocimiento  }}">{{ $area->nombre }}</td>
                                <td class="align-middle" id="nombre_en_{{ $area->id_conocimiento  }}">{{ $area->nombre_en }}</td>
                                <td class="align-middle">
                                    <!-- Boton de Editar -->
                                    <button name="{{ $area->id_conocimiento  }}" 
                                        class="edit_area btn btn-info btn-circle btn-sm">
                                        <i class="fas fa-pencil"></i>
                                    </button>

                                    <!-- Boton de Eliminar -->
                                    <button name="{{ $area->id_conocimiento  }}" class="btn btn-danger btn-circle btn-sm area-delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    <form id="delete-area-{{ $area->id_conocimiento  }}" action="{{ route('edicion.conocimiento.delete', $area->id_conocimiento) }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

</div>

<!-- MODAL DE CREAR CONOCIMIENTO -->
<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModalLabel">Crear nueva Area de Conocimiento</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Formulario -->
            <form method="POST" action="{{ route('edicion.conocimiento.store') }}">
                @csrf
                <div class="modal-body">
                    <!-- Nombre en español -->
                    <div class="form-group">
                        <label for="exampleInputEmail1">Nombre del Area de Conocimiento</label>
                        <input type="text" class="form-control @error('nombre') is-invalid @enderror"
                            name="nombre" value="{{ old('nombre') }}"
                            id="nombre" placeholder="Digitá el nombre...">
                        @error('nombre')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            <input type="hidden" id="loginerror" value=1>
                        @enderror
                    </div>

                    <!-- Nombre en ingles -->
                    <div class="form-group">
                        <label for="exampleInputEmail1">Knowledge Area Name</label>
                        <input type="text" class="form-control @error('nombre_en') is-invalid @enderror"
                            name="nombre_en" value="{{ old('nombre_en') }}"
                            id="nombre_en" placeholder="Type the name...">
                        @error('nombre_en')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            <input type="hidden" id="loginerror" value=1>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success">Crear Conocimiento</button>
                </div>
            </form>
            <!-- Fin Formulario -->
        </div>
    </div>
</div>

<!-- MODAL DE EDITAR CONOCIMIENTO -->
<div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateModalLabel">Editar Area de Conocimiento Seleccionada</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Formulario -->
            <form method="POST" action="{{ route('edicion.conocimiento.update') }}">
                @csrf
                <div class="modal-body">
                    <input type="hidden" id="id_update" name="id_update" value="">
                    <!-- Nombre del area -->
                    <div class="form-group">
                        <label for="exampleInputEmail1">Nombre del Area de Conocimiento</label>
                        <input type="text" class="form-control {{$errors->update->first('nombre_update') ? 'is-invalid' : ''}}"
                            name="nombre_update" value="{{ old('nombre_update') }}"
                            id="nombre_update" placeholder="Digitá el nombre a actualizar...">
                        @if($errors->update->first('nombre_update'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->update->first('nombre_update') }}</strong>
                            </span>
                        @endif
                    </div>

                    <!-- Nombre del area en ingles -->
                    <div class="form-group">
                        <label for="nombre_update_en">Knowledge Area Name</label>
                        <input type="text" class="form-control {{$errors->update->first('nombre_update_en') ? 'is-invalid' : ''}}"
                            name="nombre_update_en" value="{{ old('nombre_update_en') }}"
                            id="nombre_update_en" placeholder="Type the name...">
                        @if($errors->update->first('nombre_update_en'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->update->first('nombre_update_en') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success">Actualizar Conocimiento</button>
                </div>
            </form>
            <!-- Fin Formulario -->
        </div>
    </div>
</div>

<!-- INPUTS DE MANIPULACIÓN DE ERRORES-->
@if($errors->any())
    <input type="hidden" id="createrror" value=1>
@endif
@if($errors->update->any())
    <input type="hidden" id="updaterror" value=1>
@endif

@endsection

<script src="{{ asset('jquery/jquery.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        //enseña el modal de create si hubo un error
        if($('#createrror').length > 0){
            $('#createModal').modal('show');
            $('.invalid-feedback').css('display', 'block');
        }

        //enseña el modal de update si hubo error
        if($('#updaterror').length > 0){
            $('#updateModal').modal('show');
            $('.invalid-feedback').css('display', 'block');
        }

        //click al boton de update para actualizar los datos del form
        $('.edit_area').click(function(){
            var id = $(this).attr('name');
            var nombre = $('#nombre_'+id).text();
            var nombre_en = $('#nombre_en_'+id).text();

            //Setteamos el Formulario
            $('#id_update').val(id); 
            $('#nombre_update').val(nombre);
            $('#nombre_update_en').val(nombre_en);

            //Mostramos Modal
            $('#updateModal').modal('show');
        });

        //click para eliminar area de conocimiento
        $('.area-delete').click(function(){
            var id = $(this).attr('name');

            Swal.fire({
                title: 'Estas seguro de elimnar el area seleccionada?',
                text: "No podras revertir esta elección, esto dejara algunos artículos sin area definida!",
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
                        'El area de conocimiento sera procesada para ser eliminada de los registros.',
                        'success'
                    );
                    setTimeout(function() { 
                        $( "#delete-area-"+id ).submit();
                    }, 2000);
                }
            });
        });
    });
</script>