@extends('layouts.admin.app')

@section('title')
{{ "Tipos de Usuarios" }}
@endsection

@section('content')
<div class="container-fluid">
    
    <!-- TABLA -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Infomación general de los Tipos de Usuario</h6>
        </div>

        <div class="card-body">

            <!-- GLOBAL CON TOTALES -->
            <div class="row justify-content-center">

                <!-- TOTAL USUARIOS -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card shadow h-100 py-2" style="border-left: 0.25rem solid #E65100!important;">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Tipos de Usuario</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $tipos->count() }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-users fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- NRO DE USUARIOS -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card shadow h-100 py-2" style="border-left: 0.25rem solid #084456!important;">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Total de Usuarios</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $perfiles->count() }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-user fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- VISITANTES -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card shadow h-100 py-2" style="border-left: 0.25rem solid #E65100!important;">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Usuarios Visitantes</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        {{ $tipos->where('nombre', 'Visitante')->count() }}
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-user-tie fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>

            <!-- CREAR NUEVO TIPO DE USUARIO -->
            <div class="card-header py-3" style="border-bottom: 0px;">
                <a href="" data-toggle="modal" data-target="#createModal"
                    class="btn btn-success btn-icon-split">
                    <span class="icon text-white-50">
                        <i class="fas fa-plus"></i>
                    </span>
                    <span class="text">Crea un nuevo Tipo de Usuario</span>
                </a>
            </div>

            <!-- TABLA CON EL CONTENIDO DE TIPOS DE USUARIO Y BARRA PROGRESO-->
            <div class="row container">
                <!-- BARRA PROGRESO -->
                <div class="card shadow mb-4 col-md-6">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Tipos y su Nro. de Usuarios</h6>
                    </div>
                    <div class="card-body">
                        @forelse($tipos as $tipo)
                            <h4 class="small font-weight-bold">{{ $tipo->nombre }} <span
                                    class="float-right">{{ $tipo->perfiles->count() }}</span></h4>
                            <div class="progress mb-4">
                                <div class="progress-bar bg-gradient-danger" role="progressbar" 
                                    style="width: <?php echo $perfiles->count() ? $tipo->perfiles->count() * 100 / $perfiles->count() : '0' ?>%"
                                    aria-valuenow="{{ $perfiles->count() ? $tipo->perfiles->count() * 100 / $perfiles->count() : '0' }}" 
                                    aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        @empty
                            <p>No hay roles cargados actualmente...</p>
                        @endforelse
                    </div>
                </div>

                <!-- TABLA -->
                <div class="table-responsive col-md-6">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Tipo de Usuario</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tipos as $tipo)
                                <tr class="text-center">
                                    <td class="align-middle" id="nombre_{{ $tipo->id_tipo }}">{{ $tipo->nombre }}</td>
                                    <td class="align-middle">
                                        <!-- Boton de Editar -->
                                        <button name="{{ $tipo->id_tipo  }}" 
                                            class="edit_tipo btn btn-info btn-circle btn-sm">
                                            <i class="fas fa-pencil"></i>
                                        </button>

                                        <!-- Boton de Eliminar -->
                                        <!-- <button name="{{ $tipo->id_tipo  }}" class="btn btn-danger btn-circle btn-sm tipo-delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                        <form id="delete-tipo-{{ $tipo->id_tipo  }}" action="{{ route('configuración.tipo.delete', $tipo->id_tipo) }}" method="POST" style="display: none;">
                                            @csrf
                                        </form> -->
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

<!-- MODAL DE CREAR TIPOS -->
<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModalLabel">Crear nuevo Tipo de Usuario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Formulario -->
            <form method="POST" action="{{ route('configuración.tipo.store') }}">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Nombre del nuevo Tipo de Usuario</label>
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
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success">Crear Tipo de Usuario</button>
                </div>
            </form>
            <!-- Fin Formulario -->
        </div>
    </div>
</div>

<!-- MODAL DE EDITAR TIPOS -->
<div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateModalLabel">Editar Tipo de Usuario Seleccionado</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Formulario -->
            <form method="POST" action="{{ route('configuración.tipo.update') }}">
                @csrf
                <div class="modal-body">
                    <input type="hidden" id="id_update" name="id_update" value="">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Nombre del Tipo de Usuario</label>
                        <input type="text" class="form-control {{$errors->update->first('nombre_update') ? 'is-invalid' : ''}}"
                            name="nombre_update" value="{{ old('nombre_update') }}"
                            id="nombre_update" placeholder="Digitá el nombre a actualizar...">
                        @if($errors->update->first('nombre_update'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->update->first('nombre_update') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success">Actualizar Tipo de Usuario</button>
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
        $('.edit_tipo').click(function(){
            var id = $(this).attr('name');
            var nombre = $('#nombre_'+id).text();

            //Setteamos el Formulario
            $('#id_update').val(id); 
            $('#nombre_update').val(nombre);

            //Mostramos Modal
            $('#updateModal').modal('show');
        });

        //click para eliminar tipo de usuario
        $('.tipo-delete').click(function(){
            var id = $(this).attr('name');

            Swal.fire({
                title: 'Estas seguro de elimnar el tipo de usuario seleccionado?',
                text: "No podras revertir esta elección, esto dejara usuarios sin tipo determinado los cuales deben ser acomodados por el superadmin despues!",
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
                        'El tipo de usuario sera procesado para ser eliminado de los registros.',
                        'success'
                    );
                    setTimeout(function() { 
                        $( "#delete-tipo-"+id ).submit();
                    }, 2000);
                }
            });
        });
    });
</script>