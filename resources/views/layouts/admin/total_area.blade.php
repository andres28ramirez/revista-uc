<div class="card shadow mb-4">
    <!-- Header y Menu del Grafico -->
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 id="singleline-title-{{ $datos['canva'] }}" class="m-0 font-weight-bold text-primary">{{$datos["titulo"]}}</h6>
        <!-- <div class="dropdown no-arrow">
            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
            </a>

            
            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                aria-labelledby="dropdownMenuLink">
                <div class="dropdown-header">Filtrar tabla:</div>
                <a class="dropdown-item" href="#">Action</a>
                <a class="dropdown-item" href="#">Another action</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#">Something else here</a>
            </div>
        </div> -->
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