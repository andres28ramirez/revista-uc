@extends('layouts.admin.app')

@section('title')
{{ "Ediciones" }}
@endsection

@section('content')
    <!-- TOTALES DE BLOQUES -->
    <div class="row">

        <!-- Número de Ediciones -->
        <div class="col-xl-3 col-md-6 mb-4">
            @include('layouts.admin.total_block', ['color' => "primary", 'titulo' => "Número de Ediciones Cargadas", 'total' => $ediciones->count(), 'icono' => 'fas fa-newspaper'])
        </div>

        <!-- Número de Areas de Conocimiento -->
        <div class="col-xl-3 col-md-6 mb-4">
            @include('layouts.admin.total_block', ['color' => "success", 'titulo' => "Areas de Conocimiento Existentes", 'total' => $conocimientos->count(), 'icono' => 'fas fa-flask'])
        </div>

        <!-- Número de visitas -->
        <div class="col-xl-3 col-md-6 mb-4">
            @include('layouts.admin.total_block', ['color' => "info", 'titulo' => "Número de Visitas a Ediciones", 'total' => $visitas->sum('total'), 'icono' => 'fas fa-eye'])
        </div>
        <!-- Número de descargas -->
        <div class="col-xl-3 col-md-6 mb-4">
            @include('layouts.admin.total_block', ['color' => "warning", 'titulo' => "Número de Descargas realizadas", 'total' => $descargas->count(), 'icono' => 'fas fa-download'])
        </div>
    </div>

    <!-- Primera Linea -->
    <div class="row">
        <!-- Linea Grafico - Número de Visitas -->
        <div class="col">
            @php
                $data = array_fill(0, 12, 0);

                foreach($g_visitas as $visita){
                    $data[($visita->mes - 1)] = $visita->total;
                }

                $chart_data = array(
                    'titulo' => "Nro. de visitas por meses del año ".$per_visita,
                    'canva' => 'c0',
                    'labels' => array("Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dec"),
                    'datos' => $data,
                    'tipo' => "normal",
                    'bgColors' => 'rgba(255,48,23,0.7)',
                    'brColors' => 'rgba(128,23,11,0.8)'
                );

                $form_data = array(
                    "action" => "edicion.filter",
                    "titulo" => "Filtro de Número de Visitas",
                    "id_form" => "form_c0",

                    "componentes" => array(
                        array(
                            "id_name" => "visitas_periodo",
                            "form_name" => "visitas_periodo",
                            "tipo" => "input",
                            "label" => "Año a evaluar",
                            "icon" => "fa-calendar-o",
                            "dato_tipo" => "number",
                            "placeholder" => "Ingresa el año a evaluar",
                            "validate" => "Año es requerido",
                            "requerido" => "required",
                        ),
                    )
                );
            @endphp
            @include('layouts.admin.total_area', ['datos' => $chart_data, 'datos_form' => $form_data])
        </div>

        <!-- Barras Grafico - Numero de Descargas por Edicion -->
        <div class="col">
            @php
                $data = array();
                $nombres = array();

                foreach($ediciones as $edicion){
                    array_push($data, $edicion->descargas->sum('total'));
                    array_push($nombres, $edicion->titulo);
                }

                $chart_data = array(
                    'titulo' => "Nro. de descargas por edición",
                    'canva' => 'c1',
                    'labels' => $nombres,
                    'datos' => $data,
                    'tipo' => "normal",
                    'bgColors' => 'rgba(128,23,11,0.8)',
                    'brColors' => 'rgba(128,23,11,0.8)'
                );
            @endphp
            @include('layouts.admin.total_bar', ['datos' => $chart_data])
        </div>
    </div>

    <!-- Segunda Linea -->
    <div class="row">
        <!-- Progress Bar - Número de Articulos -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Número de artículos por Edición</h6>
                </div>
                <div class="card-body">
                    @forelse($ediciones as $edicion)
                        <h4 class="small font-weight-bold">{{ $edicion->titulo }} 
                            <span class="float-right">{{ $edicion->articulos->count() }}</span>
                        </h4>
                        <div class="progress mb-4">
                            <div class="progress-bar bg-gradient-info" role="progressbar" 
                                style="width: <?php echo $articulos->count() ? $edicion->articulos->count() * 100 / $articulos->count() : '0' ?>%"
                                aria-valuenow="{{ $articulos->count() ? $edicion->articulos->count() * 100 / $articulos->count() : '0' }}" 
                                aria-valuemin="0" aria-valuemax="100">
                            </div>
                        </div>
                    @empty
                        <p>No hay ediciones cargadas...</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Pie Chart - Articulos por Area de Conocimiento -->
        <div class="col-xl-4 col-lg-5">
            @php
                $data = array();
                $nombre = array();
                $colorBg = array();

                foreach($conocimientos as $key => $conocimiento){
                    $opacidad = (100 - ($key * 20)) / 100;

                    array_push($data, $conocimiento->articulos->count());
                    array_push($nombre, $conocimiento->nombre);
                    array_push($colorBg, "rgba(255,48,23,".$opacidad.")");
                }

                $chart_data = array(
                    'titulo' => "Artículos por Area de Conocimiento",
                    'canva' => 'c4',
                    'labels' => $nombre,
                    'datos' => $data,
                    'tipo' => "normal",
                    'bgColors' => $colorBg,
                    'brColors' => 'rgba(128,23,11,0.8)'
                );
            @endphp
            @include('layouts.admin.total_pie', ['datos' => $chart_data])
        </div>
    </div>

    <!-- Tercera Linea -->
    <div class="row">
        <!-- Doble Barras - Visita y Decargas por edición -->
        <div class="col">
            @php
                $labels = array();
                $b_descargas = array();
                $b_visitas = array();

                foreach($ediciones as $edicion){
                    array_push($labels, $edicion->titulo);
                    array_push($b_descargas, $edicion->descargas->sum('total'));
                    array_push($b_visitas, $edicion->visitas->sum('total'));
                }

                $chart_data = array(
                    'titulo' => "Relación de Descargas y Visitas por Edición",
                    'canva' => 'c5',
                    'labels' => $labels,
                    'bar1_datos' => $b_descargas,
                    'bar1_labels' => "Descargas",
                    'bar1_bgColors' => 'rgba(255,48,23,0.7)',
                    'bar1_brColors' => 'rgba(128,23,11,0.8)',
                    'bar2_datos' => $b_visitas,
                    'bar2_labels' => "Visitas",
                    'bar2_bgColors' => 'rgba(114,122,235,0.7)',
                    'bar2_brColors' => 'rgba(135,122,235,0.8)'
                );
            @endphp
            @include('layouts.admin.total_double_bar', ['datos' => $chart_data])
        </div>
    </div>
@endsection

<script src="{{ asset('jquery/jquery.min.js') }}"></script>
@section('scripts')
<script src="{{ asset('js/graficos/singleLine.js') }}"></script>
<script src="{{ asset('js/graficos/singleBar.js') }}"></script>
<script src="{{ asset('js/graficos/singlePie.js') }}"></script>
<script src="{{ asset('js/graficos/doubleBar.js') }}"></script>
@endsection