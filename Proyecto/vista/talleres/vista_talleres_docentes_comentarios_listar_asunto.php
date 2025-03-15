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
                
                <div class="col-lg-12">
                    <div class="input-group">
                        <input type="text" class="global_filter form-control" id="global_filter" placeholder="Ingresar dato a buscar">
                        <span class="input-group-addon"><i class="fa fa-search"></i></span>
                    </div>
                </div>
                
            </div>
            <br>
            <br>

            <div class="col-lg-12 table-responsive">
                <table id="tabla_comentarios_estudiantes" class="display responsive nowrap text-center" style="width:100% ">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Asunto</th>
                            <th>Estudiante</th>
                            <th>Estado</th>
                            <th>Fecha</th>
                            <th>Acci&oacute;n</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <th>#</th>
                        <th>Asunto</th>
                        <th>Estudiante</th>
                        <th>Estado</th>
                        <th>Fecha</th>
                        <th>Acci&oacute;n</th>
                    </tfoot>
                </table>
                <br>
                <br>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
</div>

<form autocomplete="false" onsubmit="return false">
    <div class="modal fade" id="modal_responder" role="dialog">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-commenting-o"></i><b>&nbsp; Responder</b></h4>
                </div>

                <input type="text" id="id_coemntario">

                <div class="box box-success direct-chat direct-chat-success">
                    <div class="box-header with-border">
                        <h3 class="box-title" id="lbl_titulo">ASUNTO</h3>
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
                                    <span class="direct-chat-name pull-right" id="lbl_docente">docente</span>
                                    <span class="direct-chat-timestamp pull-left">Tu respuesta</span>
                                </div>
                                <img id="imagendocente" class="direct-chat-img" src="" alt="Message User Image">
                                <div class="direct-chat-text" id="lbl_resp">respuesta</div>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <label for="">&nbsp;Respuesta</label>
                            <br>
                            <textarea name="" id="txt_enviar_resp" cols="1" rows="3" class="form-control" style="resize:none;"></textarea>
                            <br>
                            <br>
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
       listar_comentarios_docentes() ; 
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
