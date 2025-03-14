<script type="text/javascript" src="../js/talleres.js?rev=<?php echo time(); ?>"></script>
<style>
/* Estilo por defecto para el PDF */
.pdf-embed {
  width: 800px;
  height: 400px;
}

/* Media query para pantallas más pequeñas, como celulares */
@media (max-width: 767px) {
  .pdf-embed {
    width: 340px;
    height: 420px;
  }
}

@media (min-width: 768px) and (max-width: 991px) {
  .pdf-embed {
    width: 380px;
    height: 450px;
  }
}

</style>
<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="../Plantilla/plugins/select2/select2.min.css">

<div class="col-md-12">
    <div class="box box-warning box-solid">
        <div class="box-header with-border">
            <input type="text" id="id_docente_verifity" >
            <input type="text" id="id_docente_verifity_es" hidden>
            <h3 class="box-title">MIS TALLERES</h3>

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

            </select><br><br>

        </div>
        <div class="col-lg-4" hidden>
            <label for="">Mis Grupos</label>
            <select class="js-example-basic-single1" name="state" id="cbm_grado" style="width:100%;">

            </select><br><br>

        </div>

        <div class="col-lg-8">
            <label for="">MATERIA</label>
            <select class="js-example-basic-single1" name="state" id="cbm_grupo" style="width:100%;">

            </select><br><br>

        </div>

        <div class="col-lg-4">
         <label for="">&nbsp;</label><br>
         <button class="btn btn-primary" style="width:100%" onclick="listar2()" ><i class="fa fa-search"></i>  Listar</button>

     </div>   
     <div class="col-lg-3" hidden>
         <label for="">&nbsp;</label><br>
         <button class="btn btn-danger" style="width:100%" onclick="cargar_contenido('contenido_principal','talleres/vista_talleres_estudiantes_comentarios_listar.php')"><i class="fa fa-commenting-o"></i>&nbsp; Ver Comentarios</button>

     </div>    

 </div><br><br><br>

 <div class="col-lg-12 table-responsive">
    <table id="tabla_talleres_estudiantes" class="display responsive nowrap text-center" style="width:100% ">
        <thead >
            <tr >
              <th>#</th>
              <th>Titulo</th>
              <th>Asignatura</th>
              <th>Grupo</th>
              <th>Taller</th>
              <th>Descripci&oacute;n</th>
              <th>Estado</th>
              <th>Fecha Limite</th>
              <th>Acci&oacute;n</th>


          </tr>
      </thead>
      <tfoot>
          <th>#</th>
          <th>Titulo</th>
          <th>Asignatura</th>
          <th>Grupo</th>
          <th>Taller</th>
          <th>Descripci&oacute;n</th>
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
    <div class="modal fade" id="modal_entrega" role="dialog">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header" style="text-align:center">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-book"></i><b>&nbsp; Entregar Taller</b></h4>
                </div>
                <div class="modal-body">
                    <div id="active_taller_content">
                        <div class="row">
                            <input type="text" id="id_taller_subir" hidden>
                            <input type="text" id="id_estudiante" hidden>
                            <input type="text" id="txt_editar_titulo" hidden>
                            <div class="col-lg-12"><br>
                                <label for="">&nbsp;Agregar una nota</label><br>
                                <textarea name="" id="txt_nota" cols="1" rows="8" class="form-control" style="resize:none;"></textarea>
                            </div>
                            <div class="col-lg-12"><br>
                                <label for="">&nbsp;Subir Archivo</label><br>
                                <input type="file" id="txt_archivo_subir"><br><br>
                            </div>
                        </div>
                    </div>
                    <div id="inactive_taller_message" style="display:none; text-align:center;">
                        <h4><b>TALLER INACTIVO</b></h4>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="entregar_button" onclick="entrega_taller()"><i class="fa fa-check"><b>&nbsp;Entregar</b></i></button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"><b>&nbsp;Cerrar</b></i></button> 
                </div>
            </div>
        </div>
    </div>
</form>



<form autocomplete="false" onsubmit="return false" id="modal1">
    <div class="modal fade" id="modal_descripcion" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="text-align:center">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-file-text-o"></i><b>&nbsp;Taller</b></h4>
                </div>

                <div class="modal-body">
                 <div class="row">
                  

                        <div class="box-body" hidden>
                          
                                <div class="col-lg-12 text-center">

                                    <textarea name="" id="txt_descripcion" cols="50" rows="10" class="form-control" style="resize:none;"></textarea>
                                </div>


                          
                        </div>

                    </div>
                    <div class="box box-warning">
                                        <div class="box-header with-border">
                                            <div class="user-block">
                                                <img id="foto" class="img-circle" src=""
                                                    alt="User Image">
                                                <span class="username"><a href="#" id="txtdocente">nombre</a></span>
                                                <span class="description" >Fecha Limite: <span id="txtfecha">_____</span></span>

                                            </div>
                                        </div>
                                       
                                        <div class="box-header with-border">
                                            <h3 class="box-title" id="lbl_titulo">TITULO</h3>
                                        </div>
                                        <div class="box-header with-border">
                                            <p id="lbl_descripcion">Descripción</p>
                                        </div>
                                        <div class="box-header with-border">
                                        <h4 class="text-center">Material de Apoyo</h4>
                                        <div class="box-body">
                                 
                           <div class="col-lg-12 text-center">
                           <embed class="pdf-embed" type="application/pdf" id="text_archivo">
                               </div>


                        
                       </div>
                                            <span class="pull-right text-muted" id="txt_materia" style="display: none;">materia</span>
                                            <br>
                                            <span class="pull-right text-muted" id="txtgrado" style="display: none;">grado</span>
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
    <div class="modal fade" id="modal_archivos_abrir" role="dialog">
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
                          
                                <div class="col-lg-12 text-center">


                                    <embed class="pdf-embed" type="application/pdf" id="text_archivo">
                                    </div>


                             
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
    <div class="modal fade" id="modal_comentario" role="dialog">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
               <input type="text" id="idtalleres">
               <div class="modal-header" style="text-align:center">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><i class="fa fa-commenting-o"></i><b>&nbsp; Hacer un comentario</b></h4>
            </div>

            <div class="modal-body">
             <div class="row">
                 <div class="col-lg-12">
                    <label for="">&nbsp;Nombre del taller</label>
                    <input type="text"  class="form-control"  id="txt_titulo_editar" disabled >

                </div> 
                <div class="col-lg-12"><br>
                   <label for="">&nbsp;Comentario</label><br>
                   <textarea name="" id="txt_comentario" cols="1" rows="8" class="form-control" style="resize:none;"></textarea>
               </div>


           </div>

       </div>
       <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="registrar_comentario()"><i class="fa fa-commenting-o"><b>&nbsp;Registrar comentarios</b></i></button>
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
     listar_talleres_estudiantes();

     listar_combo_materia();
     listar_combo_materias();

     listar_combo_verificar_estudiante();
     listar_combo_verificar_docentes();



     listar_comentarios_estudiantes(); 


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
