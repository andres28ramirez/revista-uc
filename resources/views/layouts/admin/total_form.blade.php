<form method="POST" action="{{ $datos['action'] ? route($datos['action']) : '' }}"
    class="" id="{{ $datos['id_form'] }}">
    @csrf
    <!-- Elementos del form -->
        @foreach($datos['componentes'] as $input)
            <div class="form-group" id="input-{{ $input['id_name'] }}">
                <label for="{{ $input['id_name'] }}">{{ $input['label'] }}</label>
                @if($input['tipo'] == "input")
                    <input 
                        class="form-control"
                        {{ $input['requerido'] }}
                        type="{{ $input['dato_tipo'] }}"
                        id="{{ $input['id_name'] }}"
                        name="{{ $input['form_name'] }}"
                        placeholder="{{ $input['placeholder'] }}"
                        value={{ date('Y') }}
                    >
                @elseif($input['tipo'] == "select")
                    <select name="{{ $input['form_name'] }}" id="{{ $input['id_name'] }}"
                            class="form-control" {{ $input['requerido'] }}>
                        <option value="">{{ $input['titulo'] }}</option>
                        @foreach($input['opciones'] as $opcion)
                            <option value="{{ $opcion['id'] }}">{{ $opcion['nombre'] }}</option>
                        @endforeach
                    </select>
                @endif
            </div>
        @endforeach

    <!-- Boton de Enviar -->
    <div class="form-row btn-submit">
        <div class="m-auto">
            <button class="form-btn btn btn-success" id="submit-{{ $datos['id_form'] }}">Enviar</button>
        </div>
    </div>
</form>