@extends('layouts.admin.app')

@section('content')
    <!-- TOTALES DE BLOQUES -->
    <div class="row">

        <!-- Número de Ediciones -->
        <div class="col-xl-3 col-md-6 mb-4">
            @include('layouts.admin.total_block', ['color' => "primary", 'titulo' => "Número de Ediciones Cargadas", 'total' => "25", 'icono' => 'fas fa-newspaper'])
        </div>

        <!-- Número de Areas de Conocimiento -->
        <div class="col-xl-3 col-md-6 mb-4">
            @include('layouts.admin.total_block', ['color' => "success", 'titulo' => "Areas de Conocimiento Existentes", 'total' => "5", 'icono' => 'fas fa-flask'])
        </div>

        <!-- Número de visitas -->
        <div class="col-xl-3 col-md-6 mb-4">
            @include('layouts.admin.total_block', ['color' => "info", 'titulo' => "Número de Visitas a Ediciones", 'total' => "5", 'icono' => 'fas fa-eye'])
        </div>
        <!-- Número de descargas -->
        <div class="col-xl-3 col-md-6 mb-4">
            @include('layouts.admin.total_block', ['color' => "warning", 'titulo' => "Número de Descargas realizadas", 'total' => "5", 'icono' => 'fas fa-download'])
        </div>
    </div>

    <!-- Ediciones nro artículos y barra de descargas -->
    <div class="row">
        <!-- Line Chart - Número de Visitas -->
        <div class="col">
            @php
                $data = array(10, 15, 5, 26, 18, 20, 9, 46, 34, 19, 26, 200);

                $chart_data = array(
                    'titulo' => "Número de visitas globales por mes",
                    'canva' => 'c1',
                    'labels' => array("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"),
                    'datos' => $data,
                    'tipo' => "normal",
                    'bgColors' => 'rgba(255,48,23,0.7)',
                    'brColors' => 'rgba(128,23,11,0.8)'
                );
            @endphp
            @include('layouts.admin.total_area', ['datos' => $chart_data])
        </div>

        <!-- Doble Barras -->
        <div class="col">
            @php
                $data_1 = array(10, 15, 5, 26, 18, 20, 9, 46, 34, 19, 26, 200);
                $data_2 = array(25, 38, 156, 7, 43, 55, 19, 187, 91, 3, 10, 25);

                $chart_data = array(
                    'titulo' => "Otra vaina",
                    'canva' => 'c4',
                    'labels' => array("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"),
                    'bar1_datos' => $data_1,
                    'bar1_labels' => "EQUIS",
                    'bar1_bgColors' => 'rgba(255,48,23,0.7)',
                    'bar1_brColors' => 'rgba(128,23,11,0.8)',
                    'bar2_datos' => $data_2,
                    'bar2_labels' => "YE",
                    'bar2_bgColors' => 'rgba(250,250,23,0.7)',
                    'bar2_brColors' => 'rgba(100,206,11,0.8)'
                );
            @endphp
            @include('layouts.admin.total_double_bar', ['datos' => $chart_data])
        </div>
    </div>

    <!-- Ediciones nro artículos y barra de descargas -->
    <div class="row">
        <!-- Bar Chart - Número de Visitas -->
        <div class="col-xl-8 col-lg-7">
            @php
                $data = array(10, 15, 5, 26, 18, 20, 9, 46, 34, 19, 26, 200);

                $chart_data = array(
                    'titulo' => "Otra vaina",
                    'canva' => 'c2',
                    'labels' => array("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"),
                    'datos' => $data,
                    'tipo' => "normal",
                    'bgColors' => 'rgba(255,48,23,0.7)',
                    'brColors' => 'rgba(128,23,11,0.8)'
                );
            @endphp
            @include('layouts.admin.total_bar', ['datos' => $chart_data])
        </div>

        <!-- Pie Chart -->
        <div class="col-xl-4 col-lg-5">
            @php
                $colorBg = array(
                    "rgba(255,48,23,0.50)",
                    "rgba(255,48,23,0.75)",
                    "rgba(255,48,23,1)"
                );

                $data = array(10, 15, 5);

                $chart_data = array(
                    'titulo' => "PIE TEST",
                    'canva' => 'c3',
                    'labels' => array("Jan", "Feb", "Mar"),
                    'datos' => $data,
                    'tipo' => "normal",
                    'bgColors' => $colorBg,
                    'brColors' => 'rgba(128,23,11,0.8)'
                );
            @endphp
            @include('layouts.admin.total_pie', ['datos' => $chart_data])
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">

        <!-- Content Column -->
        <div class="col-lg-6 mb-4">

            <!-- Project Card Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Projects</h6>
                </div>
                <div class="card-body">
                    <h4 class="small font-weight-bold">Server Migration <span
                            class="float-right">20%</span></h4>
                    <div class="progress mb-4">
                        <div class="progress-bar bg-danger" role="progressbar" style="width: 20%"
                            aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <h4 class="small font-weight-bold">Sales Tracking <span
                            class="float-right">40%</span></h4>
                    <div class="progress mb-4">
                        <div class="progress-bar bg-warning" role="progressbar" style="width: 40%"
                            aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <h4 class="small font-weight-bold">Customer Database <span
                            class="float-right">60%</span></h4>
                    <div class="progress mb-4">
                        <div class="progress-bar" role="progressbar" style="width: 60%"
                            aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <h4 class="small font-weight-bold">Payout Details <span
                            class="float-right">80%</span></h4>
                    <div class="progress mb-4">
                        <div class="progress-bar bg-info" role="progressbar" style="width: 80%"
                            aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <h4 class="small font-weight-bold">Account Setup <span
                            class="float-right">Complete!</span></h4>
                    <div class="progress">
                        <div class="progress-bar bg-success" role="progressbar" style="width: 100%"
                            aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>

            <!-- Color System -->
            <div class="row">
                <div class="col-lg-6 mb-4">
                    <div class="card bg-primary text-white shadow">
                        <div class="card-body">
                            Primary
                            <div class="text-white-50 small">#4e73df</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-4">
                    <div class="card bg-success text-white shadow">
                        <div class="card-body">
                            Success
                            <div class="text-white-50 small">#1cc88a</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-4">
                    <div class="card bg-info text-white shadow">
                        <div class="card-body">
                            Info
                            <div class="text-white-50 small">#36b9cc</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-4">
                    <div class="card bg-warning text-white shadow">
                        <div class="card-body">
                            Warning
                            <div class="text-white-50 small">#f6c23e</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-4">
                    <div class="card bg-danger text-white shadow">
                        <div class="card-body">
                            Danger
                            <div class="text-white-50 small">#e74a3b</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-4">
                    <div class="card bg-secondary text-white shadow">
                        <div class="card-body">
                            Secondary
                            <div class="text-white-50 small">#858796</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-4">
                    <div class="card bg-light text-black shadow">
                        <div class="card-body">
                            Light
                            <div class="text-black-50 small">#f8f9fc</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-4">
                    <div class="card bg-dark text-white shadow">
                        <div class="card-body">
                            Dark
                            <div class="text-white-50 small">#5a5c69</div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="col-lg-6 mb-4">

            <!-- Illustrations -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Illustrations</h6>
                </div>
                <div class="card-body">
                    <div class="text-center">
                        <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 25rem;"
                            src="img/undraw_posting_photo.svg" alt="...">
                    </div>
                    <p>Add some quality, svg illustrations to your project courtesy of <a
                            target="_blank" rel="nofollow" href="https://undraw.co/">unDraw</a>, a
                        constantly updated collection of beautiful svg images that you can use
                        completely free and without attribution!</p>
                    <a target="_blank" rel="nofollow" href="https://undraw.co/">Browse Illustrations on
                        unDraw &rarr;</a>
                </div>
            </div>

            <!-- Approach -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Development Approach</h6>
                </div>
                <div class="card-body">
                    <p>SB Admin 2 makes extensive use of Bootstrap 4 utility classes in order to reduce
                        CSS bloat and poor page performance. Custom CSS classes are used to create
                        custom components and custom utility classes.</p>
                    <p class="mb-0">Before working with this theme, you should become familiar with the
                        Bootstrap framework, especially the utility classes.</p>
                </div>
            </div>

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