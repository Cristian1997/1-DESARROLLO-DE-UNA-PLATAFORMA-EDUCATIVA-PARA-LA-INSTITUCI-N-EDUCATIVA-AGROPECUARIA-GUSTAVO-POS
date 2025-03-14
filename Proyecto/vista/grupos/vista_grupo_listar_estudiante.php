<script type="text/javascript" src="../js/grupos.js?rev=<?php echo time(); ?>"></script>

<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="../Plantilla/plugins/select2/select2.min.css">
<div class="col-md-12">
    <div class="box box-warning box-solid">
        <div class="box-header with-border">
          <h3 class="box-title">MIS GRUPOS</h3>

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
            <label for="">Mis Grados</label>
            <select class="js-example-basic-single" name="state" id="cbm_grado" style="width:100%;">

            </select><br><br>

        </div>

        <div class="col-lg-10">
            <label for="">Mis Grupos</label>
            <select class="js-example-basic-single" name="state" id="cbm_grupo" style="width:100%;">

            </select><br><br>

        </div>

        

        <div class="col-lg-2">
           <label for="">&nbsp;</label><br>
           <button class="btn btn-primary" style="width:100%" onclick="listar()" ><i class="fa fa-search"></i>  Listar</button>

       </div>    

  
       <div class="col-lg-12 table-responsive">
        <table id="tabla_Grupo" class="display responsive nowrap text-center" style="width:100% ">
            <thead >
                <tr >
                  <th>#</th>
                  <th>Estudiantes</th>
                  <th>Asignatura</th>
                  <th>Grado</th>

              </tr>
          </thead>
          <tfoot>
            <th>#</th>
            <th>Estudiantes</th>
            <th>Asignatura</th>
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
                            <div class="box-header with-border">
                                <i class="fa   fa-stethoscope"></i>
                                <h3 class="box-title">Editar calificaciones</h3>
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

                         </div>

                     </div>

                 </div>
             </div>

         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"><b>&nbsp;Cerrar</b></i></button> 
            <button type="button" class="btn btn-primary" onclick="Editar_calificaciones()"><i class="fa fa-edit" ><b>&nbsp;Editar!</b></i></button>
        </div>
    </div>
</div>
</div>
</form>


<script src="../Plantilla/plugins/select2/select2.min.js"></script>
<script>
    $(document).ready(function() {
       $('.js-example-basic-single').select2();
       listar_grupo()
       listar();
       listar_combo_materia();
       listar_combo_asignatura();
       listar_combo_grado();
      
      
    

       $("#cbm_grupo").change(function(){
         var id_grupo = $("#cbm_grupo").val();
         listar_combo_grado(id_grupo);
         listar_combo_asignatura(id_grupo);

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

</script>


<div class="box box-warning">
    <div class="box-header with-border">
        <h3 class="box-title">Vista de Perfil </h3>
        <div class="box-tools pull-right">
            <span class="label label-danger">Estudiantes: <span id="txt_contador"></span></span>
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
    </div>
<br>


    <div class="box-body no-padding">
        
        <div style="text-align: center;">
    <img id="fotodocente" src="" alt="User Image" style="width: 50px; height: 50px; border-radius: 50%;">
    <a class="users-list-name" href="#" id="lblnombre">nombre</a>
    <span class="users-list-date">Docente</span>
</div>
            <div id="lista_grupos"></div>
      
    </div>
</div>





