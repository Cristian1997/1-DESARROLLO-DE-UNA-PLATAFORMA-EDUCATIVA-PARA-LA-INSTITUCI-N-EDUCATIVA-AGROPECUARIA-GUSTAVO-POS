<script type="text/javascript" src="../js/trabajos.js?rev=<?php echo time(); ?>"></script>
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
            <input type="text" id="id_docente_verifity"hidden>

            <h3 class="box-title">TRABAJOS ENTREGADOS</h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
            </div>
            <!-- /.box-tools -->
        </div> 
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

     
        <div class="col-lg-8" hidden><br>
          
            <select class="js-example-basic-single1" name="state" id="cbm_taller" style="width:100%;">

            </select><br><br>

        </div>    <div class="col-lg-8"><br>
            <label for="">Mis Grupos</label>
            <select class="js-example-basic-single1" name="state" id="cbm_grupos" style="width:100%;">

            </select><br><br>

        </div>

        <div class="col-lg-4"><br>
         <label for="">&nbsp;</label><br>
         <button class="btn btn-primary" style="width:100%" onclick="buscar()" ><i class="fa fa-search"></i>  Listar</button>

     </div>   


 </div><br><br><br>

 <div class="col-lg-12 table-responsive">
    <table id="tabla_trabajos_entregar" class="display responsive nowrap text-center" style="width:100% ">
        <thead >
            <tr >
              <th>#</th>
              <th>Estudiante</th>
              <th>Titulo</th>
              <th>Trabajo</th>
              <th>Fecha de Entrega</th>
            


          </tr>
      </thead>
      <tfoot>
          <th>#</th>
          <th>Estudiante</th>
          <th>Titulo</th>
          <th>Trabajo</th>
          <th>Fecha de Entrega</th>
        
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
                            <h3 class="box-title">Registrar calificaciones</h3>
                        </div>
                        <div class="box-body">
                            <div class="col-lg-12">
                                <input type="text" id="id_calificaciones">
                                <input type="text" id="txt_def_editar">
                                <label for="">&nbsp;Primera Nota</label><br>
                                <input type="text " class="form-control" id="txt_nota1_editar">
                            </div> 
                            <div class="col-lg-12">
                               <label for="">&nbsp;Segunda Nota</label><br>
                               <input type="text" class="form-control" id="txt_nota2_editar">
                           </div> 

                           <div class="col-lg-12">
                               <label for="">&nbsp;Tercera Nota</label><br>
                               <input type="text" class="form-control" id="txt_nota3_editar">
                           </div>
                           <div class="col-lg-12">
                               <label for="">&nbsp;Cuarta Nota</label><br>
                               <input type="text" class="form-control" id="txt_nota4_editar">
                           </div>
                       </div>
                   </div>
               </div>
           </div>
       </div>
       <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"><b>&nbsp;Cerrar</b></i></button> 
        <button type="button" class="btn btn-primary" onclick="Registrar_calificaciones()"><i class="fa fa-edit" ><b>&nbsp;Registrar Nota!</b></i></button>
    </div>
</div>
</div>
</div>
</form>


<form autocomplete="false" onsubmit="return false" id="modal1">
    <div class="modal fade" id="modal_archivos" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="text-align:center">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-book"></i><b>&nbsp; Taller Entregado</b></h4>
                </div>
                <div class="modal-body">
                 <div class="row">
                  <div class="col-md-12">
                    <div class="box box-solid">
                       
                     
                        <div class="box box-warning">
                                        <div class="box-header with-border">
                                            <div class="user-block">
                                                <img id="foto" class="img-circle" src=""
                                                    alt="User Image">
                                                <span class="username"><a href="#" id="txtdocente">nombre</a></span>
                                                <span class="description" >Fecha De entrega: <span id="txtfecha">_____</span></span>

                                            </div>
                                        </div>
                                        <div class="box-header with-border">
                                        <h4 class="text-center">Taller</h4>
                                        <div class="box-body">
                                 
                           <div class="col-lg-12 text-center">
                           <embed class="pdf-embed" type="application/pdf" id="txt_archivo">
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
                                            <p id="lbl_descripcion">Nota</p>
                                        </div>
                                    </div>
                                </div>
                                <input type="text" id="txt_id_taller_ob" hidden>
                    <div class="box box-warning">
                    <div class="box-header with-border">
                      <h3 class="box-title">Observación</h3>
                      </div>
                        <div class="box-header with-border">
                          <p id="lbl_nota_docente">Nota</p>
                        </div>
                            </div>
                              
            <div class="modal-footer">
            <textarea name="" id="txt_nota" cols="10" rows="5" class="form-control" style="resize:none;"></textarea><br>

            <button type="button" class="btn btn-success" id="btnregistarnota" onclick="registrar_nota()"> <i class="fa fa-plus">&nbsp;Agregar Observación</i></button>

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
                            <blockquote >
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

     $('.js-example-basic-single1').select2();

     listar_combo_verificar_docentes();  
     listar_combo_verificar_taller();  
     listar_combo_grupo();

     $("#cbm_grupos").change(function(){
         var id_grupo = $("#cbm_grupos").val();
         listar_combo_verificar_taller(id_grupo);

     }); 

     listar_trabajos_estudiantes();
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
