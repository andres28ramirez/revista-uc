@extends('layouts.admin.app')

@section('title')
{{ "Roles" }}
@endsection

@section('content')
<div class="container-fluid">
    
    <!-- TABLA -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Infomación general de los Roles de Usuario</h6>
        </div>

        <div class="card-body">

            <!-- GLOBAL CON TOTALES -->
            <div class="row justify-content-center">

                <!-- TOTAL ROLES -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card shadow h-100 py-2" style="border-left: 0.25rem solid #E65100!important;">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Roles de Usuario</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $roles->count() }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-user-shield fa-2x"></i>
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
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $usuarios->count() }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-user fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- USUARIOS COMUNES -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card shadow h-100 py-2" style="border-left: 0.25rem solid #E65100!important;">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Usuarios no Administrativos</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        {{ $urols->count() }}
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

            <!-- CREAR NUEVA AREA -->
            <div class="card-header py-3" style="border-bottom: 0px;">
                <a href="" data-toggle="modal" data-target="#createModal"
                    class="btn btn-success btn-icon-split">
                    <span class="icon text-white-50">
                        <i class="fas fa-plus"></i>
                    </span>
                    <span class="text">Crea un nuevo Rol</span>
                </a>
            </div>

            <!-- TABLA CON EL CONTENIDO DE CONOCIMIENTOS Y BARRA PROGRESO-->
            <div class="row container">
                <!-- BARRA PROGRESO -->
                <div class="card shadow mb-4 col-md-6">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Roles y su Nro. de Usuarios</h6>
                    </div>
                    <div class="card-body">
                        @forelse($roles as $rol)
                            <h4 class="small font-weight-bold">{{ $rol->nombre }} <span
                                    class="float-right">{{ $rol->usuarios->count() }}</span></h4>
                            <div class="progress mb-4">
                                <div class="progress-bar bg-gradient-danger" role="progressbar" 
                                    style="width: <?php echo $usuarios->count() ? $rol->usuarios->count() * 100 / $usuarios->count() : '0' ?>%"
                                    aria-valuenow="{{ $usuarios->count() ? $rol->usuarios->count() * 100 / $usuarios->count() : '0' }}" 
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
                                <th>Rol</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($roles as $rol)
                                <tr class="text-center">
                                    <td class="align-middle" id="nombre_{{ $rol->id_rol  }}">{{ $rol->nombre }}</td>
                                    <td class="align-middle">
                                        <!-- Boton de Editar -->
                                        <button name="{{ $rol->id_rol  }}" 
                                            class="edit_rol btn btn-info btn-circle btn-sm">
                                            <i class="fas fa-pencil"></i>
                                        </button>

                                        <!-- Boton de Eliminar -->
                                        <!-- <button name="{{ $rol->id_rol  }}" class="btn btn-danger btn-circle btn-sm rol-delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                        <form id="delete-rol-{{ $rol->id_rol  }}" action="{{ route('configuración.rol.delete', $rol->id_rol) }}" method="POST" style="display: none;">
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

<!-- MODAL DE CREAR ROLES -->
<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModalLabel">Crear nuevo Rol de Usuario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Formulario -->
            <form method="POST" action="{{ route('configuración.rol.store') }}">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Nombre del nuevo Rol</label>
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
                    <button type="submit" class="btn btn-success">Crear Rol</button>
                </div>
            </form>
            <!-- Fin Formulario -->
        </div>
    </div>
</div>

<!-- MODAL DE EDITAR ROLES -->
<div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateModalLabel">Editar Rol Seleccionado</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Formulario -->
            <form method="POST" action="{{ route('configuración.rol.update') }}">
                @csrf
                <div class="modal-body">
                    <input type="hidden" id="id_update" name="id_update" value="">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Nombre del Rol</label>
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
                    <button type="submit" class="btn btn-success">Actualizar Rol</button>
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
        $('.edit_rol').click(function(){
            var id = $(this).attr('name');
            var nombre = $('#nombre_'+id).text();

            //Setteamos el Formulario
            $('#id_update').val(id); 
            $('#nombre_update').val(nombre);

            //Mostramos Modal
            $('#updateModal').modal('show');
        });

        //click para eliminar area de conocimiento
        $('.rol-delete').click(function(){
            var id = $(this).attr('name');

            Swal.fire({
                title: 'Estas seguro de elimnar el rol seleccionado?',
                text: "No podras revertir esta elección, esto dejara usuarios sin roles los cuales deben ser acomodados por el superadmin despues!",
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
                        'El rol sera procesado para ser eliminado de los registros.',
                        'success'
                    );
                    setTimeout(function() { 
                        $( "#delete-rol-"+id ).submit();
                    }, 2000);
                }
            });
        });
    });
</script>