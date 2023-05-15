@extends('layouts.user.app')

@section('content')

<div class=".container-xl">
	<div class="article">
		<div class="row">
            <!-- Información del Artículo -->
			<div class="col-sm-9">
                @include('layouts.open_article', ['articulo' => $articulo])

                <!-- Comentarios -->
                <div class=".container-xl">
                    <div class="article-comments">
                        <div class="background-comment px-5">
                            <div class="row container">
                                <div class="col-12">
                                    <div class="comment-header">
                                        <!-- Espacio para cargar un comentario -->
                                        <div class="comment-area container">
                                            <p class="font-weight-bold" style="white-space: pre-line">
                                                {{ __('Comentarios del Artículo') }}
                                            </p>
                                            
                                            <button name="{{ $articulo->id_articulo  }}" 
                                                class="create_comment btn btn-info btn-circle btn-sm">
                                                <i class="fas fa-comment"></i> Subir un Comentario
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Comentarios y Respuestas -->
                                    <div class="comment-body">
                                        @include('layouts.open_comments', ['articulo' => $articulo])
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

			</div>

            <!-- Información del Autor -->
			<div class="col-sm-3" id="content_bar_right">
                @include('layouts.open_author', ['autor' => $articulo->autor, 'articulo' => $articulo])
			</div>
		</div>
	</div>
</div>

<!-- MODAL PARA SUBIR COMENTARIOS -->
<div class="modal fade" id="createComment" tabindex="-1" role="dialog" aria-labelledby="createComment" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createCommentLabel">Introduce tu Comentario...</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Formulario Comentario -->
            <form id="commentCreate" method="POST" action="{{ route('user.comentario.store') }}" style="display: none">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" name="FK_id_articulo" value="{{ $articulo->id_articulo }}">
                        <textarea name="contenido" id="contenido" class="form-control {{$errors->comentario->first('contenido') ? 'is-invalid' : ''}}"
                            cols="30" rows="10" required>{{ old('contenido') }}</textarea>
                        @if($errors->comentario->first('contenido'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success">Enviar Comentario</button>
                </div>
            </form>
            <!-- Fin Formulario -->

            <!-- Formulario Respuesta -->
            <form id="answertCreate" method="POST" action="{{ route('user.respuesta.store') }}" style="display: none">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" name="FK_id_comentario" id="res_id_comment" value="">
                        <textarea name="contenido" id="contenido" class="form-control @error('contenido') is-invalid @enderror"
                            cols="30" rows="10" required>{{ old('contenido') }}</textarea>
                        @error('contenido')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success">Enviar Respuesta</button>
                </div>
            </form>
            <!-- Fin Formulario -->
        </div>
    </div>
</div>
<input type="hidden" id="islogin" value="{{Auth::check()}}">
@endsection

<script src="{{ asset('jquery/jquery.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        //click al boton de hacer comentario
        $('.create_comment').click(function(){
            let login = $('#islogin').val();

            if(!login){ 
                message();
                return;
            }

            //Mostramos o Demostramos un form
            $('#commentCreate').show();
            $('#answertCreate').hide();

            //Setteamos el Formulario
            $('#createCommentLabel').text("Introduce tu Comentario...");

            //Mostramos Modal
            $('#createComment').modal('show');
        });

        //click al boton de hacer respuesta
        $('.create_answer').click(function(){
            let login = $('#islogin').val();
            let comment = $(this).attr('title');

            if(!login){ 
                message();
                return;
            }

            //Mostramos o Demostramos un form
            $('#commentCreate').hide();
            $('#answertCreate').show();

            //Setteamos el Formulario
            $('#createCommentLabel').text("Introduce tu Respuesta...");
            $('#res_id_comment').val(comment);

            //Mostramos Modal
            $('#createComment').modal('show');
        });

        function message(){
            Swal.fire({
                title: 'Debes Iniciar Sesión para poder realizar algún comentario',
                icon: 'warning',
            });
        }
    });
</script>