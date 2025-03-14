<script type="text/javascript" src="../js/foro.js?rev=<?php echo time(); ?>"></script>
<style>
  /* Estilos para la tabla en modo celular */
  @media only screen and (max-width: 768px) {
    /* Ajustar el ancho de la tabla y permitir scroll horizontal */
    #tabla_foro {
      width: 100%;
      overflow-x: auto;
    }

    /* Estilos para las celdas de encabezado */
    #tabla_foro th {
      display: table-cell !important;
      width: auto !important;
      white-space: nowrap !important;
    }

    /* Estilos para las celdas de datos */
    #tabla_foro td {
      display: table-cell !important;
      width: auto !important;
      white-space: nowrap !important;
    }

    /* Estilos para los botones en las celdas */
    #tabla_foro .btn {
      visibility: visible !important;
      position: static !important;
    }
  }
</style>






<div class="col-md-12">
    <div class="box box-warning box-solid">
        <div class="box-header with-border">
          <h3 class="box-title">FORO DE PARTICIPACIÓN</h3>
          
          <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
            </div>
          <!-- /.box-tools -->
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <div class="form-group">
        
       
  <!-- /.foros -->

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
    <select class="js-example-basic-single1" name="state" id="cbm_grupo" style="width:100%;"></select><br><br>
  </div>
  <div class="col-lg-3">
    <label for="">&nbsp;</label><br>
    <button class="btn btn-primary" style="width:100%" onclick="datos()"><i class="fa fa-search"></i> Listar</button>
  </div>
  <div class="col-lg-3">
    <label for="">&nbsp;</label><br>
    <button class="btn btn-danger" style="width:100%" onclick="AbrirModalRegistro()"><i class="glyphicon glyphicon-plus"></i>&nbsp; Registrar Foro</button>
  </div>
  <br><br><br>
  <div class="col-lg-12 table-responsive">
    <table id="tabla_foro" class="display responsive nowrap text-center" style="width:100%">
      <thead>
        <tr>
          <th>#</th>
          <th>Tema</th>
          <th>Estado</th>
          <th>Fecha Limite</th>
          <th>Acción</th>
        </tr>
      </thead>
      <tfoot>
        <th>#</th>
        <th>tema</th>
        <th>Estado</th>
        <th>Fecha Limite</th>
        <th>Acción</th>
      </tfoot>
    </table>
    </div>
  

<!-- /.box-body -->
</div>



<!-- /.box -->
</div>
</div>


 <!-- foro -->

 
 <input type="hidde"  id="txtidgrupo" hidden>
  <input type="hidde"  id="txtidforo" hidden>
  <input type="text" id="id_docente_verifity" hidden>


  <div id="foro" style="display: none;">
    <!-- Contenido del foro -->
    <div class="box box-warning">
    <div class="box-tools pull-right">
    
    </div>
   
    <div class="box-header with-border">
<div class="user-block">
<img id="imagenUsuario" class="img-circle" src="" alt="User Image">
<span class="username"><a href="#" id="txtnombre">nombre</a></span>
<span class="description" id="txtfechaforo">fecha</span>
</div>

<div class="box-tools">

<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
</button>
</div>

</div>

  <div class="box-header with-border">
    <h3 class="box-title" id="txttitulo">TITULO</h3>
   

</div>


  <div class="box-header with-border">
    <p id="txtdescripcion">Descripción</p>
  </div>
  

<div class="box-body">
    <span class="pull-right text-muted">Comentarios: <span id="txt_contador"></span></span>


    <div id="comentarios_foro"></div>

<div id="comentario_foro_area">
<input type="hidde"  id="txt_id_comentario_editar" hidden>
    <textarea name="" id="txt_comentario" cols="10" rows="5" class="form-control" style="resize:none;"></textarea><br>
  
  
    <div class="input-group-btn">
        <button type="button" class="btn btn-success" id="btnregistar" onclick="registrar_comentario_foro()">Agregar Comentario  <i class="fa fa-plus"></i></button>
    </div>

 
    <button type="button" class="btn btn-success" id="btnEditar" onclick="editar_comentario_foro()">Editar comentario  <i class="fa fa-pencil"></i></button>
    <button type="button" class="btn btn-danger cancelar_editar_comentario_foro" id="btnCancelarEditar"><i class="fa fa-close"><b>&nbsp;Cancelar</b></i></button>

</div>

  <!-- foro -->

  
</div>
</div>

</div>
</div>
  



<!-- modalregistrar -->

<form autocomplete="false" onsubmit="return false" id="modal1">
    <div class="modal fade" id="modal_registro" role="dialog">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header" style="text-align:center">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-comments"></i><b>&nbsp; Registrar Foro</b></h4>
                </div>
             
                <div class="modal-body">
                    

                    <div class="row">

                        <div class="col-lg-12">
                            <label for="">&nbsp; Mis Grupos</label>
                            <select class="js-example-basic-single1" name="state" id="cbm_grupos" style="width:100%;">

                            </select><br><br>
                        </div>

                        <div class="col-lg-12">
                        <label for="">&nbsp;Fecha limite</label>
                        <input type="date"  class="form-control"  id="fecha" >


                    </div>
                        
                        <div class="col-lg-12"><br>
                            <label for="">&nbsp;Tema del foro</label><br>
                            <input type="text" class="form-control" id="titulo_foro">

                        </div>
                        
                        <div class="col-lg-12">

                            <label for="">&nbsp;Descripci&oacute;n</label><br>
                            <textarea name="" id="descripcion_foro" cols="20" rows="5" class="form-control" style="resize:none;"></textarea>
                        </div>
                        


                  </div>
              </div>
              <div class="modal-footer">  
                <button type="button" class="btn btn-primary" onclick="registrar_foro()"><i class="fa fa-check"><b>&nbsp;Registrar</b></i></button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"><b>&nbsp;Cerrar</b></i></button>

            </div>
        </div>
    </div>
