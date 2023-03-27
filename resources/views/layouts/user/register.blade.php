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
                    <h5><b>{{__('Registro')}}</b></h5><hr>
                </div>

                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="nombre">
                        <h6>{{__('Nombre')}}:</h6>
                        <div class="form-group">
                            <i class="fa fa-user"></i>
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="{{__('Nombre')}}">
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                    </div>

                    <div class="apellido">
                        <h6>{{__('Apellido')}}:</h6>
                        <div class="form-group">
                            <i class="fa fa-user"></i>
                            <input id="lastname" type="text" class="form-control @error('lastname') is-invalid @enderror" name="lastname" value="{{ old('lastname') }}" required autocomplete="lastname" autofocus placeholder="{{__('Apellido')}}">
                                @error('lastname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                    </div>
                    
                    <div class="telefono row mb-3">
                        <h6 class="col-12">{{__('Teléfono')}} *Opcional:</h6>
                        <div class="col-4">
                            <i class="fas fa-phone pl-3"></i>
                            <select id="code" type="text" class="form-control" name="code">
                                <option value="412" {{ old('code') == "412" ? "selected" : ""}}>412</option>
                                <option value="414" {{ old('code') == "414" ? "selected" : ""}}>414</option>
                                <option value="424" {{ old('code') == "424" ? "selected" : ""}}>424</option>
                                <option value="416" {{ old('code') == "416" ? "selected" : ""}}>416</option>
                                <option value="426" {{ old('code') == "426" ? "selected" : ""}}>426</option>
                            </select>
                        </div>
                        <div class="col">
                            <input id="telephone" type="text" class="form-control @error('telephone') is-invalid @enderror" name="telephone" value="{{ old('telephone') }}" autofocus placeholder="{{__('Teléfono')}}">
                        </div>
                        <div class="col-12">
                            @error('telephone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="direccion">
                        <h6>{{__('Dirección')}} *Opcional:</h6>
                        <div class="form-group">
                            <textarea class="form-control p-0 @error('address') is-invalid @enderror" id="" name="address" required>{{ old('address') }}</textarea>
                                @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                    </div>

                    <div class="correo">
                        <h6>{{__('Correo Electrónico')}}:</h6>
                        <div class="form-group">
                            <i class="fas fa-envelope"></i>
                            <input type="email" id="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="{{__('Correo Electrónico')}}">
                                @if($errors->register->first('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->register->first('email') }}</strong>
                                    </span>
                                @endif
                        </div>
                    </div>
                    
                    <div class="contraseña">
                        <h6>{{__('Contraseña')}}:</h6>
                        <div class="form-group">
                            <i class="fa fa-lock"></i>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" autofocus placeholder="{{__('Contraseña')}}">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                    </div>

                    <div class="confirmar">
                        <h6>{{__('Confirmación de Contraseña')}}:</h6>
                        <div class="form-group">
                            <i class="fa fa-lock"></i>
                            <input id="password-confirm" type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" required autocomplete="new-password" autofocus placeholder="{{__('Confirmación de Contraseña')}}">
                            @error('password_confirmation')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
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