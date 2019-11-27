<div class="page">
    <div class="page-main">
        <div class="app-content  my-3 my-md-5" id="appContent">
            <div class="side-app">
                <div class="page-header">
                    <h4 class="page-title">Bienvenido al Sistema Inteligente</h4>
                    <a id="updateCharts" class="btn btn-outline-primary btn-pill "><i class="fa fa-refresh"></i></a>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">___APPNAME___</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Inicio</li>
                    </ol>
                </div>
                <div class="row waitPls">
                    <div class="col-lg-12">
                        <div class="alert alert-primary d-none d-lg-block" role="alert">
                            <button type="button" class="close text-white" data-dismiss="alert" aria-hidden="true">×</button>
                            <strong>Actualizando...</strong> <i class="fa fa-refresh fa-2x fa-spin"></i>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8">
                        <div class="col-md-12">
                            <div class="card ">
                                <div class="card-header">
                                    <h3 class="card-title"><i class="si si-rocket"></i> Historico de envolvimiento</h3>
                                    <div class="card-options">
                                        <a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
                                        <a href="#" class="card-options-remove" data-toggle="card-remove"><i class="fe fe-x"></i></a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="text-center">
                                        <ul class="legend align-items-center ">
                                            <li>
                                                <span class="legend-dots bg-primary"></span>Pedidos Nuevos<span class="ml-2 float-right"></span>
                                            </li>
                                            <li>
                                                <span class="legend-dots bg-warning"></span>Nuevos Clientes<span class="ml-2 float-right"></span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div id="activacioChart" class="chartsh dropshadow"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="card-title"><i class="si si-pie-chart"></i> Top Sintomas</div>
                                    <div class="card-options">
                                        <a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
                                        <a href="#" class="card-options-remove" data-toggle="card-remove"><i class="fe fe-x"></i></a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div id="sitomorriss" class="chartmorris  dropshadow"></div>
                                </div>
                                <div class="card-header">
                                    <div class="card-title currentSintoma">
                                        <h1></h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class=" col-md-12">
                            <div class="card bg-primary">
                                <div class="card-body">
                                    <div class="d-flex no-block align-items-center">
                                        <div>
                                            <h6 class="text-white">Nuevos Clientes</h6>
                                            <h2 class="text-white m-0 countInd font-weight-normal" id="newClis">0</h2>
                                        </div>
                                        <div class="ml-auto">
                                            <span class="text-white display-6"><i class="fa fa-user-plus fa-2x"></i></span>
                                        </div>
                                        <div class="offscreen" id="newClis_obj"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class=" col-md-12">
                            <div class="card bg-info">
                                <div class="card-body">
                                    <div class="d-flex no-block align-items-center">
                                        <div>
                                            <h6 class="text-white">Nuevos Proveedores</h6>
                                            <h2 class="text-white m-0 countInd font-weight-normal" id="newProv">0</h2>
                                        </div>
                                        <div class="ml-auto">
                                            <span class="text-white display-6"><i class="fa fa-user-md fa-2x"></i></span>
                                        </div>
                                        <div class="offscreen" id="newProv_obj"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class=" col-md-12">
                            <div class="card bg-warning">
                                <div class="card-body">
                                    <div class="d-flex no-block align-items-center">
                                        <div>
                                            <h6 class="text-white">Total de Pedidos</h6>
                                            <h2 class="text-white m-0 countInd font-weight-normal" id="allped">0</h2>
                                        </div>
                                        <div class="ml-auto">
                                            <span class="text-white display-6"><i class="fa fa-file-text fa-2x"></i></span>
                                        </div>
                                        <div class="offscreen" id="allped_obj"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class=" col-md-12">
                            <div class="card bg-success">
                                <div class="card-body">
                                    <div class="d-flex no-block align-items-center">
                                        <div>
                                            <h6 class="text-white">Pedidos Atendidos</h6>
                                            <h2 class="text-white m-0 countInd font-weight-normal" id="peda">0</h2>
                                        </div>
                                        <div class="ml-auto">
                                            <span class="text-white display-6"><i class="fa fa-smile-o fa-2x"></i></span>
                                        </div>
                                        <div class="offscreen" id="peda_obj"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class=" col-md-12">
                            <div class="card bg-danger">
                                <div class="card-body">
                                    <div class="d-flex no-block align-items-center">
                                        <div>
                                            <h6 class="text-white">Pedidos Abandonados</h6>
                                            <h2 class="text-white m-0 countInd font-weight-normal" id="pedab">0</h2>
                                        </div>
                                        <div class="ml-auto">
                                            <span class="text-white display-6"><i class="fa fa-frown-o fa-2x"></i></span>
                                        </div>
                                        <div class="offscreen" id="pedab_obj"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title"><i class="si si-magnifier"></i> Seguimiento de Médicos</h3>
                                <div class="card-options">
                                    <a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
                                    <a href="#" class="card-options-remove" data-toggle="card-remove"><i class="fe fe-x"></i></a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="text-center">
                                    <ul class="legend align-items-center ">
                                        <li>
                                            <span class="legend-dots bg-primary"></span><span class="ml-2 float-right">Proveedores Nuevos</span>
                                        </li>
                                        <li>
                                            <span class="legend-dots bg-danger"></span><span class="ml-2 float-right">&Uacute;ltima Conexion</span>
                                        </li>
                                    </ul>
                                </div>
                                <div id="medTwo" class="chart-tasks dropshadow h-400"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title"><i class="si si-location-pin"></i> Mapa de Calor</h3>
                                <div class="card-options">
                                    <a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
                                    <a href="#" class="card-options-remove" data-toggle="card-remove"><i class="fe fe-x"></i></a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div id="mapShow"></div>
                            </div>
                            <div class="card-footer">
                                <h3 class="card-title"> Filtrar por: </h3>
                                &nbsp;<a  class="text-white btn btn-primary remarker" id="filterMedic"><i class="fa fa-user-md fa-2x"></i> <span>Médicos</span> </a>&nbsp;
                                &nbsp;<a  class="text-white btn btn-info remarker" id="filterClient"><i class="fa fa-user fa-2x"></i> <span>Clientes</span></a>&nbsp;
                                &nbsp;<a  class="text-white btn btn-success remarker" id="filterPed"><i class="fa fa-check fa-2x"></i> <span>Pedidos</span></a>&nbsp;
                                &nbsp;<a  class="text-white btn btn-secondary remarker" id="filterAll"><i class="fa fa-users fa-2x"></i> <span>Todos</span></a>&nbsp;
                                <div class="offscreen" id="dataMap_obj"></div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!--footer-->
    <footer class="footer">
        <div class="container">
            <div class="row align-items-center flex-row-reverse">
                <div class="col-md-12 col-sm-12 mt-3 mt-lg-0 text-center">
                    ___DERECHOSDEAUTOR___
                </div>
            </div>
        </div>
    </footer>
    <!-- End Footer-->
    <!-- Back to top -->
    <a href="#top" id="back-to-top"><i class="fa fa-angle-up"></i></a>
</div>