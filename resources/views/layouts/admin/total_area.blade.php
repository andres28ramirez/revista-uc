<div class="card shadow mb-4">
    <!-- Header y Menu del Grafico -->
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 id="singleline-title-{{ $datos['canva'] }}" class="m-0 font-weight-bold text-primary">{{$datos["titulo"]}}</h6>
        @if(isset($datos_form))
            <div class="dropdown no-arrow">
                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                </a>

                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                    aria-labelledby="dropdownMenuLink">
                    <div class="dropdown-header">Filtrar tabla:</div>
                    <a class="dropdown-item" href="" data-toggle="modal" data-target="#lfiltro-{{ $datos['canva'] }}">
                        Abrir Modal
                    </a>
                </div>
            </div>
        @endif
    </div>

    <!-- Cuerpo del Gráfico -->
    <div class="card-body" id="canva-indicator-{{ $datos['canva'] }}" title="{{$datos['titulo']}}" name="{{$datos['titulo']}}">
        <div class="text-center chart-area singleline-spinner row">
            <div class="m-auto">
                <i class="fa fa-5x fa-lg fa-spinner fa-spin" style="color: #084456"></i>
            </div>
        </div>
        <div class="chart-area">
            <canvas id="singleLine{{ $datos['canva'] }}"></canvas>
            <input type="hidden" name="{{ $datos['canva'] }}" class="canvasLineid" id="canvaid" value="singleLine{{ $datos['canva'] }}">
        </div>

        <!-- VALORES QUE RECOJE EL CHART -->
        <div id="{{ $datos['canva'] }}_datos">
            <!-- tipo de canva -->
            <input type="hidden" class="canvasTipoB{{ $datos['canva'] }}" value="{{ $datos['tipo'] }}">

            <!-- background color -->
            <input type="hidden" class="canvasBgColor{{ $datos['canva'] }}" value="{{ $datos['bgColors'] }}">

            <!-- border line color -->
            <input type="hidden" class="canvasBrColor{{ $datos['canva'] }}" value="{{ $datos['brColors'] }}">

            <!-- datos singulares -->
            @foreach($datos['datos'] as $dato)
                <input type="hidden" class="canvasbdatos{{ $datos['canva'] }}" value="{{ $dato }}">
            @endforeach

            <!-- datos de los labels -->
            @foreach($datos['labels'] as $label)
                <input type="hidden" class="canvasblabels{{ $datos['canva'] }}" value="{{ $label }}">
            @endforeach
        </div>
    </div>
</div>

@if(isset($datos_form))
<!-- Modal para filtrar el gráfico -->
<div class="modal fade" id="lfiltro-{{ $datos['canva'] }}" tabindex="-1" role="dialog" aria-labelledby="filterModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center">Filtrar Gráfico</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @include('layouts.admin.total_form', ['datos' => $datos_form])
            </div>
        </div>
    </div>
</div>
@endif