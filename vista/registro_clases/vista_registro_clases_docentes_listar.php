<script type="text/javascript" src="../js/registro_clases.js?rev=<?php echo time(); ?>"></script>

<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="../Plantilla/plugins/select2/select2.min.css">
<div class="col-md-12">
    <div class="box box-warning box-solid">
        <div class="box-header with-border">
            <input type="text" id="id_docente_verifity"hidden>
            <h3 class="box-title">REGISTRO DE CLASES</h3>

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
                <select class="js-example-basic-single1" name="state" id="cbm_grado" style="width:100%;">

                </select><br><br>

            </div>

            <div class="col-lg-6">
                <label for="">Mis Grupos</label>
                <select class="js-example-basic-single1" name="state" id="cbm_grupo" style="width:100%;">

                </select><br><br>

            </div>

            <div class="col-lg-3">
             <label for="">&nbsp;</label><br>
             <button class="btn btn-primary" style="width:100%" onclick="datos()" ><i class="fa fa-search"></i>  Listar</button>

         </div>   
         
         <div class="col-lg-3">
             <label for="">&nbsp;</label><br>
             <button class="btn btn-danger" style="width:100%" onclick="AbrirModalRegistro()"><i class="glyphicon glyphicon-plus"></i>&nbsp; Registrar Clases</button>

         </div>    



     </div><br><br><br>
  
     <div class="col-lg-12 table-responsive ">
         <table id="tabla_clases" class=" display  nowrap text-center" style="width:100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Fecha</th>
                    <th>Titulo</th>
                    <th>Registro de clase</th>
                    <th>Docente</th>
                    <th>Materia</th>
                    <th>Grado</th>
                    <th>Acci&oacute;n</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                  <th>#</th>
                  <th>Fecha</th>
                  <th>Titulo</th>
                  <th>Dregistro de clase</th>
                  <th>Docente</th>
                  <th>Materia</th>
                  <th>Grado</th>
                  <th>Acci&oacute;n</th>
              </tr>
          </tfoot>
      </table>
  </div>
  <!-- /.box-body -->
</div>
<!-- /.box -->
</div>

<div class="box box-widget" hidden>
  <div class="box-header with-border">
    <div class="user-block">
      <img class="img-circle" src="../dist/img/user1-128x128.jpg" alt="User Image">
      <span class="username"><a href="#">nombre</a></span>
      <span class="description">fecha</span>
    </div>
  </div>
  <div class="box-header with-border">
    <div class="container">
      <div class="row justify-content-center"> <!-- Añade la clase row y justify-content-center para centrar en Bootstrap -->
        <div class="col-md-12"> <!-- Define el ancho del contenedor -->
          <img class="img-responsive pad" src="../vista/registro_clases/Horarios_page-0012.jpg" alt="Photo">
        </div>
      </div>
    </div>
    <span class="pull-right text-muted">materia</span>
    <br>
    <span class="pull-right text-muted">grado</span>
  </div>
  <div class="box-header with-border">
    <h3 class="box-title" id="txttitulo">TITULO</h3>
  </div>
  <div class="box-header with-border">
    <p id="txtdescripcion">Descripción</p>
  </div>
</div>




<!-- modar para editar usuarios -->
<form autocomplete="false" onsubmit="return false" id="modal1">
    <div class="modal fade" id="modal_registro" role="dialog">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header" style="text-align:center">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-film"></i><b>&nbsp; Registrar clases</b></h4>
                </div>

                <div class="modal-body">
                   <div class="row">
                    <div class="col-lg-12">
                        <label for="">&nbsp; Fecha De registro</label>
                        <input type="date"  class="form-control"  id="fecha" ><br>


                    </div>
                    <div class="col-lg-12">
                        <label for="">&nbsp; Mis Grupos</label>
                        <select class="js-example-basic-single" name="state" id="cbm_grupos" style="width:100%;">

                        </select><br><br>

                    </div>

                    
                    <div class="col-lg-12">
                        <label for="">Titulo de la clase</label><br>
                        <input type="text" class="form-control" id="txt_titulo">

                    </div>
                    <div class="col-lg-12">

                        <label for="">&nbsp; Descripci&oacute;n</label><br>
                        <textarea name="" id="descripcion" cols="20" rows="5" class="form-control" style="resize:none;"></textarea><br>
                    </div>
                    <div class="col-lg-12">
                      <label for="">&nbsp;Cargar Video (Min 600MB)</label><br>
                      <input type="file" id="txt_video">
                      <br>
            <!-- Barra de Progreso -->
            <div class="progress">
                <div id="progress_bar" class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
            </div>
              </div>
          </div>

          </div>
          <div class="modal-footer">  
            <button type="button" class="btn btn-primary" onclick="Registrar_Clases()"><i class="fa fa-check"><b>&nbsp;Registrar</b></i></button>
            <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"><b>&nbsp;Cerrar</b></i></button>

        </div>
    </div>
