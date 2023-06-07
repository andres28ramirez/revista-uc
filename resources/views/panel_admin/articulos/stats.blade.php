@extends('layouts.admin.app')

@section('content')
    <!-- TOTALES DE BLOQUES -->
    <div class="row justify-content-center">

        <!-- Número de Articulos -->
        <div class="col-xl-3 col-md-6 mb-4">
            @include('layouts.admin.total_block', ['color' => "danger", 'titulo' => "Número de Artículos Cargados", 'total' => $articulos->count(), 'icono' => 'fas fa-book'])
        </div>

        <!-- Número de Comentarios -->
        <div class="col-xl-3 col-md-6 mb-4">
            @include('layouts.admin.total_block', ['color' => "success", 'titulo' => "Comentarios enviados por usuarios", 'total' => $comentarios->count(), 'icono' => 'fas fa-comment'])
        </div>

        <!-- Número de Autores -->
        <div class="col-xl-3 col-md-6 mb-4">
            @include('layouts.admin.total_block', ['color' => "primary", 'titulo' => "Número de Autores en el sistema", 'total' => $autores->count(), 'icono' => 'fas fa-user'])
        </div>

        <!-- Número de Archivos -->
        <div class="col-xl-3 col-md-6 mb-4">
            @include('layouts.admin.total_block', ['color' => "info", 'titulo' => "Número de Archivos cargados", 'total' => $archivos->count(), 'icono' => 'fas fa-box-archive'])
        </div>

        <!-- Número de Visitas -->
        <div class="col-xl-3 col-md-6 mb-4">
            @include('layouts.admin.total_block', ['color' => "info", 'titulo' => "Número de Visitas a Articulos Global", 'total' => $visitas->count(), 'icono' => 'fas fa-eye'])
        </div>

        <!-- Número de descargas -->
        <div class="col-xl-3 col-md-6 mb-4">
            @include('layouts.admin.total_block', ['color' => "warning", 'titulo' => "Número de Descargas realizadas", 'total' => $descargas->count(), 'icono' => 'fas fa-download'])
        </div>
    </div>

    <!-- Primera Linea -->
    <div class="row">
        <!-- Linea Grafico - Número de Visitas -->
        <div class="col-xl-8 col-lg-7">
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
                "action" => "articulo.filter",
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

        <!-- Pie Chart - Estados de los Comentarios Global -->
        <div class="col-xl-4 col-lg-5">
            @php
                $nombre = array("aceptados", "pendiente", "rechazados");
                $colorBg = array("#FA9555", "#C77644", "#7A5F4E");

                if($comentarios){
                    $data = array();
                    array_push($data,$comentarios->where('estado', 'aceptado')->count());
                    array_push($data,$comentarios->where('estado', 'pendiente')->count());
                    array_push($data,$comentarios->where('estado', 'rechazado')->count());
                }
                else{
                    $data = array(0,0,0);
                }

                $chart_data = array(
                    'titulo' => "Nro. de comentarios y su estado",
                    'canva' => 'c1',
                    'labels' => $nombre,
                    'datos' => $data,
                    'tipo' => "normal",
                    'bgColors' => $colorBg,
                    'brColors' => '#7A492A'
                );
            @endphp
            @include('layouts.admin.total_pie', ['datos' => $chart_data])
        </div>
    </div>

    <!-- Segunda Linea -->
    <div class="row">
        
        <!-- Barras Grafico - Numero de Descargas por Artículo mes a mes -->
        <div class="col-xl-8 col-lg-7">
            @php
            $data = array_fill(0, 12, 0);
            $nombre = $articulos->find($id_article) ? $articulos->find($id_article)->titulo : "N/A";

            foreach($d_articulo as $descarga){
                $data[($descarga->mes - 1)] = $descarga->total;
            }

            $chart_data = array(
                'titulo' => $nombre." - Descargas periodo ".date('Y'),
                'canva' => 'c2',
                'labels' => array("Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dec"),
                'datos' => $data,
                'tipo' => "normal",
                'bgColors' => 'rgba(255,48,23,0.7)',
                'brColors' => 'rgba(128,23,11,0.8)'
            );

            $opciones = array();
            foreach($articulos as $articulo){
                $info = array("id" => $articulo->id_articulo, "nombre" => $articulo->titulo);
                array_push($opciones, $info);
            }

            $form_data = array(
                "action" => "articulo.filter",
                "titulo" => "Filtro de Número de Visitas",
                "id_form" => "form_c2",

                "componentes" => array(
                    array(
                        "id_name" => "descargas_periodo",
                        "form_name" => "descargas_periodo",
                        "tipo" => "input",
                        "label" => "Año a evaluar",
                        "icon" => "fa-calendar-o",
                        "dato_tipo" => "number",
                        "placeholder" => "Ingresa el año a evaluar",
                        "validate" => "Año es requerido",
                        "requerido" => "required",
                    ),
                    array(
                        "id_name" => "form_article",
                        "form_name" => "form_article",
                        "tipo" => "select",
                        "label" => "Artículo a Filtrar",
                        "icon" => "fa-leanpub",
                        "dato_tipo" => "select",
                        "titulo" => "Selecciona un Artículo",
                        "opciones" => $opciones,
                        "validate" => "Artículo es requerido",
                        "requerido" => "required",
                    ),
                )
            );

            @endphp
            @include('layouts.admin.total_bar', ['datos' => $chart_data, 'datos_form' => $form_data])
        </div>

        <!-- Progress Bar - Número de Articulos -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Número de artículos por Autores</h6>
                </div>
                <div class="card-body">
                    @forelse($autores as $autor)
                        <h4 class="small font-weight-bold">{{ $autor->nombre }} 
                            <span class="float-right">{{ $autor->articles->count() }}</span>
                        </h4>
                        <div class="progress mb-4">
                            <div class="progress-bar bg-gradient-info" role="progressbar" 
                                style="width: <?php echo $articulos->count() ? $autor->articles->count() * 100 / $articulos->count() : '0' ?>%"
                                aria-valuenow="{{ $articulos->count() ? $autor->articles->count() * 100 / $articulos->count() : '0' }}" 
                                aria-valuemin="0" aria-valuemax="100">
                            </div>
                        </div>
                    @empty
                        <p>No hay autores cargados...</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Tercera Linea -->
    <div class="row">

        <!-- Doble Barras - Visita y Decargas por edición con sus articulos -->
        <div class="col">
            @php
                $edi_title = $edicion ? $edicion->titulo : "N/A";
                $labels = array();
                $b_descargas = array();
                $b_visitas = array();

                if($edicion){
                    if($edicion->articulos){
                        foreach($edicion->articulos as $articulo){
                            array_push($labels, $articulo->titulo);
                            array_push($b_descargas, $articulo->descargas->sum('total'));
                            array_push($b_visitas, $articulo->visitas->sum('total'));
                        }
                    }
                }

                $chart_data = array(
                    'titulo' => "Relación de Descargas y Visitas por Edición - ".$edi_title,
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
                
                
            $opciones = array();
            foreach($ediciones as $edicion){
                $info = array("id" => $edicion->id_edicion, "nombre" => $edicion->titulo);
                array_push($opciones, $info);
            }

            $form_data = array(
                "action" => "articulo.filter",
                "titulo" => "Filtro de Número de Visitas",
                "id_form" => "form_c5",

                "componentes" => array(
                    array(
                        "id_name" => "form_edicion",
                        "form_name" => "form_edicion",
                        "tipo" => "select",
                        "label" => "Edición a Filtrar",
                        "icon" => "fa-leanpub",
                        "dato_tipo" => "select",
                        "titulo" => "Selecciona una Edición",
                        "opciones" => $opciones,
                        "validate" => "Edición es requerido",
                        "requerido" => "required",
                    ),
                )
            );
            @endphp
            @include('layouts.admin.total_double_bar', ['datos' => $chart_data, 'datos_form' => $form_data])
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