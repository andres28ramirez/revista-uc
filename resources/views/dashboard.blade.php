@extends('layouts.admin.app')

@section('title')
    {{ "Dashboard" }}
@endsection

@section('content')
    <!-- Bloque de Totales -->
    <div class="row">

        <!-- Número de Usuarios -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Usuarios Registrados</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totales["usuarios"] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-500"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Número de Autores -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Número de Autores</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totales["autores"] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user fa-2x text-gray-500"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Número de Ediciones -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Ediciones Publicadas</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totales["ediciones"] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-newspaper fa-2x text-gray-500"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Número de Artículos -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Artículos Cargados</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totales["articulos"] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-book fa-2x text-gray-500"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Instructivo y Progreso de Visitas y Descargas -->
    <div class="row">
        <!-- Imagen con el instructivo -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <!-- Header -->
                <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Instrucciones para hacer una publicación</h6>
                </div>
                <!-- Body -->
                <div class="card-body">
                    <img class="img-fluid" src="{{ asset('images/instrucciones.png') }}" alt="intrusctivo">
                </div>
            </div>
        </div>

        <!-- Barra de Progreso (Vistas, Descargas [articulos y ediciones]) -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Relación de Descargas y Visitas</h6>
                </div>
                <div class="card-body">
                    <!-- Descargas -->
                        <h4 class="small font-weight-bold">Descargas de Ediciones <span
                                class="float-right">{{ $relacion["e_des"] }} veces</span></h4>
                        <div class="progress mb-4">
                            <div class="progress-bar" role="progressbar" style="background-color: #084456; width: <?php echo ($relacion['e_des']*100)/$relacion['global'] ?>%"
                                aria-valuenow="{{$relacion['e_des']}}" aria-valuemin="0" aria-valuemax="{{ $relacion['global'] }}"></div>
                        </div>
                        <h4 class="small font-weight-bold">Descargas de Artículos <span
                                class="float-right">{{ $relacion["a_des"] }} veces</span></h4>
                        <div class="progress mb-4">
                            <div class="progress-bar" role="progressbar" style="background-color: #084456; width: <?php echo ($relacion['a_des']*100)/$relacion['global'] ?>%"
                                aria-valuenow="{{ $relacion['a_des'] }}" aria-valuemin="0" aria-valuemax="{{ $relacion['global'] }}"></div>
                        </div>

                    <!-- Visitas -->
                        <h4 class="small font-weight-bold">Visitas de Ediciones <span
                                class="float-right">{{ $relacion['e_vis'] }} veces</span></h4>
                        <div class="progress mb-4">
                            <div class="progress-bar" role="progressbar" style="background-color: #FA9555; width: <?php echo ($relacion['e_vis']*100)/$relacion['global'] ?>%"
                                aria-valuenow="{{ $relacion['e_vis'] }}" aria-valuemin="0" aria-valuemax="{{ $relacion['global'] }}"></div>
                        </div>
                        <h4 class="small font-weight-bold">Visitas de Artículos <span
                                class="float-right">{{ $relacion['a_vis'] }} veces</span></h4>
                        <div class="progress mb-4">
                            <div class="progress-bar" role="progressbar" style="background-color: #FA9555; width: <?php echo ($relacion['a_vis']*100)/$relacion['global'] ?>%"
                                aria-valuenow="{{ $relacion['a_vis'] }}" aria-valuemin="0" aria-valuemax="{{ $relacion['global'] }}"></div>
                        </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Dos bloques informativos -->
    <div class="row">
        <!-- Instrucciones -->
        <div class="col">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Revista Científica</h6>
                </div>
                <div class="card-body">
                    <div class="text-center">
                        <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 25rem;"
                            src="{{ asset('images/revencyt.jpg') }}" alt="...">
                    </div>
                    <p class="text-justify">
                        La Revista Científica se regula bajo los estandares especificados por Revencyt, tomar en cuenta estos estandares al momento de almacenar la información sobre el
                        al momento de la creación de nuevos artículos y ediciones, del mismo modo, respetar los lineamentos al crear archivos para los distintos artículos que vayan a ser cargados sobre la plataforma.
                    </p>
                </div>
            </div>
        </div>

        <!-- Sobre el Panel -->
        <div class="col">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">¿Sobre el Panel?</h6>
                </div>
                <div class="card-body">
                    <p class="text-justify">
                        El panel adminitrativo esta particionado en 3 modulos, Ediciones - Artículos, 
                        Usuarios - Configuración y Notificacionefa-spin. Cada apartado posee las posibilidades para crear, editar, eliminar y ver su analísis en cuanto al uso dado y datos regitrados de los mismos.
                        Por ultimo el apartado de configuraciones permite alterar y modificar apartados dinámicos del panel de usuarios para automatizar los cambios necesarios por los distintos moderadores o editores de la plataforma.
                    </p>
                    <p class="mb-0 text-justify">
                        En generador de reportes nos permitira realizar un respaldo de la información que tengamos almacenada en tablas,
                        estas tablas serviran para dar un reporte del estado actual y la información almacenada sobre la actividad de la página.
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
