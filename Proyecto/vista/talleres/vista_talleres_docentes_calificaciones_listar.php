<script type="text/javascript" src="../js/talleres.js?rev=<?php echo time(); ?>"></script>

<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="../Plantilla/plugins/select2/select2.min.css">
<div class="col-md-12">
    <div class="box box-warning box-solid">
        <div class="box-header with-border">
            <input type="text" id="id_docente_verifity" hidden>
            <h3 class="box-title">NOVEDADES</h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
            </div>
            <!-- /.box-tools -->
        </div>
        <!-- /.box-header -->
        <div class="box-body">

            <div class="form-group">
                <!-- <div class="col-lg-6">
             <div class="col-lg-6 ">
            <div class="small-box bg-aqua">
                <div class="inner" style="height: 100px;">
                    <h3 id="txtregistro"></h3>
                    <p>Usuarios registrados</p> 
                    <div class="icon" >
                        <i class="ion ion-person-add" ></i>
                    </div>
                </div>
            </div>
        </div>  
 <div class="small-box bg-aqua">
                <div class="inner" style="height: 100px;">
                    <h3 id="txtregistro"></h3>
                    <p>Usuarios registrados</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
            </div>
        </div> -->
                <div class="col-lg-4" hidden>
                    <label for="">Asignatura</label>
                    <select class="js-example-basic-single" name="state" id="cbm_asignatura" style="width:100%;">
                    </select>
                    <br>
                    <br>
                </div>
                
                <div class="col-lg-4" hidden>
                    <label for="">Mis Grupos</label>
                    <select class="js-example-basic-single1" name="state" id="cbm_grado" style="width:100%;">
                    </select>
                    <br>
                    <br>
                </div>

                <div class="col-lg-6">
                    <label for="">Mis Grupos</label>
                    <select class="js-example-basic-single1" name="state" id="cbm_grupo" style="width:100%;">
                    </select>
                    <br>
                    <br>
                </div>

                <div class="col-lg-3">
                    <label for="">&nbsp;</label>
                    <br>
                    <button class="btn btn-primary" style="width:100%" onclick="datos()"><i class="fa fa-search"></i> Listar</button>
                </div>
                
                <div class="col-lg-3">
                    <label for="">&nbsp;</label>
                    <br>
                    <button class="btn btn-danger" style="width:100%" onclick="AbrirModalRegistro()"><i class="glyphicon glyphicon-plus"></i>&nbsp; Registrar Talleres</button>
                </div>
                
            </div>
            <br>
            <br>
            <br>
            <div class="col-lg-12 table-responsive">
                <table id="tabla_talleres" class="display responsive nowrap text-center" style="width:100% ">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Titulo</th>
                            <th>Descripci&oacute;n</th>
                            <th>Asignatura</th>
                            <th>Grupo</th>
                            <th>Archivo</th>
                            <th>Estado</th>
                            <th>Fecha Limite</th>
                            <th>Acci&oacute;n</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <th>#</th>
                        <th>Titulo</th>
                        <th>Descripci&oacute;n</th>
                        <th>Asignatura</th>
                        <th>Grupo</th>
                        <th>Archivo</th>
                        <th>Estado</th>
                        <th>Fecha Limite</th>
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
    <div class="modal fade" id="modal_registro" role="dialog">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header" style="text-align:center">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-file-text-o"></i><b>&nbsp; Registra Taller</b></h4>
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
                            <label for="">&nbsp; Fecha De Entrega</label>
                            <input type="date" class="form-control" id="fecha">
                        </div>
                        
                        <div class="col-lg-12">
                            <br>
                            <label for="">Titulo del Taller</label>
                            <br>
                            <input type="text" class="form-control" id="txt_titulo">
                        </div>
                        
                        <div class="col-lg-12">
                            <label for="">&nbsp; Descripci&oacute;n</label>
                            <br>
                            <textarea name="" id="descripcion" cols="20" rows="5" class="form-control" style="resize:none;"></textarea>
                        </div>
                        
                        <div class="col-lg-12">
                            <label for="">&nbsp;Subir Archivo</label>
                            <br>
                            <input type="file" id="txt_archivo">
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="registrar_taller()"><i class="fa fa-check"><b>&nbsp;Registrar</b></i></button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"><b>&nbsp;Cerrar</b></i></button>
                </div>
            </div>
        </div>
    </div>
