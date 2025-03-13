<script type="text/javascript" src="../js/talleres.js?rev=<?php echo time(); ?>"></script>

<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="../Plantilla/plugins/select2/select2.min.css">

<div class="col-md-12">
    <div class="box box-warning box-solid">
        <div class="box-header with-border">
            <input type="text" id="id_docente_verifity" >
            <h3 class="box-title">COMENTARIOS DOCENTE</h3>

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
        <div class="col-lg-6">
            <label for="">Mis Grupos</label>
            <select class="js-example-basic-single1" name="state" id="cbm_grupo" style="width:100%;">

            </select><br><br>

        </div>

                    <div class="col-lg-3">
                       <label for="">&nbsp;</label><br>
                       <button class="btn btn-primary" style="width:100%" onclick="listar()" ><i class="fa fa-search"></i>  Listar</button>

                   </div>    
                   <div class="col-lg-3">
         <label for="">&nbsp;</label><br>
         <button class="btn btn-success" style="width:100%" onclick="cargar_contenido('contenido_principal','talleres/vista_talleres_docentes_comentarios_listar_asunto.php')" ><i class="fa fa-commenting-o"></i>&nbsp;Otros comentarios</button>

     </div>   

   </div><br><br><br>
   
   <div class="col-lg-12 table-responsive">
      <table id="tabla_comentarios_docentes" class="display responsive nowrap text-center" style="width:100% ">
                        <thead >
                            <tr >
                              <th>#</th>
                              <th>Taller</th>
                              <th>Estudiante</th>
                              <th>Estado</th>
                              <th>Fecha</th>
                              <th>Acci&oacute;n</th>


                          </tr>
                      </thead>
                      <tfoot>
                        <th>#</th>
                        <th>Taller</th>
                        <th>Estudiante</th>
                        <th>Estado</th>
                        <th>Fecha</th>
                        <th>Acci&oacute;n</th>      
                    </tfoot>
                </table> <br><br>
</div>
<!-- /.box-body -->
</div>
<!-- /.box -->
</div>
 

<form autocomplete="false" onsubmit="return false">
    <div class="modal fade" id="modal_registro" role="dialog">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
               <h4 class="modal-title"><i class="fa fa-commenting-o"></i><b>&nbsp; Comentarios</b></h4>
                </div>
                <div class="modal-body"  >
                    <div class="row ">
                        <div class="col-lg-12">
                        <label for="">&nbsp;Comentario</label><br>
                        <textarea name="" id="txt_ver" cols="50" rows="10" class="form-control" style="resize:none;"></textarea><br><br>


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




<form autocomplete="false" onsubmit="return false">
    <div class="modal fade" id="modal_editar" role="dialog">
        <div class="modal-dialog modal-md">
            <div class="modal-content ">
                <div class="modal-header text-center">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                   <h4 class="modal-title"><i class="fa fa-commenting-o"></i><b>&nbsp; Respuesta</b></h4>
                </div>
                <div class="modal-body">
                  <div class="col-lg-12">
                        <label for="">&nbsp;Respuesta</label><br>
                        <textarea name="" id="txt_ver_resp" cols="50" rows="10" class="form-control" style="resize:none;"></textarea><br><br>


                  </div>

                </div>
                <div class="modal-footer">
               
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"><b>&nbsp;Cerrar</b></i></button>
                </div>
            </div>
        </div>
    </div>
</form>
 

<form autocomplete="false" onsubmit="return false">
    <div class="modal fade" id="modal_responder" role="dialog">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
               <h4 class="modal-title"><i class="fa fa-commenting-o"></i><b>&nbsp; Responder</b></h4>
                </div>
            
                        <input type="text" id="id_coemntario">
                        <input type="text" id="id_grupo">
                       
                     

 <div class="box box-success direct-chat direct-chat-success">
<div class="box-header with-border">
<h3 class="box-title" id="lbl_titulo">TALLER</h3>
<div class="box-tools pull-right">

</div>
</div>

<div class="box-body">

<div class="direct-chat-messages">
<div class="direct-chat-msg">
<div class="direct-chat-info clearfix">
<span class="direct-chat-name pull-left" id="lbl_estudiante">estudiante</span>
<span class="direct-chat-timestamp pull-right">Comentario de estudiante</span>
</div>
<img id="imagenestudiante" class="direct-chat-img" src="" alt="Message User Image">
<div class="direct-chat-text" id="lbl_ver">comentario</div>

</div>


<div class="direct-chat-msg right">
<div class="direct-chat-info clearfix">
<span class="direct-chat-name pull-right"id="lbl_docente">docente</span>
<span class="direct-chat-timestamp pull-left">Tu respuesta</span>
</div>
<img id="imagendocente" class="direct-chat-img" src="" alt="Message User Image">
<div class="direct-chat-text" id="lbl_resp">respuesta</div>

</div>


        
                   </div>

                   <div class="col-lg-12">
                        <label for="">&nbsp;Respuesta</label><br>
                        <textarea name="" id="txt_enviar_resp" cols="1" rows="3" class="form-control" style="resize:none;"></textarea><br><br>
                    </div>

               <div class="modal-footer">
                <button class="btn btn-primary" onclick="responder()"><i class="fa fa-check"><b>&nbsp;Responder</b></i></button>
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
  

      
       listar_combo_grupo();

     
       listar_combo_verificar_docentes(); 

       listar_comentarios_docentes(); 


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









