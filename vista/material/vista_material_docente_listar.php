<script type="text/javascript" src="../js/material.js?rev=<?php echo time(); ?>"></script>

<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="../Plantilla/plugins/select2/select2.min.css">



<style>
        #titulo_carpeta {
            word-wrap: break-word;
            max-width: calc(100% - 200px); /* Restar el ancho del botón */
        }
    </style>




<div id="contenedor-columnas" class="col-md-12">
    
    <div class="box box-widget widget-user-2">
        <div class="widget-user-header bg-green">
            
        <div class="box-header with-border">
<h3 class="box-title">Carpetas</h3>
<div class="box-tools pull-right">
<button class="nueva_carpeta  btn btn-primary custom-btn pull-right" style="width: 100px; height: 23px; font-size: 12px; padding: 1px;">
    <i class="fa fa-plus"></i> Agregar carpeta
</button>

</div>
         </div>

         <div class="widget-user-image">
         <br>
         <img id="user-avatar" class="img-circle" src="../dist/img/user7-128x128.jpg" alt="User Avatar" style="width: 50px; height: 50px; border-radius: 50%;">

</div>
         <div class="row" id="lista_datos_docente_materiales">
    <!-- Aquí se mostrarán los datos del docente y materiales -->
</div>

        </div>
        <div class="box-footer no-padding">
        <ul class="nav nav-stacked" id="lista_carpeta_materiales">
                <!-- Aquí se mostrarán las carpetas y materiales -->
        </div>
    </div>
</div>





<div class="container">
    <div class="row">
        <!-- Aquí está el div que queremos ocultar/mostrar -->
        <div class="col-md-7" id="div_oculto" style="display: none;">
            <div class="box box-success">
  
                <div class="box-header with-border">   
                <div class="box-tools pull-right"> 
<button type="button" class="btn btn-box-tool" ><i class="fa fa-times"></i></button>
            </div>        
                <h3 id="titulo_carpeta" class="box-title">Materiales de apoyo:</h3>
                    <input type="text" id="id_carpeta" hidden> <!-- El input para almacenar el id de la carpeta, oculto -->
                    <div class="box-tools pull-right">
                        
                    <button   class="nuevo_material btn btn-sm btn-primary custom-btn pull-right">
                            <i class="fa fa-plus"></i> Agregar material de apoyo
                            </button>

                    </div>
                </div>

                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table no-margin">
                            <thead>
                                <tr>
                                    <th>Material de apoyo</th>
                                    <th>Estado</th>
                                    <th>Descargar material</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody id="lista_materiales">
                                <!-- Aquí se llenarán dinámicamente los materiales -->
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="box-footer clearfix">
                <input id="txt_archivo_material_actual_eliminar" hidden>
                    <!-- Puedes agregar contenido adicional en el footer si es necesario -->
                </div>
            </div>
        </div>
    </div>
</div>






<div class="modal fade" id="modal_nueva_carpeta" role="dialog">
    <div class="modal-dialog modal-xs">
        <div class="modal-content">
            <div class="modal-header" style="text-align:center">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><i class="fa fa-folder-open-o"></i><b>&nbsp; Crear carpeta</b></h4>        
            </div>
            <div class="modal-body">
                <div class="row">
                    
                <div class="col-lg-12">
                        <label for="">Nombre de la carpeta</label><br>
                        <input type="text" class="form-control" id="txt_titulo_carpeta">

                    </div>

                </div>
            </div>
            <div class="modal-footer">    
            <button type="button" class="btn btn-primary" onclick="crear_carpeta_material()"><i class="fa fa-check"><b>&nbsp;Crear carpeta</b></i></button>

                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"><b>&nbsp;Cerrar</b></i></button>
            </div>
        </div>
    </div>
</div>





<div class="modal fade" id="modal_editar_carpeta" role="dialog">
    <div class="modal-dialog modal-xs">
        <div class="modal-content">
            <div class="modal-header" style="text-align:center">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><i class="fa fa-folder-open-o"></i><b>&nbsp; Editar carpeta</b></h4>        
            </div>
            <input type="text" id="id_editar_carpeta" hidden>

            <div class="modal-body">
                <div class="row">
                    
                <div class="col-lg-12">
                        <label for="">Nombre de la carpeta</label><br>
                        <input type="text" class="form-control" id="txt_titulo_carpeta_editar">

                    </div>

                </div>
            </div>
            <div class="modal-footer">    
            <button type="button" class="btn btn-primary" onclick="editar_carpeta_material()"><i class="fa fa-check"><b>&nbsp;Editar carpeta</b></i></button>

                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"><b>&nbsp;Cerrar</b></i></button>
            </div>
        </div>
    </div>
</div>





<div class="modal fade" id="modal_nuevo_material" role="dialog">
    <div class="modal-dialog modal-xs">
        <div class="modal-content">
            <div class="modal-header" style="text-align:center">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><i class="fa fa-folder-open-o"></i><b>&nbsp; Agregar Material de apoyo</b></h4>
                
            </div>
            <div class="modal-body">
                <div class="row">

                <div class="col-lg-12">
                        <label for="">Nombre del material</label><br>
                        <input type="text" class="form-control" id="txt_titulo_material">

                    </div>

          
                <div class="col-lg-12"><br>
                
                            <label for="">&nbsp;Subir Archivo</label><br>
                            <input type="file" id="txt_archivo_subir"><br>
                        </div>
                </div>
            </div>
            <div class="modal-footer">    
            <button type="button" class="btn btn-primary" onclick="enviar_archivo()"><i class="fa fa-check"><b>&nbsp;Enviar archivo</b></i></button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"><b>&nbsp;Cerrar</b></i></button>
            </div>
        </div>
    </div>
</div>




<div class="modal fade" id="modal_editar_material" role="dialog">
    <div class="modal-dialog modal-xs">
        <div class="modal-content">
            <div class="modal-header" style="text-align:center">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><i class="fa fa-folder-open-o"></i><b>&nbsp; Editar Material de apoyo</b></h4>
                <input type="text" id="id_editar_material" hidden>
                <input id="txt_archivo_material_actual" hidden>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <label for="">Nombre del material</label><br>
                        <input type="text" class="form-control" id="txt_titulo_material_editar">
                    </div>
                 
                       
                       
              
                    <div class="col-lg-12"><br>
                        <label for="">&nbsp;Subir nuevo archivo</label><br>
                        <input type="file" id="txt_archivo_subir_editar"><br>
                    </div>
                </div>
            </div>
            <div class="modal-footer">    
                <button type="button" class="btn btn-primary" onclick="editar_archivo()"><i class="fa fa-check"><b>&nbsp;Editar archivo</b></i></button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"><b>&nbsp;Cerrar</b></i></button>
            </div>
        </div>
    </div>
</div>








<script src="../Plantilla/plugins/select2/select2.min.js"></script>
<script>
    $(document).ready(function() {

       $('.js-example-basic-single1').select2();
 
       listar_datos_docente_materiales();
       listar_carpeta_materiales();
       TraerfechaM();

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
