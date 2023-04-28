<div class="container mb-5 mt-5" style="overflow-y: auto;">		  
    <div class="card_comment">
        <div class="row">
            <div class="col-md-12">
                <div class="row" id="">
                    <div class="col-md-12" id="">
                        @foreach($articulo->comentarios as $key => $comentario)
                        <div class="media comment_{{$key}}" 
                            style="<?php echo $key < 2 ? '' : 'display: none' ?>">
                            <!-- <img class="mr-3 rounded-circle" alt="Bootstrap Media Preview" src="https://i.imgur.com/stD0Q19.jpg" /> -->
                            <div class="media-body">
                                <div class="row">
                                    <!-- Usuario y Tiempo del Comentario -->
                                    <div class="col-8 d-flex">
                                        <h5>{{ $comentario->autor }}</h5>
                                        <span>- {{ FormatTime::LongTimeFilter($comentario->created_at) }}</span>
                                    </div>
                                    <!-- Boton de Contestar -->
                                    <div class="col-4">
                                        <div class="pull-right reply">
                                            <a href="#"><span><i class="fa fa-reply"></i> Responder</span></a>
                                        </div>
                                    </div>
                                    <!-- Panel de Manejo de Comentario -->
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
                                        <span class="action-icons">
                                            <a href="{{ route('comentario.edit', $comentario->id_comentario) }}" class="text-primary">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                        </span>
                                    </div>
                                </div>		
                                
                                <!-- Comentario -->
                                <span id="">{{ $comentario->contenido }}</span>

                                <!-- Respuestas -->
                                <ul>
                                    @foreach($comentario->respuestas as $respuesta)
                                    <li>
                                        <div class="media mt-4">
                                            <!-- <a class="pr-3" href="#"><img class="rounded-circle" alt="Bootstrap Media Another Preview" src="https://i.imgur.com/xELPaag.jpg" /></a> -->
                                            <div class="media-body">
                                                <!-- Usuario de la Respuesta -->
                                                <div class="row">
                                                    <div class="col-12 d-flex">
                                                        <h5>{{ $respuesta->nombre }}</h5>
                                                        <span>- {{ FormatTime::LongTimeFilter($respuesta->created_at) }}</span>
                                                    </div>
                                                </div>
                                                <!-- Panel de Manejo de Respuesta -->
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
                                                    <span class="action-icons">
                                                        <a href="{{ route('comentario.edit', $respuesta->id_respuesta) }}" class="text-primary">
                                                            <i class="fa fa-pencil"></i>
                                                        </a>
                                                    </span>
                                                </div>
                                                <!-- Comentario de Respuesta -->
                                                {{ $respuesta->contenido }}
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
                    @if( $articulo->comentarios->count() > 2 )
                        <div class="text-center col-12 active" id="comment_load">
                            <span id="see_more" class="text-primary" style="cursor: pointer">
                                Cargar más comentarios...
                            </span>
                        </div>
                    @endif

                    <!-- Comentarios Mostrados -->
                    <div class="card-actions col-12">
                        <span>Mostrando 
                            <span id="card-count">{{ $articulo->comentarios->count() < 2 ? $articulo->comentarios->count() : "2" }}</span> de 
                            <span id="card-total">{{ $articulo->comentarios->count() }}</span> comentarios      
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

            for (var i = 0; i < 2; i++) {
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