</form>

<form autocomplete="false" onsubmit="return false" id="modal1">
    <div class="modal fade" id="modal_editar" role="dialog">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header" style="text-align:center">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-file-text-o"></i><b>&nbsp; Editar Taller</b></h4>
                </div>
                <input type="text" id="descripcion_editar_actual" hidden>
                <div class="modal-body">
                    <input type="text" id="id_taller">

                    <div class="row">

                        <div class="col-lg-12">
                            <label for="">&nbsp; Mis Grupos</label>
                            <select class="js-example-basic-single1" name="state" id="cbm_grupo_editar" style="width:100%;">
                            </select>
                            <br>
                            <br>
                        </div>

                        <div class="col-lg-12">
                            <br>
                            <label for="">Titulo del Taller</label>
                            <br>
                            <input type="text" class="form-control" id="txt_titulo_editar">
                        </div>
                        
                        <div class="col-lg-12">
                            <label for="">&nbsp; Descripci&oacute;n</label>
                            <br>
                            <textarea name="" id="descripcion_editar" cols="20" rows="5" class="form-control" style="resize:none;"></textarea>
                        </div>
                        
                        <div class="col-lg-12">
                            <label for="">&nbsp;Subir Archivo</label>
                            <br>
                            <input type="file" id="txt_archivo_editar">
                        </div>
                        
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="editar_taller()"><i class="fa fa-check"><b>&nbsp;Editar</b></i></button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"><b>&nbsp;Cerrar</b></i></button>
                </div>
            </div>
        </div>
    </div>
</form>

<form autocomplete="false" onsubmit="return false" id="modal1">
    <div class="modal fade" id="modal_archivos" role="dialog">
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
                                    <i class="fa fa-file"></i>
                                    <h3 class="box-title">TALLER</h3>
                                </div>

                                <div class="box-body">
                                    
                                    <blockquote>
                                        <div class="col-lg-12 text-center">
                                            <embed type="application/pdf" id="archivo" width="500px" height="300px">
                                        </div>
                                    </blockquote>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"><b>&nbsp;Cerrar</b></i></button>
                </div>
            </div>
        </div>
    </div>
</form>

<form autocomplete="false" onsubmit="return false" id="modal1">
    <div class="modal fade" id="modal_descripcion" role="dialog">
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
                                    <i class="fa fa-file"></i>
                                    <h3 class="box-title">DESCCRIPCI&Oacute;N DEL TALLER</h3>
                                </div>

                                <div class="box-body">
                                    
                                    <blockquote>
                                        <div class="col-lg-12 text-center">
                                            <textarea name="" id="txt_descripcion" cols="50" rows="10" class="form-control" style="resize:none;"></textarea>
                                        </div>
                                    </blockquote>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"><b>&nbsp;Cerrar</b></i></button>
                </div>
            </div>
        </div>
    </div>
</form>

<form autocomplete="false" onsubmit="return false" id="modal1">
    <div class="modal fade" id="modal_fecha" role="dialog">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <input type="text" id="id_talleres">
                <div class="modal-header" style="text-align:center">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><b></b></h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        
                        <div class="col-lg-12">
                            <label for="">&nbsp; Fecha De Entrega</label>
                            <input type="date" class="form-control" id="fecha_editar">
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="editar_fecha()"><i class="fa fa-check"><b>&nbsp;Editar Fecha</b></i></button>
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
     listar_talleres();
     listar_combo_asignatura();
     listar_combo_grado();
     listar_combo_grupo();
     listar_combo_grupos();
     listar_combo_verificar_docente();
     listar_combo_grupo_editar();
     datos();
     listar_combo_grupo();
     Traerfecha();

     $("#cbm_grupo").change(function(){
       var id_grupo = $("#cbm_grupo").val();
       listar_combo_grado(id_grupo);
       listar_combo_asignatura(id_grupo);
       listar_combo_estudiantes();
   });
        
   $("#cbm_grupo_editar").change(function(){
         var id_grupo = $("#cbm_grupo_editar").val();
         listar_combo_grupo_editar(id_grupo);

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
