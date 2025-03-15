<script type="text/javascript" src="../js/detalles_asistencias.js?rev=<?php echo time(); ?>"></script>

<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="../Plantilla/plugins/select2/select2.min.css">
<div class="col-md-12">
    <div class="box box-warning box-solid">
        <div class="box-header with-border">
            <h3 class="box-title">DETALLES DE ASISTENCIAS</h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
            </div>
            <!-- /.box-tools -->
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <input type="text" id="id_grupo" hidden>
            <div class="form-group">
                <div class="col-lg-6" hidden>
                    <div class="small-box bg-aqua">
                        <div class="inner" style="height: 100px;">
                            <p>INASISTENCIAS GENERALES</p>
                            <h3 id="txtregistro"></h3>
                            <div class="icon">
                                <i class="fa fa-calendar"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12 d-flex justify-content-center align-items-center">
                    <div class="small-box bg-aqua" style="width: 100%;">
                        <div class="inner text-center" style="height: 120px;">
                            <p>INASISTENCIAS</p>
                            <h3 id="txtregistroINA"></h3>
                        </div>
                        <div class="icon">
                            <i class="fa fa-calendar"></i>
                        </div>
                    </div>
                </div>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>

                <div class="col-lg-4" hidden>
                    <label for="">Asignatura</label>
                    <select class="js-example-basic-single" name="state" id="cbm_asignatura" style="width:100%;"></select>
                    <br>
                    <br>
                </div>

                <div class="col-lg-4" hidden>
                    <label for="">Mis Grupos</label>
                    <select class="js-example-basic-single" name="state" id="cbm_grado" style="width:100%;"></select>
                    <br>
                    <br>
                </div>

                <div class="col-lg-6">
                    <label for="">Mis Grupos</label>
                    <select class="js-example-basic-single" name="state" id="cbm_grupo" style="width:100%;"></select>
                    <br>
                    <br>
                </div>

                <div class="col-lg-3">
                    <label for="">Fecha de asistencia</label>
                    <input type="date" name="state" id="cbm_estudiantes" style="width:100%;">
                    <br>
                    <br>
                </div>

                <div class="col-lg-3">
                    <label for="">&nbsp;</label>
                    <br>
                    <button class="btn btn-primary" style="width:100%" onclick="datos()"><i class="fa fa-search"></i> Listar
                    </button>
                </div>
            </div>

            <style>
                .d-flex {
                    display: flex;
                }
    
                .justify-content-center {
                    justify-content: center;
                }
    
                .align-items-center {
                    align-items: center;
                }
    
                .text-center {
                    text-align: center;
                }
            </style>
            <br>
            <br>
            <br>

            <div class="col-lg-12 table-responsive">
                <table id="tabla_detalles_asistencias" class="display responsive nowrap text-center" style="width:100% ">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Estudiantes</th>
                            <th>Asistencia</th>
                            <th>Dia</th>
                            <th>Fecha</th>
                            <th>Acci&oacute;n</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <th>#</th>
                        <th>Estudiantes</th>
                        <th>Asistencia</th>
                        <th>Dia</th>
                        <th>Fecha</th>
                        <th>Acci&oacute;n</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
</div>

<div class="modal fade" id="modal_ver_asistencia_estudiante" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="text-align:center">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 id="grado_modal_title" class="modal-title"><i class="fa fa-check-square-o"></i><b>&nbsp; Asistencias
                        del estudiante</b></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <!-- /.box-header -->
                    <div class="box-body">
                        <input type="text" id="id_ES" hidden>
                        <div class="form-group">
                            <div class="col-lg-6" hidden>
                                <div class="small-box bg-aqua">
                                    <div class="inner" style="height: 100px;">
                                        <h3 id="txtregistro"></h3>
                                        <p>INASISTENCIAS GENERALES</p>
                                        <div class="icon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-lg-12 d-flex justify-content-center align-items-center">
                                <div class="small-box bg-aqua" style="width: 100%;">
                                    <div class="inner text-center" style="height: 120px;">
                                        <p>INASISTENCIAS</p>
                                        <h3 id="txtregistro1"></h3>
                                    </div>
                                    <div class="icon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-lg-4" hidden>
                                <label for="">Asignatura</label>
                                <select class="js-example-basic-single" name="state" id="cbm_asignatura" style="width:100%;">
                                </select>
                                <br>
                                <br>
                            </div>
                            
                            <div class="col-lg-4" hidden>
                                <label for="">Mis Grupos</label>
                                <select class="js-example-basic-single" name="state" id="cbm_grado" style="width:100%;">
                                </select>
                                <br>
                                <br>
                            </div>

                            <div class="col-lg-6" hidden>
                                <label for="">Mis Grupos</label>
                                <select class="js-example-basic-single" name="state" id="cbm_grupo2" style="width:100%;">
                                </select>
                                <br>
                                <br>
                            </div>
                            
                            <div class="col-lg-3" hidden>
                                <label for="">Estudiantes</label>
                                <select class="js-example-basic-single" name="state" id="cbm_estudiantes2" style="width:100%;">
                                </select>
                                <br>
                                <br>
                            </div>
                            
                            <div class="col-lg-3" hidden>
                                <label for="">&nbsp;</label>
                                <br>
                                <button class="btn btn-primary" style="width:100%" onclick="datos()"><i class="fa fa-search"></i> Listar</button>
                            </div>
                        </div>
                        <br>
                        <br>
                        <br>

                        <div class="col-lg-12 table-responsive">
                            <table id="tabla_detalles_asistencias_ES" class="display responsive nowrap text-center" style="width:100% ">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Estudiantes</th>
                                        <th>Asistencia</th>
                                        <th>Dia</th>
                                        <th>Fecha</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <th>#</th>
                                    <th>Estudiantes</th>
                                    <th>Asistencia</th>
                                    <th>Dia</th>
                                    <th>Fecha</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <!-- /.box-body -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"><b>&nbsp;Cerrar</b></i></button>
                </div>
            </div>
        </div>
    </div>


    <script src="../Plantilla/plugins/select2/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.js-example-basic-single').select2();
    
            listar_combo_asignatura();
            listar_combo_grado();
            listar_combo_estudiantes();
            listar_detalles_asistencias();
            TraerDatosContador();
            TraerDatosContador1();
            datos();
            listar_combo_grupo();
            listar_combo_estudiantes_2();
            listar_combo_grupo_2();
    
            $("#cbm_grupo").change(function() {
                var id_grupo = $("#cbm_grupo").val();
                listar_combo_grado(id_grupo);
                listar_combo_asignatura(id_grupo);
                listar_combo_estudiantes();
            });
            
            $("#cbm_asignatura").change(function() {
                var id_asignatura = $("#cbm_asignatura").val();
                listar_calificaciones(id_asignatura, '');
            });
            
            $("#cbm_grado").change(function() {
                var id_grado = $("#cbm_grado").val();
                listar_calificaciones(id_grado, '');
            });
            
            $("#modal_registro_especialidad").on('shown.bs.modal', function() {
                $("#txt_especialidad").focus();
            })
        });
    
        $('.box').boxWidget({
            animationSpeed: 500,
            collapseTrigger: '[data-widget="collapse"]',
            removeTrigger: '[data-widget="remove"]',
            collapseIcon: 'fa-minus',
            expandIcon: 'fa-plus',
            removeIcon: 'fa-times'
        })
        $(document).ready(function() {
    
    
        })
    </script>
