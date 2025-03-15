<script type="text/javascript" src="../js/registro_clases.js?rev=<?php echo time(); ?>"></script>

<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="../Plantilla/plugins/select2/select2.min.css">
<div class="col-md-12">
    <div class="box box-warning box-solid">
        <div class="box-header with-border">
            <input type="text" id="id_estudiante_verifity">
            <input type="text" id="id_docente_verifity">
            <h3 class="box-title">VIDEOCONFERENCIAS</h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
            </div>
            <!-- /.box-tools -->
        </div>
        <!-- /.box-header -->
        <div class="box-body">

            <div class="form-group">



                <div class="col-lg-6">
                    <label for="">Mis Grupos</label>
                    <select class="js-example-basic-single1" name="state" id="cbm_grupo" style="width:100%;">

                    </select><br><br>

                </div>

                <div class="col-lg-3">
                 <label for="">&nbsp;</label><br>
                 <button class="btn btn-primary" style="width:100%" onclick="listar_datos()" ><i class="fa fa-search"></i>  Listar</button>

             </div>   

             <div class="col-lg-3">
            <label for="">&nbsp;</label><br>
            <button class="btn btn-success" style="width:100%"  onclick="window.open('video_conferencia/conferenciasingreso.php', '_blank');"><i class="fa fa-commenting-o"></i>&nbsp;  Iniciar video llamada</button>
       </div> 



         </div><br><br><br>
         <div class="col-lg-12 table-responsive ">
             <table id="tabla_videoconferencia_clases" class=" display  nowrap text-center" style="width:100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Fecha</th>
                        <th>Links</th>
                        <th>Docente</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                      <th>#</th>
                      <th>Fecha</th>
                      <th>Links</th>
                      <th>Docente</th>
                      <th>Estado</th>
                  </tr>
              </tfoot>
          </table>
      </div>
      <!-- /.box-body -->
  </div>
  <!-- /.box -->
</div>
</div>






<script src="../Plantilla/plugins/select2/select2.min.js"></script>
<script>
    $(document).ready(function() {

     $('.js-example-basic-single1').select2();
     listar_combo_verificar_docentes();
     listar_combo_verificar_estudiante();
     listar_combo_materia();
     listar_videoconferencia_clases();
     listar();





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
