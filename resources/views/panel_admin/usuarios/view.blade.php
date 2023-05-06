@extends('layouts.admin.app')

@section('content')
<div class="container-fluid">
    
    <!-- TABLA -->
    <div class="card shadow mb-4">
        
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Datos y Comentarios de {{ $usuario->name }}</h6>
        </div>

        @if( $usuario->urol->rol->nombre != "Administrador" )
            <div class="card-header" style="border-bottom: 0px; margin-bottom: -1%">
                <!-- EDITAR USUARIO -->
                <a href="{{ route('usuario.edit', $usuario->id) }}" class="btn btn-primary btn-icon-split">
                    <span class="icon text-white-50">
                        <i class="fas fa-pencil"></i>
                    </span>
                    <span class="text">Editar Usuario</span>
                </a>

                <!-- ELIMINAR USUARIO -->
                <button class="btn btn-danger btn-icon-split btn-delete" name="{{ $usuario->id }}">
                    <span class="icon text-white-50">
                        <i class="fas fa-trash"></i>
                    </span>
                    <span class="text">Eliminar Usuario</span>
                </button>

                <form id="delete-usuario-{{ $usuario->id }}" action="{{ route('usuario.delete', $usuario->id) }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        @endif

        <div class="card-body">

            <div class="row justify-content-center">

                <!-- Usuario -->
                <div class="col-lg-6">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Perfil del Usuario</h6>
                    </div>
                    <div class="card-body">
                        <!-- Nombre -->
                        <h6>    
                            <span class="font-weight-bold">Nombre del Usuario: </span>
                            {{$usuario->perfil->nombre." ".$usuario->perfil->apellido}}
                        </h6>

                        <!-- Tipo de Usuario -->
                        <h6>    
                            <span class="font-weight-bold">Tipo de Usuario: </span>
                            {{$usuario->perfil->tipo ? $usuario->perfil->tipo->nombre : "Es usuario administrativo"}}
                        </h6>
                        
                        <!-- Correo -->
                        <h6>    
                            <span class="font-weight-bold">Correo: </span>
                            {{$usuario->email}}
                        </h6>

                        <!-- Telefono -->
                        <h6>    
                            <span class="font-weight-bold">Teléfono: </span>
                            {{$usuario->telefono ? $usuario->telefono : "No posee teléfono registrado"}}
                        </h6>

                        <!-- Dirección -->
                        <h6>    
                            <span class="font-weight-bold">Dirección de Hogar: </span>
                            {{$usuario->direccion ? $usuario->direccion : "No posee dirección registrada"}}
                        </h6>
                    </div>
                </div>

                <!-- Comentarios del Usuario -->
                <div class="col-lg-6">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                COMENTARIOS
                            </h6>
                        </div>
                        <div class="card-body">
                            @if($usuario->comentarios->count() > 0)
                            <?php $articulo = $usuario ?>
                                @include(('layouts.comments'))
                            @else
                                No hay comentarios cargados en el artículo
                            @endif
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
                        'El usuario sera procesado para ser eliminada de los registros.',
                        'success'
                    );
                    setTimeout(function() { 
                        $( "#delete-usuario-"+id ).submit();
                    }, 2000);
                }
            });
        });
    });
</script>