</div>
</div>
</form>

<!-- modar para editar usuarios -->
<form autocomplete="false" onsubmit="return false" id="modal1">
    <div class="modal fade" id="modal_editar_clases" role="dialog">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header" style="text-align:center">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-film"></i><b>&nbsp; Editar Registro De Clases</b></h4>
                </div>
                <input type="text"  id="descripcion_editar_actual" hidden>
                <div class="modal-body">
                    <input type="text" id="id_clases" style="display: none;">
                    

                    <div class="row">
                        <input type="text" id="id_video"style="display: none;">
                        <div class="col-lg-12">
                            <label for="">&nbsp; Mis Grupos</label>
                            <select class="js-example-basic-single1" name="state" id="cbm_grupo_editar" style="width:100%;">

                            </select><br><br>

                        </div>


                        <div class="col-lg-12"><br>
                            <label for="">Titulo del Taller</label><br>
                            <input type="text" class="form-control" id="txt_titulo_editar">

                        </div>
                        <div class="col-lg-12">

                            <label for="">&nbsp; Descripci&oacute;n</label><br>
                            <textarea name="" id="descripcion_editar" cols="20" rows="5" class="form-control" style="resize:none;"></textarea>
                        </div>
                        <div class="col-lg-12">
                          <label for="">&nbsp;Subir Archivo</label><br>
                          <input type="file" id="txt_video_editar" >
                      </div>


                  </div>
              </div>
              <div class="modal-footer">  
                <button type="button" class="btn btn-primary" onclick="editar_clases()"><i class="fa fa-check"><b>&nbsp;Editar</b></i></button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"><b>&nbsp;Cerrar</b></i></button>

            </div>
        </div>
    </div>
</div>
</form>
<form autocomplete="false" onsubmit="return false" id="modal1">
    <div class="modal fade" id="modal_ver_des" role="dialog" >
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="text-align:center">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-film"></i><b>&nbsp; Registro de clase</b></h4>
                </div>

                <div class="modal-body">
                 <div class="row">        

                        <div class="box-body" hidden>
                                <div class="col-lg-12 text-center">
                                  <textarea name="" id="descripcion_ver" cols="20" rows="5" class="form-control" style="resize:none;"></textarea>              
                            </div>
                        </div>

                                <div class="box-body">
                                    <div class="box box-danger">
                                        <div class="box-header with-border">
                                            <div class="user-block">
                                                <img id="foto" class="img-circle" src=" "
                                                    alt="User Image">
                                                <span class="username"><a href="#" id="txtdocente">nombre</a></span>
                                                <span class="description" id="txtfecha">fecha</span>
                                            </div>
                                        </div>
                                        <div class="box-header with-border">
                                            <div class="container">
                                                <div
                                                    class="row justify-content-center"> <!-- Añade la clase row y justify-content-center para centrar en Bootstrap -->
                                                    <div class="col-lg-9">  <!-- Define el ancho del contenedor -->
                                                        <div id="videoContainer"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <span class="pull-right text-muted" id="txt_materia">materia</span>
                                            <br>
                                            <span class="pull-right text-muted" id="txtgrado">grado</span>
                                        </div>
                                        <div class="box-header with-border">
                                            <h3 class="box-title" id="lbl_titulo">TITULO</h3>
                                        </div>
                                        <div class="box-header with-border">
                                            <p id="lbl_descripcion">Descripción</p>
                                        </div>
                                    </div>
                                </div>
                
                        
            
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"><b>&nbsp;Cerrar</b></i></button>
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
                    <input type="date"  class="form-control"  id="fecha_editar" >


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
        listar_registro_de_clases();
     $('.js-example-basic-single1').select2();
    
    
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
       listar_combo_asignatura();
       listar_combo_estudiantes();

   });
     $("#cbm_grupo_editar").change(function(){
         var id_grupo = $("#cbm_grupo_editar").val();
  

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
