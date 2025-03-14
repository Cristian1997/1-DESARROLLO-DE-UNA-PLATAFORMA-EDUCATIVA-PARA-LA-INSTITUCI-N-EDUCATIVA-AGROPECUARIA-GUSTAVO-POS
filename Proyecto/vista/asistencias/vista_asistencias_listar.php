<script type="text/javascript" src="../js/asistencias.js?rev=<?php echo time(); ?>"></script>

<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="../Plantilla/plugins/select2/select2.min.css">
<div class="col-md-12">
    <div class="box box-warning box-solid">



        <div class="box-header with-border">

            <h3 class="box-title">ASISTENCIAS</h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
            </div>
            <!-- /.box-tools -->
        </div>
        <!-- /.box-header -->
        <div class="box-body">

            <div class="form-group">

                <div class="col-lg-4" hidden>

                    <label for="">Asignatura</label>
                    <select class="js-example-basic-single" name="state" id="cbm_asignatura" style="width:100%;">

                    </select><br><br>

                </div>
                <div class="col-lg-4" hidden>
                    <label for="">Mis Grupos</label>
                    <select class="js-example-basic-single" name="state" id="cbm_grado" style="width:100%;">

                    </select><br><br>

                </div>

                <div class="col-lg-4">
                    <label for="">Mis Grupos</label>
                    <select class="js-example-basic-single" name="state" id="cbm_grupo" style="width:100%;">

                    </select><br><br>

                </div>


                <div class="col-lg-2">
                    <label for="">&nbsp;</label><br>
                    <button class="btn btn-primary" style="width:100%" onclick="datos()"><i
                            class="fa fa-search"></i>Listar</button>

                </div>
                <div class="col-lg-2">
                    <label for="">&nbsp;</label><br>
                    <button class="btn btn-success" style="width:100%"
                        onclick="cargar_contenido('contenido_principal','asistencias/vista_talleres_listar.php')"><i
                            class="fa fa-check-square-o"></i>&nbsp;Detalles de Asistecias</button>

                </div>
                <div class="col-lg-2">
                    <label for="">&nbsp;</label><br>
                    <button class="btn btn-danger" style="width:100%" onclick="limpiar_asistencias()"><i
                            class="fa fa-file-o"></i>&nbsp;Limpiar Asistencias</button>

                </div>
                <div class="col-lg-2">
                    <label for="">&nbsp;</label><br>
                    <button class="btn btn-primary" style="width:100%" onclick="guardar_asistencias()"><i
                            class="fa fa-save"></i>&nbsp;Guardar Asistencias</button>

                </div>



            </div><br><br><br>

            <div class="col-lg-12 table-responsive">
                <table id="tabla_asistencias" class="display responsive nowrap text-center" style="width:100% ">
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



<form autocomplete="false" onsubmit="return false" id="modal1">
    <div class="modal fade" id="modal_editar" role="dialog">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header" style="text-align:center">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><b></b></h4>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box box-solid">
                                <div class="box-header with-border">
                                    <i class="fa   fa-list-alt"></i>
                                    <h3 class="box-title">Editar asistencias</h3>
                                </div>
                                <input type="text" id="id_asistencias">
                                <input type="text" id="id_docente">
                                <input type="text" id="id_grupo">
                                <div class="box-body">

                                    <div class="col-lg-12">
                                        <label for="">&nbsp;Asistencia</label><br>
                                        <select class="js-example-basic-single" id="cmb_asistencia"
                                            style="width: 100%;">
                                            <option value="ASISTIÓ">ASISTIÓ</option>
                                            <option value="NO ASISTIÓ">NO ASISTIÓ</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-12"><br>
                                        <label for="">&nbsp;Dia</label><br>
                                        <select class="js-example-basic-single" id="cmb_dia" style="width: 100%;">
                                            <option value="LUNES">LUNES</option>
                                            <option value="MARTES">MARTES</option>
                                            <option value="MIERCOLES">MIERCOLES</option>
                                            <option value="JUEVES">JUEVES</option>
                                            <option value="VIERNES">VIERNES</option>

                                        </select>
                                    </div>


                                </div>

                            </div>

                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i
                            class="fa fa-close"><b>&nbsp;Cerrar</b></i></button>
                    <button type="button" class="btn btn-primary" onclick="Editar_asistencias()"><i
                            class="fa fa-edit"><b>&nbsp;Editar!</b></i></button>
                </div>
            </div>
        </div>
    </div>
</form>



<script src="../Plantilla/plugins/select2/select2.min.js"></script>
<script>
$(document).ready(function() {

    $('.js-example-basic-single').select2();

    listar_combo_asignatura();
    listar_combo_grado();
    listar_asistencias();
    datos();
    listar_combo_grupo();

    $("#cbm_grupo").change(function() {
        var id_grupo = $("#cbm_grupo").val();
        listar_combo_grado(id_grupo);
        listar_combo_asignatura(id_grupo);

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
