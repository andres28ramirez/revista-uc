<div class="card shadow mb-4">
    <!-- Header y Menu del Grafico -->
    <div
        class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">{{$titulo}}</h6>
        <div class="dropdown no-arrow">
            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
            </a>

            <!-- Menu de Opciones -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                aria-labelledby="dropdownMenuLink">
                <div class="dropdown-header">Filtrar tabla:</div>
                <a class="dropdown-item" href="#">Action</a>
                <a class="dropdown-item" href="#">Another action</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#">Something else here</a>
            </div>
        </div>
    </div>

    <!-- Cuerpo del Gráfico -->
    <div class="card-body">
        <div class="chart-area">
            <canvas id="{{ $id_grafico }}"></canvas>
        </div>

        <div id="{{ $id_grafico }}_datos">
            @foreach($datos as $dato)
                <input type="hidden" class="{{ $id_grafico }}_mes" value="{{ $dato->mes }}">
                <input type="hidden" class="{{ $id_grafico }}_total" value="{{ $dato->total }}">
            @endforeach
        </div>
    </div>
</div>