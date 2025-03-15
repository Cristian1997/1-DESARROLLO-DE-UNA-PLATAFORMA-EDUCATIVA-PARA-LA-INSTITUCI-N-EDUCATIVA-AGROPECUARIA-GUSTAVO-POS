<script type="text/javascript" src="../js/registro_clases.js?rev=<?php echo time(); ?>"></script>

<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="../Plantilla/plugins/select2/select2.min.css">
<div class="col-md-12">
    <div class="box box-warning box-solid">
        <div class="box-header with-border">
            <input type="text" id="id_estudiante_verifity">
            <input type="text" id="id_docente_verifity">
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

                <div class="col-lg-8">
                    <label for="">Mis Grupos</label>
                    <select class="js-example-basic-single1" name="state" id="cbm_grupo" style="width:100%;">
                    </select>
                    <br>
                    <br>
                </div>

                <div class="col-lg-4">
                    <label for="">&nbsp;</label>
                    <br>
                    <button class="btn btn-primary" style="width:100%" onclick="listar()"><i class="fa fa-search"></i> Listar</button>
                </div>
                
            </div>
            <br>
            <br>
            <br>

            <div class="col-lg-12 table-responsive ">
                <table id="tabla_grabacion_de_clases" class=" display  nowrap text-center" style="width:100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Fecha</th>
                            <th>Titulo</th>
                            <th>Registro de clase</th>
                            <th>Docente</th>
                            <th>Materia</th>
                            <th>Grado</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Fecha</th>
                            <th>Titulo</th>
                            <th>Registro de clase</th>
                            <th>Docente</th>
                            <th>Materia</th>
                            <th>Grado</th>
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
    <div class="modal fade" id="modal_ver_des" role="dialog">
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
                                        <img id="foto" class="img-circle" src=" " alt="User Image">
                                        <span class="username"><a href="#" id="txtdocente">nombre</a></span>
                                        <span class="description" id="txtfecha">fecha</span>
                                    </div>
                                </div>
                                <div class="box-header with-border">
                                    <div class="container">
                                        <div class="row justify-content-center">
                                            <div class="col-lg-9">
                                                <!-- Define el ancho del contenedor -->
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
                    </div>
                </div>
</form>

<script src="../Plantilla/plugins/select2/select2.min.js"></script>
<script>
    $(document).ready(function() {

       $('.js-example-basic-single1').select2();
       listar_combo_verificar_docentes();
       listar_combo_verificar_estudiante();
       listar_combo_materia();
       listar_grabacion_de_clases();
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
