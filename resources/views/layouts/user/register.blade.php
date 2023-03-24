<div class="modal fade" id="singinModal" tabindex="-1" role="dialog" aria-labelledby="modalSingIn" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            
                <div class="modal-header">
                    <div class="modal-logo" id="modalSingIn">
                        <img src="{{ asset('/images/rcu-yellow-logo.png') }}" alt="logo">
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <div class="modal-title">
                        <h5><b>{{__('Registro')}}</b></h5>
                        <hr>
                    </div>

                    <form method="POST" action="{{ route('register') }}">
                    @csrf
                        <div class="nombre">
                            <h6>{{__('Nombre y Apellido')}}</h6>
                            <div class="form-group">
                                <i class="fa fa-user"></i>
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="{{__('Nombre y Apellido')}}">
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                            </div>
                        </div>

                        <h6>{{__('Correo Electrónico')}}</h6>
                        <div class="form-group">
                            <i class="fas fa-envelope"></i>
                            <input type="email" id="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="{{__('Correo Electrónico')}}">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>

                        <h6>{{__('Contraseña')}}</h6>
                        <div class="form-group">
                            <i class="fa fa-lock"></i>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" autofocus placeholder="{{__('Contraseña')}}">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                        
                        <h6>{{__('Confirmación de Contraseña')}}</h6>
                        <div class="form-group">
                            <i class="fa fa-lock"></i>
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" autofocus placeholder="{{__('Confirmación de Contraseña')}}">
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block btn-lg">
                            {{ __('Registro') }}
                            </button>
                        </div>

                    </form>

                </div>

        </div>
    </div>
</div>