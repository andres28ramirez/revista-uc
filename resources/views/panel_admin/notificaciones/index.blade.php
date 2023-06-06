@extends('layouts.admin.app')

@section('content')
<div class="container-fluid">
    
    <!-- TABLA -->
    <div class="mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Todas las Notificaciones</h6>
        </div>

        <!-- Botones -->
        <div class="alert alert-light d-flex flex-row" role="alert">
            <!-- Checkboxes Leidor -->
            <form id="form_read_all" action="{{ route('notificacion.readAll', auth()->user()->id) }}" method="POST" style="display: none;">
                @csrf
                <input type="hidden" class="all-check" name="all" value="">
                <div id="form_read_values">

                </div>
            </form>

            <!-- Checkboxes Eliminados -->
            <form id="form_delete_all" action="{{ route('notificacion.deleteAll', auth()->user()->id) }}" method="POST" style="display: none;">
                @csrf
                <input type="hidden" class="all-check" name="all" value="">
                <div id="form_delete_values">

                </div>
            </form>

            <!-- Checkbox Global -->
            <div class="form-check text-justify">
                <input class="form-check-input check-everyone" type="checkbox" value="" id="flexCheck">
            </div>

            <!-- Marcar como Leido -->
            <div class="text-center notificacion_alert mx-3 leer-todos" style="cursor: pointer">
                <button type="button" class="btn btn-primary btn-sm">Marcar como Leidos</button>
            </div>

            <!-- Eliminar -->
            <div class="text-right notificacion_alert eliminar-todos" style="cursor: pointer">
                <button type="button" class="btn btn-danger btn-sm">Eliminar</button>
            </div>
        </div>

        <!-- Notificaciones No Leidas -->
        @forelse($notificaciones as $key => $notify)
            <form id="form_read{{$key}}" action="{{ route('notificacion.redireccion') }}" method="post">
                @csrf
                <input type="hidden" name="ruta" value="{{ $notify->notificacion->ruta }}">
                <input type="hidden" name="notificacion" value="{{ $notify->id_usuario_notificacion }}">
            </form>

            <div class="alert {{ $notify->read_at ? 'alert-light' : 'alert-secondary' }} d-flex justify-content-between" role="alert">
                <!-- Checkbox y Persona -->
                <div class="col form-check text-justify div-check">
                    <input class="form-check-input singular-check" type="checkbox"  name="checkboxes[]"
                        value="{{ $notify->id_usuario_notificacion }}" id="flexCheck{{$key}}">
                    <label class="form-check-label {{ $notify->read_at ? '' : 'font-weight-bold' }}" for="flexCheck{{$key}}">
                        {{ $notify->notificacion->titulo }}
                    </label>
                </div>

                <!-- Titulo de la Notificación -->
                <div class="col text-center {{ $notify->read_at ? '' : 'font-weight-bold' }}">
                    {{ $notify->notificacion->descripcion }}
                </div>

                <!-- Fecha y Opciones de la Notificación -->
                <div class="col text-right {{ $notify->read_at ? '' : 'font-weight-bold' }}">
                    <div class="w-100">{{ FormatTime::LongTimeFilter($notify->created_at) }}</div>
                    
                    <!-- Boton de Marcar Leido -->
                    <button name="{{ $key }}" 
                        class="btn btn-success btn-circle btn-sm btn-open">
                        <i class="fas fa-eye"></i>
                    </button>

                    <!-- Boton de Marcar Leido -->
                    <button name="{{ $key }}"
                        class="btn btn-primary btn-circle btn-sm btn-leido">
                        <i class="fas {{ $notify->read_at ? 'fa-envelope' : 'fa-envelope-open' }}"></i>
                    </button>
                    <form id="read-notificacion-{{ $key }}" action="{{ route('notificacion.read', $notify->id_usuario_notificacion) }}" method="POST" style="display: none;">
                        @csrf
                    </form>

                    <!-- Boton de Eliminar -->
                    <button name="{{ $key }}"
                        class="btn btn-danger btn-circle btn-sm btn-delete">
                        <i class="fas fa-trash"></i>
                    </button>
                    <form id="delete-autor-{{ $key }}" action="{{ route('notificacion.delete', $notify->id_usuario_notificacion) }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>
        @empty
            <div class="text-center">
                No hay notificaciones por el momento...
            </div>
        @endforelse
    </div>

</div>
@endsection

<script src="{{ asset('jquery/jquery.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        
        //EVENTOS SINGULARES
            //Abrir Notificación
            $('.btn-open').click(function(){
                var form = $(this).attr('name');
                $('#form_read'+form).submit();
            });

            //Marcar Leido o No Leido Notificación
            $('.btn-leido').click(function(){
                var form = $(this).attr('name');
                $('#read-notificacion-'+form).submit();
            });

            //Eliminar Notificacion
            $('.btn-delete').click(function(){
                var id = $(this).attr('name');

                Swal.fire({
                    title: 'Estas seguro de elimnar la notificación?',
                    text: "No podras revertir esta elección, esto borrara la notificación de todos los registros!",
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
                            'La notificación sera procesada para ser eliminada de los registros del usuario.',
                            'success'
                        );
                        setTimeout(function() { 
                            $( "#delete-autor-"+id ).submit();
                        }, 2000);
                    }
                });
            });

        //EVENTOS GLOBALES
            //Marcar o Desmarcar todos los checks
            $('.check-everyone').click(function(){
                if ($('.check-everyone').is(":checked")){
                    $( ".singular-check" ).prop( "checked", true );
                    $('.all-check').val(1);
                }
                else{
                    $( ".singular-check" ).prop( "checked", false );
                    $('.all-check').val(0);
                }
            });

            //Desmarcar check principal por pulsación de uno individual
            $('.singular-check').click(function(){
                $( ".check-everyone" ).prop( "checked", false );
                $('.all-check').val(0);
            });

            //Enviar a Marcar todos en leido
            $('.leer-todos').click(function(){
                var selected = [];

                $( "#form_read_values" ).empty();
                $('.div-check input:checked').each(function() {
                    selected.push($(this).val());
                    $( "#form_read_values" ).append('<input type="hidden" class="" name="boxes[]" value="'+$(this).val()+'">');
                });

                if(selected.length > 0){
                    $("#form_read_all").submit();
                }
            });

            //Enviar a Eliminar todos los seleccionados
            $('.eliminar-todos').click(function(){
                var selected = [];

                $( "#form_delete_values" ).empty();
                $('.div-check input:checked').each(function() {
                    selected.push($(this).val());
                    $( "#form_delete_values" ).append('<input type="hidden" class="" name="boxes[]" value="'+$(this).val()+'">');
                });

                if(selected.length > 0){
                    Swal.fire({
                        title: 'Estas seguro de elimnar las notificaciones?',
                        text: "No podras revertir esta elección, esto borrara las notificaciones seleccionadas!",
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
                                'Las notificaciones seran procesadas para ser eliminadas de los registros del usuario.',
                                'success'
                            );
                            setTimeout(function() { 
                                $("#form_delete_all").submit();
                            }, 2000);
                        }
                    });
                }
            });
    });
</script>