<div class="card shadow mb-4">
    <!-- Header y Menu del Grafico -->
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 id="doublebar-title-{{ $datos['canva'] }}" class="m-0 font-weight-bold text-primary">{{$datos["titulo"]}}</h6>
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
        <div class="text-center chart-area doublebar-spinner row">
            <div class="m-auto">
                <i class="fa fa-5x fa-lg fa-spinner fa-spin" style="color: #084456"></i>
            </div>
        </div>
        <div class="">
            <canvas id="doubleBar{{ $datos['canva'] }}"></canvas>
            <input type="hidden" name="{{ $datos['canva'] }}" class="canvasDoubleBarid" id="canvaid" value="doubleBar{{ $datos['canva'] }}">
        </div>

        <!-- VALORES QUE RECOJE EL CHART -->
        <div id="{{ $datos['canva'] }}_datos">
            <!-- datos de los labels generales -->
            @foreach($datos['labels'] as $label)
                <input type="hidden" class="canvasblabels{{ $datos['canva'] }}" value="{{ $label }}">
            @endforeach

            <!-- DATOS DE LA PRIMERA BARRA -->
                <!-- label identificador de la barra -->
                <input type="hidden" class="canvasDb1label{{ $datos['canva'] }}" value="{{ $datos['bar1_labels'] }}">
                
                <!-- datos singulares -->
                @foreach($datos['bar1_datos'] as $dato)
                    <input type="hidden" class="canvasDb1datos{{ $datos['canva'] }}" value="{{ $dato }}">
                @endforeach

                <!-- background color -->
                <input type="hidden" class="canvasBg1Color{{ $datos['canva'] }}" value="{{ $datos['bar1_bgColors'] }}">

                <!-- border line color -->
                <input type="hidden" class="canvasBr1Color{{ $datos['canva'] }}" value="{{ $datos['bar1_brColors'] }}">

            <!-- DATOS DE LA SEGUNDA BARRA -->
                <!-- label identificador de la barra -->
                <input type="hidden" class="canvasDb2label{{ $datos['canva'] }}" value="{{ $datos['bar2_labels'] }}">
                
                <!-- datos singulares -->
                @foreach($datos['bar2_datos'] as $dato)
                    <input type="hidden" class="canvasDb2datos{{ $datos['canva'] }}" value="{{ $dato }}">
                @endforeach

                <!-- background color -->
                <input type="hidden" class="canvasBg2Color{{ $datos['canva'] }}" value="{{ $datos['bar2_bgColors'] }}">

                <!-- border line color -->
                <input type="hidden" class="canvasBr2Color{{ $datos['canva'] }}" value="{{ $datos['bar2_brColors'] }}">
        </div>
    </div>
</div>