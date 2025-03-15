<script type="text/javascript" src="../js/calificaciones.js?rev=<?php echo time(); ?>"></script>

<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="../Plantilla/plugins/select2/select2.min.css">
<div class="col-md-12">
    <div class="box box-warning box-solid">
        <div class="box-header with-border">
            <h3 class="box-title">NOTAS</h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
            </div>
            <!-- /.box-tools -->
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="form-group">
                <input type="text" id="id_docente_verifity" hidden>
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

                <div class="col-lg-6">
                    <label for="">Mis Grupos</label>
                    <select class="js-example-basic-single" name="state" id="cbm_grupo" style="width:100%;">
                    </select>
                    <br>
                    <br>
                </div>

                <div class="col-lg-2">
                    <label for="">&nbsp;</label>
                    <br>
                    <button class="btn btn-primary" style="width:100%" onclick="datos()"><i class="fa fa-search"></i> Listar</button>
                </div>
                
                <div class="row">
                    
                    <div class="col-lg-2">
                        <label for="">&nbsp;</label>
                        <br>
                        <button id="btnImprimir" class="btn btn-danger" style="width:100%" onclick="imprimir_nota()">
                            <i class="fa fa-print"></i> Imprimir notas PDF
                        </button>
                    </div>
                    
                    <div class="col-lg-2">
                        <label for="">&nbsp;</label>
                        <br>
                        <button id="btnImprimirE" class="btn btn-success" style="width:100%" onclick="imprimir_nota_E()">
                            <i class="fa fa-print"></i> Imprimir notas Excel
                        </button>
                    </div>
                    
                </div>

                <div class="col-lg-12 table-responsive">
                    <table id="tabla_calificaciones" class="display responsive nowrap text-center" style="width:100% ">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Estudiantes</th>
                                <th>Nota 25%</th>
                                <th>Nota 25%</th>
                                <th>Nota 25%</th>
                                <th>Nota 25%</th>
                                <th>Definitiva</th>
                                <th>Estado</th>
                                <th>Acci&oacute;n</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <th>#</th>
                            <th>Estudiantes</th>
                            <th>Nota 25%</th>
                            <th>Nota 25%</th>
                            <th>Nota 25%</th>
                            <th>Nota 25%</th>
                            <th>Definitiva</th>
                            <th>Estado</th>
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
    <!-- modar para editar usuarios -->
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
                                    <div class="box-header with-border text-center">
                                        <i class="fa   fa-edit"></i>
                                        <h3 class="box-title">Editar calificaciones</h3>
                                    </div>

                                    <div class="box-body">

                                        <div class="col-lg-12">
                                            <input type="text" id="id_calificaciones">
                                            <input type="text" id="txt_def_editar">
                                            <label for="">&nbsp;Primera Nota</label>
                                            <br>
                                            <input type="text " class="form-control" id="txt_nota1_editar">
                                        </div>
                                        
                                        <div class="col-lg-12">
                                            <label for="">&nbsp;Segunda Nota</label>
                                            <br>
                                            <input type="text" class="form-control" id="txt_nota2_editar">
                                        </div>

                                        <div class="col-lg-12">
                                            <label for="">&nbsp;Tercera Nota</label>
                                            <br>
                                            <input type="text" class="form-control" id="txt_nota3_editar">
                                        </div>
                                        
                                        <div class="col-lg-12">
                                            <label for="">&nbsp;Cuarta Nota</label>
                                            <br>
                                            <input type="text" class="form-control" id="txt_nota4_editar">
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"><b>&nbsp;Cerrar</b></i></button>
                        <button type="button" class="btn btn-primary" onclick="Editar_calificaciones()"><i class="fa fa-edit"><b>&nbsp;Editar!</b></i></button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <script src="../Plantilla/plugins/select2/select2.min.js"></script>
    <script>
        $(document).ready(function() {
         $('.js-example-basic-single').select2();
    
         listar_combo_grupo();
         listar_calificaciones();
         listar_combo_asignatura();
         listar_combo_grado();
         listar_combo_verificar_docente();
         $("#cbm_asignatura").change(function(){
           var id_asignatura = $("#cbm_asignatura").val();
           listar_calificaciones(id_asignatura,'');
    
       }); 
         $("#cbm_grado").change(function(){
           var id_grado = $("#cbm_grado").val();
           listar_calificaciones(id_grado,'');
    
       }); 
         $("#cbm_grupo").change(function(){
           var id_grupo = $("#cbm_grupo").val();
           listar_combo_grado(id_grupo);
           listar_combo_asignatura(id_grupo);
    
       });
         $("#modal_registro_especialidad").on('shown.bs.modal',function(){
            $("#txt_especialidad").focus();
        })
     } );
    
        $('.box').boxWidget({
            animationSpeed : 500,
            collapseTrigger:    '[data-widget="collapse"]',
            removeTrigger  :    '[data-widget="remove"]',
            collapseIcon   :    'fa-minus',
            expandIcon     :    'fa-plus',
            removeIcon     :    'fa-times'
        })
        
        $(document).ready(function(){
        })
    </script>

    <script src="js/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
