<div class="container mb-5 mt-5" style="overflow-y: auto;">		  
    <div class="card_comment">
        <div class="row">
            <div class="col-md-12">
                <div class="row" id="">
                    <div class="col-md-12" id="">
                        @foreach($articulo->comentarios->where('estado', 'aceptado') as $key => $comentario)
                        <div class="media comment_{{$key}}" 
                            style="<?php echo $key < 5 ? '' : 'display: none' ?>">

                            <!-- <img class="mr-3 rounded-circle" alt="Bootstrap Media Preview" src="https://i.imgur.com/stD0Q19.jpg" /> -->
                            <div class="media-body">
                                <div class="row">
                                    <!-- Usuario y Tiempo del Comentario -->
                                    <div class="col-8 d-flex">
                                        <h5>{{ $comentario->autor }} </h5>
                                        <span class="pl-2">  {{ FormatTime::LongTimeFilter($comentario->created_at) }}</span>
                                    </div>
                                    <!-- Boton de Contestar -->
                                    <div class="col-4">
                                        <div title="{{ $comentario->id_comentario }}" class="pull-right reply create_answer text-primary" style="cursor: pointer">
                                            <span><i class="fa fa-reply"></i> Responder</span>
                                        </div>
                                    </div>
                                    <!-- Estado de Comentario -->
                                    @if($comentario->FK_id_usuario == Auth::user()->id)
                                        <div class="comment-footer col-12">
                                            @switch($comentario->estado)
                                                @case('rechazado')
                                                    <span class="badge badge-pill badge-danger">
                                                @break
                                                @case('aceptado') 
                                                    <span class="badge badge-pill badge-success">
                                                @break
                                                @default 
                                                    <span class="badge badge-pill badge-primary">
                                                @break
                                            @endswitch
                                                {{ $comentario->estado }}
                                            </span> 
                                        </div>
                                    @endif
                                </div>		
                                
                                <!-- Comentario -->
                                <p style="white-space: pre-line">{{ $comentario->contenido }}</p>

                                <!-- Respuestas -->
                                <ul>
                                    @foreach($comentario->respuestas->where('estado', 'aceptado') as $respuesta)
                                    <li>
                                        <div class="media mt-4">
                                            <!-- <a class="pr-3" href="#"><img class="rounded-circle" alt="Bootstrap Media Another Preview" src="https://i.imgur.com/xELPaag.jpg" /></a> -->
                                            <div class="media-body">
                                                <!-- Usuario de la Respuesta -->
                                                <div class="row">
                                                    <div class="col-12 d-flex">
                                                        <h5>{{ $respuesta->nombre }} </h5>
                                                        <span class="pl-2">  {{ FormatTime::LongTimeFilter($respuesta->created_at) }}</span>
                                                    </div>
                                                </div>
                                                <!-- Panel de Manejo de Respuesta -->
                                                @if($respuesta->FK_id_usuario == Auth::user()->id)
                                                    <div class="comment-footer col-12">
                                                        @switch($respuesta->estado)
                                                            @case('rechazado')
                                                                <span class="badge badge-pill badge-danger">
                                                            @break
                                                            @case('aceptado') 
                                                                <span class="badge badge-pill badge-success">
                                                            @break
                                                            @default 
                                                                <span class="badge badge-pill badge-primary">
                                                            @break
                                                        @endswitch
                                                                {{ $respuesta->estado }}
                                                        </span>
                                                    </div>
                                                @endif
                                                <!-- Comentario de Respuesta -->
                                                <p style="white-space: pre-line">{{ $respuesta->contenido }}</p>
                                            </div>
                                        </div>
                                    </li>
                                    @endforeach
                                </ul>
                                <hr>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    
                    <!-- Cargador Comentarios -->
                    @if( $articulo->comentarios->where('estado', 'aceptado')->count() > 5 )
                        <div class="text-center col-12 active" id="comment_load">
                            <span id="see_more" class="text-primary" style="cursor: pointer">
                                Cargar más comentarios...
                            </span>
                        </div>
                    @endif

                    <!-- Comentarios Mostrados -->
                    <div class="card-actions col-12">
                        <span>Mostrando 
                            <span id="card-count">{{ $articulo->comentarios->where('estado', 'aceptado')->count() < 5 ? $articulo->comentarios->where('estado', 'aceptado')->count() : "5" }}</span> de 
                            <span id="card-total">{{ $articulo->comentarios->where('estado', 'aceptado')->count() }}</span> comentarios      
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('jquery/jquery.min.js') }}"></script>
<script>
    $(document).ready(function() {

        //Abrir más
        $('#see_more').click(function(){
            var key = $('#card-count').text();
            var total = $('#card-total').text();
            
            if(key >= total) return;

            for (var i = 0; i < 5; i++) {
                var number = Number(key)+i;
                $(".comment_"+number).slideDown();
            }

            key = Number(key)+i;
            $("#card-count").text(key);

            if(key >= total){
                $("#card-count").text(total);
                $('#comment_load').hide();
            }
        });
    });
</script>