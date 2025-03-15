<script type="text/javascript" src="../js/registro_clases.js?rev=<?php echo time(); ?>"></script>

<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="../Plantilla/plugins/select2/select2.min.css">
<div class="col-md-12">
    <div class="box box-warning box-solid">
        <div class="box-header with-border">
            <input type="text" id="id_docente_verifity" hidden>
            <h3 class="box-title">REGISTRO DE CLASES VIRTUALES</h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
            </div>
            <!-- /.box-tools -->
        </div>
        <!-- /.box-header -->
        <div class="box-body">

            <div class="form-group">
                <div class="col-lg-3" hidden>
                    <label for="">Asignatura</label>
                    <select class="js-example-basic-single" name="state" id="cbm_asignatura" style="width:100%;">
                    </select>
                    <br>
                    <br>
                </div>
                
                <div class="col-lg-3" hidden>
                    <label for="">Mis Grupos</label>
                    <select class="js-example-basic-single1" name="state" id="cbm_grado" style="width:100%;">
                    </select>
                    <br>
                    <br>
                </div>

                <div class="col-lg-3">
                    <label for="">Mis Grupos</label>
                    <select class="js-example-basic-single1" name="state" id="cbm_grupo" style="width:100%;">
                    </select>
                    <br>
                    <br>
                </div>

                <div class="col-lg-3">
                    <label for="">&nbsp;</label>
                    <br>
                    <button class="btn btn-primary" style="width:100%" onclick="buscar()"><i class="fa fa-search"></i> Listar</button>
                </div>
                
                <div class="col-lg-3">
                    <label for="">&nbsp;</label>
                    <br>
                    <button class="btn btn-danger" style="width:100%" onclick="AbrirModalRegistro()"><i class="glyphicon glyphicon-plus"></i>&nbsp; Registrar Clases</button>
                </div>

                <div class="col-lg-3">
                    <label for="">&nbsp;</label>
                    <br>
                    <button class="btn btn-success" style="width:100%" onclick="window.open('video_conferencia/conferencias.php', '_blank');"><i class="fa fa-commenting-o"></i>&nbsp; Iniciar video llamada</button>
                </div>
                
            </div>
            <br>
            <br>
            <br>

            <div class="col-lg-12 table-responsive ">
                <table id="tabla_asignaciones_clases" class=" display  nowrap text-center" style="width:100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Link videoconferencia</th>
                            <th>Estado</th>
                            <th>Fecha</th>
                            <th>Acci&oacute;n</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Link videoconferencia</th>
                            <th>Estado</th>
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

<!-- modar para registrar link -->
<form autocomplete="false" onsubmit="return false" id="modal1">
    <div class="modal fade" id="modal_registro" role="dialog">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header" style="text-align:center">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><i class="fa  fa-desktop"></i><b>&nbsp; Registrar clases</b></h4>
                </div>

                <div class="modal-body">
                    <div class="row">

                        <div class="col-lg-12">
                            <label for="">&nbsp; Mis Grupos</label>
                            <select class="js-example-basic-single" name="state" id="cbm_grupos" style="width:100%;">
                            </select>
                            <br>
                            <br>
                        </div>

                        <div class="col-lg-12">
                            <label for="">Link de videoconferencia</label>
                            <br>
                            <input type="text" class="form-control" id="txt_link">
                        </div>
                        
                        <div class="col-lg-12">
                            <label for="">&nbsp; Fecha</label>
                            <input type="date" class="form-control" id="fecha">
                            <br>
                        </div>
                        
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="Registrar_asignacion_clases()"><i class="fa fa-check"><b>&nbsp;Registrar</b></i></button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"><b>&nbsp;Cerrar</b></i></button>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- modar para editar link -->
<form autocomplete="false" onsubmit="return false" id="modal1">
    <div class="modal fade" id="modal_editar_clases_virtual" role="dialog">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header" style="text-align:center">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-desktop"></i><b>&nbsp; Editar Clase Virtual</b></h4>
                </div>
                <div class="modal-body">
                    <div class="row">

                        <input type="text" class="form-control" id="id_editar" style="display: none;">

                        <div class="col-lg-12">
                            <label for="">&nbsp; Mis Grupos</label>
                            <select class="js-example-basic-single" name="state" id="cbm_grupo_editar" style="width:100%;">
                            </select>
                            <br>
                            <br>
                        </div>

                        <div class="col-lg-12">
                            <label for="">Link de videoconferencia</label>
                            <br>
                            <input type="text" class="form-control" id="txt_link_editar">
                        </div>
                        
                        <div class="col-lg-12">
                            <label for="">&nbsp; Fecha</label>
                            <input type="date" class="form-control" id="fecha_editar">
                            <br>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="editar_clases_link()"><i class="fa fa-check"><b>&nbsp;Editar</b></i></button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"><b>&nbsp;Cerrar</b></i></button>
                </div>
            </div>
        </div>
    </div>
</form>


<script src="../Plantilla/plugins/select2/select2.min.js"></script>
<script>
    $(document).ready(function() {

       $('.js-example-basic-single1').select2();
       $('.js').select2();
       listar_asignaciones_clases();
       listar_combo_asignatura();
       listar_combo_grado();
       listar_combo_grupo();
       listar_combo_grupos();
       TraerfechaL();
       listar_combo_verificar_docente();
       listar_combo_grupo_editar();
       datos();
       listar_combo_grupo();
      

       $("#cbm_grupo").change(function(){
         var id_grupo = $("#cbm_grupo").val();
         listar_combo_grado(id_grupo);
         listar_combo_asignatura(id_grupo);
         listar_combo_estudiantes();
     });

       document.getElementById('txt_archivo').addEventListener("change" , () => {
        var FileName  = document.getElementById('txt_archivo').value;
        var idDot = FileName.lastIndexOf(".") + 1;
        var exfile = FileName.substr(idDot , FileName.length).toLowerCase();
        if (exfile =="pdf" || exfile == "doc") {

        }else{
          document.getElementById('txt_archivo').value = "";
          Swal.fire("Mensaje De Advertencia", "SOLO SE ACEPTA IMAGENES - USTED SUBIO UN ARCHIVO CON EXTENCION "+exfile,"warning");
      }
  });  
       document.getElementById('txt_archivo_editar').addEventListener("change" , () => {
        var FileName  = document.getElementById('txt_archivo_editar').value;
        var idDot = FileName.lastIndexOf(".") + 1;
        var exfile = FileName.substr(idDot , FileName.length).toLowerCase();
        if (exfile =="pdf" || exfile == "doc") {

        }else{
          document.getElementById('txt_archivo_editar').value = "";
          Swal.fire("Mensaje De Advertencia", "SOLO SE ACEPTA IMAGENES - USTED SUBIO UN ARCHIVO CON EXTENCION "+exfile,"warning");
      }
  });  
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
