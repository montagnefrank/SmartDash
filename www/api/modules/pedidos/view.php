<div class="page">
    <div class="page-main">
        <div class="app-content  my-3 my-md-5" id="appContent">
            <div class="side-app">
                <div class="page-header">
                    <h4 class="page-title">Pedidos Del sistema</h4>
                    <a id="updatePeds" class="btn btn-outline-primary btn-pill "><i class="fa fa-refresh"></i></a>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">___APPNAME___</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Pedidos</li>
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
                <div class="col-md-12 ">
                    <div class="card anim animlv2">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fa fa-medkit" aria-hidden="true"></i> Detalles del Pedido.</h3>
                            <div class="card-options">
                                <a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
                                <a href="#" class="card-options-remove" data-toggle="card-remove"><i class="fe fe-x"></i></a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="card overflow-hidden">
                                        <div class="card-header">
                                            <h3 class="card-title">Nombre</h3>
                                            <div class="card-options">
                                                <a class="btn btn-sm btn-primary" href="#"><i class="fa fa-user"></i></a>
                                            </div>
                                        </div>
                                        <div class="card-body ">

                                            <small class="h6">cedu</small>
                                            <div class="text-dark count mt-0 font-30">Telefono</div>

                                            <div class="progress progress-sm mt-0 mb-2">
                                                <div class="progress-bar bg-success w-100" role="progressbar"></div>
                                            </div>
                                            <div class=""><i class="fa fa-caret-up text-green"></i> Email</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card overflow-hidden">
                                        <div class="card-header">
                                            <h3 class="card-title">Georeferencia</h3>
                                            <div class="card-options">
                                                <a class="btn btn-sm btn-primary" href="#"><i class="fa fa-map-signs" aria-hidden="true"></i></a>
                                            </div>
                                        </div>
                                        <div class="card-body ">
                                            <small class="h6">Direccion</small>
                                            <div class="text-dark count mt-0 font-30">Referencia</div>
                                            <div class="progress progress-sm mt-0 mb-2">
                                                <div class="progress-bar bg-primary w-100" role="progressbar"></div>
                                            </div>
                                            <div class=""><i class="fa fa-caret-up text-blue"></i> Fecha</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card overflow-hidden">
                                        <div class="card-header">
                                            <h3 class="card-title">Interacción</h3>
                                            <div class="card-options">
                                                <a class="btn btn-sm btn-primary" href="#"><i class="fa fa-heartbeat" aria-hidden="true"></i></a>
                                            </div>
                                        </div>
                                        <div class="card-body ">

                                            <small class="h6">Sintoma</small>
                                            <div class="text-dark count mt-0 font-30">Atendido</div>

                                            <div class="progress progress-sm mt-0 mb-2">
                                                <div class="progress-bar bg-danger w-100" role="progressbar"></div>
                                            </div>
                                            <div class=""><i class="fa fa-caret-up text-danger"></i> score</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title"><i class="si si-location-pin"></i> Ubicación</h3>
                                        <div class="card-options">
                                            <a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
                                            <a href="#" class="card-options-remove" data-toggle="card-remove"><i class="fe fe-x"></i></a>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div id="mapDet"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card anim animlv1">
                            <div class="card-header">
                                <div class="card-title"><i class="si si-list"></i> Listado de Pedidos</div>
                                <div class="card-options">
                                    <a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
                                    <a href="#" class="card-options-remove" data-toggle="card-remove"><i class="fe fe-x"></i></a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="pedidosList" class="hover table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Nombre</th>
                                                <th>Teléfono</th>
                                                <th>Atendido</th>
                                                <th>Fecha</th>
                                                <th>Hora</th>
                                                <th>Forma de Pago</th>
                                                <th>Detalles</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>Nombre</th>
                                                <th>Teléfono</th>
                                                <th>Atendido</th>
                                                <th>Fecha</th>
                                                <th>Hora</th>
                                                <th>Forma de Pago</th>
                                                <th>Detalles</th>
                                            </tr>
                                        </tfoot>
                                    </table>

                                </div>
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