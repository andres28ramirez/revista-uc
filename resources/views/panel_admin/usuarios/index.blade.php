@extends('layouts.admin.app')

@section('content')
<div class="container-fluid">
    
    <!-- TABLA -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Usuarios Registrados en la Revista</h6>
        </div>

        <div class="card-body">

            <!-- GLOBAL CON TOTALES -->
            <div class="row justify-content-center">

                <!-- TOTAL DE USUARIO -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card shadow h-100 py-2" style="border-left: 0.25rem solid #E65100!important;">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        NÚMERO DE USUARIOS</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $usuarios->count() }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-flask fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- USUARIOS VERIFICADOS -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card shadow h-100 py-2" style="border-left: 0.25rem solid #084456!important;">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Total Verificados</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $usuarios->whereNotNull('email_verified_at')->count() }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-newspaper fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- NÚMERO DE ROLES ACTUALES -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card shadow h-100 py-2" style="border-left: 0.25rem solid #E65100!important;">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Roles de Usuario</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        {{ $roles->count() }}
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
                <a href="{{ route('usuario.create') }}" 
                    class="btn btn-success btn-icon-split">
                    <span class="icon text-white-50">
                        <i class="fas fa-plus"></i>
                    </span>
                    <span class="text">Registrar un nuevo Usuario</span>
                </a>
            </div>

            <!-- REINICIAR FILTROS DE BUSQUEDA -->
            @if($filtrado)
                <div class="card-header pb-0" style="border-bottom: 0px;">
                    <a href="{{ route('usuario.index') }}" class="btn btn-secondary btn-sm btn-icon-split">
                        <span class="icon text-white-50" style="padding: 0.75rem 0.75rem;">
                            <i class="fas fa-rotate-left"></i>
                        </span>
                        <span class="text">Eliminar filtros de busqueda</span>
                    </a>
                </div>
            @endif

            <!-- FILTRO DE BUSQUEDA -->
            <div class="card-body pb-0">
                <button type="button" class="btn btn-info btn-sm mb-1" data-toggle="modal" data-target="#filtradoModal">
                    Aplicar Filtros de Busqueda
                </button>
                @if($filtrado)
                    <br>
                    <label for="">
                        Filtro de Busqueda Aplicado por:
                        @if($id_rol)<span class="font-weight-bold text-primary"> Rol de Usuario</span>@endif
                    </label>
                @else
                    <label for="">
                        No hay filtros aplicados en el reporte de la tabla...
                    </label>
                @endif
            </div>

            <!-- TABLA CON EL CONTENIDO DE CONOCIMIENTOS Y BARRA PROGRESO-->
            <div class="row container">
                <!-- TABLA -->
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>Verificado</th>
                                <th>Rol del Usuario</th>
                                <th>Nro. de Comentarios</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($usuarios as $usuario)
                                <tr class="text-center">
                                    <td class="align-middle">
                                        {{ $usuario->name }}
                                    </td>
                                    <td class="align-middle">
                                        {{ $usuario->email }}
                                    </td>
                                    <td class="align-middle">
                                        @if($usuario->email_verified_at)
                                            <button class="btn btn-success btn-circle btn-sm">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        @else
                                            <button class="btn btn-danger btn-circle btn-sm">
                                                <i class="fas fa-xmark"></i>
                                            </button>
                                        @endif
                                    </td>
                                    <td class="align-middle">
                                        {{ $usuario->urol->rol->nombre }}
                                    </td>
                                    <td class="align-middle">
                                        <a href="{{ route('comentario.all', ['id_usuario' => $usuario->id, 'id_articulo' => 0, 'id_estado' => 0], ) }}" class="btn btn-warning btn-icon-split">
                                            <span class="icon text-white font-weight-bold">
                                                {{ $usuario->comentarios->count() }}
                                            </span>
                                            <span class="text">
                                                <i class="fas fa-comment"></i>
                                            </span>
                                        </a>
                                    </td>
                                    <td class="align-middle">
                                        <!-- Boton de Ver User -->       
                                        <a href="{{ route('usuario.view', $usuario->id) }}" class="btn btn-success btn-circle btn-sm">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        
                                        @if( $usuario->urol->rol->nombre != "Administrador" )
                                            <!-- Boton de Editar -->
                                            <a href="{{ route('usuario.edit', $usuario->id) }}" class="btn btn-info btn-circle btn-sm">
                                                <i class="fas fa-pencil"></i>
                                            </a>

                                            <!-- Boton de Eliminar -->
                                            <button name="{{ $usuario->id }}" class="btn btn-danger btn-circle btn-sm user-delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                            <form id="delete-user-{{ $usuario->id }}" action="{{ route('usuario.delete', $usuario->id) }}" method="POST" style="display: none;">
                                                @csrf
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                No hay usuarios registrados...
                            @endforelse
                        </tbody>
                    </table>
                    {{ $usuarios->links() }}
                </div>
            </div>

        </div>
    </div>

</div>
<input type="hidden" id="link_dir" value="{{ route('usuario.index') }}">

<!-- Modal para filtrar la información -->
<div class="modal fade" id="filtradoModal" tabindex="-1" role="dialog" aria-labelledby="filtradoModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="filtradoModalLongTitle">Selecciona el filtrado para la Tabla</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Roles -->
                <div class="form-group">
                    <label for="rol_filter">Selecciona un Artículo: Opcional*</label>
                    <select id="rol_filter" class="form-control" name="id_rol">
                        <option value="0">Selecciona un Artículo a filtrar...</option>
                        @foreach($roles as $rol)
                            <option value="{{ $rol->id_rol }}" {{ $id_rol == $rol->id_rol ? "selected" : ""}}>{{ $rol->nombre }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="filter_button" class="btn btn-secondary">Aplicar Filtro</button>
            </div>
        </div>
    </div>
</div>
@endsection

<script src="{{ asset('jquery/jquery.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        //Filtrat Tabla de Usuarios
        $('#filter_button').click(function(){
            let link = $('#link_dir').val();
            let rol = $('#rol_filter option:selected').val();
            
            location.href = link+"/"+rol;
        });

        //click para eliminar usuario
        $('.user-delete').click(function(){
            var id = $(this).attr('name');

            Swal.fire({
                title: 'Estas seguro de elimnar el usuario seleccionado?',
                text: "No podras revertir esta elección, esto eliminara todas las notificaciones o comentarios del usuario!",
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
                        'El usuario sera procesado para ser eliminado de los registros.',
                        'success'
                    );
                    setTimeout(function() { 
                        $( "#delete-user-"+id ).submit();
                    }, 2000);
                }
            });
        });
    });
</script>