</div>
</form>

<!-- modalregistrar -->




<!-- modaleditar -->

<form autocomplete="false" onsubmit="return false" id="modal1">
    <div class="modal fade" id="modal_editar" role="dialog">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header" style="text-align:center">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-comments"></i><b>&nbsp; Editar Foro</b></h4>
                </div>
          <input type="text"  id="id_foro" hidden>
            
                <div class="modal-body">
             
              

                    <div class="row">

                        <div class="col-lg-12">
                            <label for="">&nbsp; Mis Grupos</label>
                            <select class="js-example-basic-single1" name="state" id="cbm_grupo_editar" style="width:100%;">

                            </select>
                        </div>

                        
                        <div class="col-lg-12"><br>
                            <label for="">&nbsp;Tema del foro</label><br>
                            <input type="text" class="form-control" id="titulo_foro_editar">

                        </div>
                     
                        <div class="col-lg-12">

                            <label for="">&nbsp;Descripci&oacute;n</label><br>
                            <textarea name="" id="descripcion_foro_editar" cols="20" rows="8" class="form-control" style="resize:none;"></textarea>
                        </div>
                        


                  </div>
              </div>
              <div class="modal-footer">  
                <button type="button" class="btn btn-primary" onclick="editar_foro()"><i class="fa fa-check"><b>&nbsp;Modificar</b></i></button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"><b>&nbsp;Cerrar</b></i></button>

            </div>
        </div>
    </div>
</div>
</form>


<!-- modaleditar -->


<!-- modaleditarfecha -->

<form autocomplete="false" onsubmit="return false" id="modal1">
    <div class="modal fade" id="modal_fecha" role="dialog">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
          
             <div class="modal-header" style="text-align:center">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><i class="fa fa-comments"></i><b>&nbsp; Activar foro</b></h4>

            </div>
            <input type="text"  id="id_foros" hidden>
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
<!-- modaleditarfecha -->



<!-- modalrespuestas -->

<form autocomplete="false" onsubmit="return false" id="modal1">
    <div class="modal fade" id="modal_respuestas" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="text-align:center">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-comments"></i><b>&nbsp; Respuestas</b></h4>
                </div>
          <input type="text"  id="id_foro_respuesta" hidden>
          <input type="text"  id="id_principal" hidden>
          <input type="text"  id="id_responde_a" hidden>

                <div class="modal-body">
             
              
                <div class="box box-warning">
    <div class="box-header with-border">
        <div class="user-block">
            <img id="img_modal" class="img-circle" src="../dist/img/user1-128x128.jpg" alt="User Image">
            <span id="lbl_username" class="username"><a href="#">nombre</a></span>
            <span class="description">Fecha de comentario: <span  id="lbl_fecha">_____</span></span>
        </div>
    </div>

  
    <div class="box-header with-border">
            <p id="lbl_comentario_principal">comentario principal</p>
          
            <button type="button" class="responder_modal btn btn-default btn-xs pull-left" data-id-responde_a="" id="btnResponderModal">
                                <i class="fa fa-comments"></i> Responder
                            </button>
            </div>

            <div class="box-body">
            <span class="pull-right text-muted">Respuestas: <span id="txt_contador_respuestas"></span></span>
<br><br>
            <div id="respuestas_foro"></div>
        
        </div>
        <div id="comentario_foro_area_respuesta">
            <input type="hidde" id="txt_id_comentario_editar_respuesta" hidden>
       
            <center><h4><span class="title">Responder a ---> <span id="lbl_responder_a">_____</span></span></h4></center>

            <textarea name="" id="txt_comentario_respuesta" cols="10" rows="5" class="form-control" style="resize:none;"></textarea><br>
            <div class="input-group-btn">
                <button type="button" class="btn btn-success" id="btnregistarrespuesta" onclick="registrar_comentario_foro_respuesta()">Agregar respuesta <i class="fa fa-plus"></i></button>
     
            
            <button type="button" class="btn btn-success" id="btnEditarrespuesta" onclick="editar_comentario_foro_respuesta()">Editar respuesta <i class="fa fa-pencil"></i></button>
            <button type="button" class="btn btn-danger cancelar_responder_comentario_foro" id="btnCancelarResponder" style="margin-left: 5px;"><i class="fa fa-close"><b>&nbsp;Cancelar</b></i></button>

        </div>
            <br>
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


<!-- modalrespuestas -->



<script>
    // Obtener el botón por su ID
    var btnEditar = document.getElementById('btnEditar');

    // Ocultar el botón
    btnEditar.style.display = 'none';
</script>

<script src="../Plantilla/plugins/select2/select2.min.js"></script>
<script>
    $(document).ready(function() {
 
       $('.js-example-basic-single1').select2();
            listar_combo_asignatura();
       listar_combo_grado();
       listar_foros();
    
       listar_combo_grupo();
       listar_combo_grupos();
  
       listar_combo_verificar_docente();
       listar_combo_grupo_editar();
       datos();
  
       TraerfechaF();

  
       $("#cbm_grupo").change(function(){
         var id_grupo = $("#cbm_grupo").val();
         listar_combo_grado(id_grupo);
         listar_combo_asignatura(id_grupo);

     });
       $("#cbm_grupo_editar").change(function(){
           var id_grupo = $("#cbm_grupo_editar").val();
          

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


