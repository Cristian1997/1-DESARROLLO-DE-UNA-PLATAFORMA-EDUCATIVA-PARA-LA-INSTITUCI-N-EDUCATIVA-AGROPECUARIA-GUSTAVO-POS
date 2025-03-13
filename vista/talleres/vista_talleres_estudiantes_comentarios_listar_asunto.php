<script type="text/javascript" src="../js/asuntos.js?rev=<?php echo time(); ?>"></script>

<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="../Plantilla/plugins/select2/select2.min.css">

<div class="col-md-12">
    <div class="box box-warning box-solid">
        <div class="box-header with-border">

            <h3 class="box-title">OTROS COMENTARIOS Y ASUNTOS</h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
            </div>
            <!-- /.box-tools -->
        </div>
        <!-- /.box-header -->
        <div class="box-body">

        <div class="form-group ">
    <div class="col-lg-8">
        <div class="input-group">
            <input type="text" class="global_filter form-control" id="global_filter" placeholder="Ingresar dato a buscar">
            <span class="input-group-addon"><i class="fa fa-search"></i></span>
        </div>
    </div>
    <div class="col-lg-4">
        <button class="btn btn-success btn-block" onclick="comentario_nuevo()"><i class="fa fa-commenting-o"></i> Nuevo comentario</button>
    </div>

   </div><br><br>

   <div class="col-lg-12 table-responsive">
      <table id="tabla_comentarios_estudiantes" class="display responsive nowrap text-center" style="width:100% ">
                        <thead >
                            <tr >
                              <th>#</th>
                              <th>Asunto</th>
                              <th>Docente</th>
                              <th>Estado</th>
                              <th>Fecha</th>
                              <th>Acci&oacute;n</th>


                          </tr>
                      </thead>
                      <tfoot>
                        <th>#</th>
                        <th>Asunto</th>
                        <th>Docente</th>
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
</div>


<form autocomplete="false" onsubmit="return false" id="modal1">
    <div class="modal fade" id="modal_comentario_nuevo" role="dialog">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
              
               <div class="modal-header" style="text-align:center">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><i class="fa fa-commenting-o"></i><b>&nbsp; Hacer un comentario</b></h4>
            </div>

            <div class="modal-body">
             <div class="row">

             <div class="col-lg-12">
  <label for="">Docentes</label>
  <select class="js-example-basic-single form-control" name="state" id="cbm_docente">
    <!-- Tus opciones aquí -->
  </select>
</div><br><br><br><br>
                 <div class="col-lg-12">
                    <label for="">&nbsp;Asunto</label>
                    <input type="text"  class="form-control"  id="txt_titulo_nuevo">

                </div> 
                <div class="col-lg-12"><br>
                   <label for="">&nbsp;Comentario</label><br>
                   <textarea name="" id="txt_comentario_nuevo" cols="1" rows="8" class="form-control" style="resize:none;"></textarea>
               </div>


           </div>

       </div>
       <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="registrar_comentario_nuevo()"><i class="fa fa-commenting-o"><b>&nbsp;Registrar comentario</b></i></button>
        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"><b>&nbsp;Cerrar</b></i></button>
    </div>
</div>
</div>
</div>
</form>

<form autocomplete="false" onsubmit="return false" id="modal1">
    <div class="modal fade" id="modal_comentario2" role="dialog">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
              
               <div class="modal-header" style="text-align:center">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><i class="fa fa-commenting-o"></i><b>&nbsp; Hacer un comentario</b></h4>
            </div>

   <input type="text" id="txt_id_comentario">

     
       <div class="box box-success direct-chat direct-chat-success">
<div class="box-header with-border">
<h3 class="box-title" id="lbl_titulo">ASUNTO</h3>
<div class="box-tools pull-right">

</div>
</div>

<div class="box-body">

<div class="direct-chat-messages">
    
<div class="direct-chat-msg right">
<div class="direct-chat-info clearfix">
<span class="direct-chat-name pull-right" id="lbl_estudiante">estudiante</span>
<span class="direct-chat-timestamp pull-left">Tu comentario</span>
</div>
<img id="imagenestudiante" class="direct-chat-img" src="" alt="Message User Image">
<div class="direct-chat-text" id="lbl_ver">comentario</div>

</div>


<div class="direct-chat-msg ">
<div class="direct-chat-info clearfix">
<span class="direct-chat-name pull-left"id="lbl_docente_es">docente</span>
<span class="direct-chat-timestamp pull-right">Respuesta del docente</span>
</div>
<img id="imagendocente" class="direct-chat-img" src="" alt="Message User Image">
<div class="direct-chat-text" id="lbl_resp">respuesta</div>
</div>


        
                   </div>

                   <div class="col-lg-12">
                        <label for="">&nbsp;Comentario</label><br>
                        <textarea name="" id="txt_comentario2" cols="1" rows="3" class="form-control" style="resize:none;"></textarea><br><br>
                    </div>


       <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="responder2()"><i class="fa fa-commenting-o"><b>&nbsp;Registrar comentario</b></i></button>
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
     
       listar_comentarios_estudiantes(); 
  
       listar_combo_docentes();
     


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
