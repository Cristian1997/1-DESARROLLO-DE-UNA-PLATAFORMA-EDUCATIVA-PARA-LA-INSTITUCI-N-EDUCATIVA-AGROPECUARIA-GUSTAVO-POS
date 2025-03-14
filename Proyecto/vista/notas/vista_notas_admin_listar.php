<script type="text/javascript" src="../js/calificaciones.js?rev=<?php echo time(); ?>"></script>

<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="../Plantilla/plugins/select2/select2.min.css">
<div class="col-md-12">
    <div class="box box-warning box-solid">
        <div class="box-header with-border">
          <h3 class="box-title">NOTAS</h3>

        <!-- /.box-tools -->
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <div class="form-group">
        <div class="col-lg-12">
                <div class="input-group">
                    <input type="text" class="global_filter form-control" id="global_filter" placeholder="Ingresar dato a buscar">
                    <span class="input-group-addon"><i class="fa fa-search"></i></span>
                </div>
                <br>
            </div>
     <!-- /.tabla notas admin -->
     <div class="col-lg-12 table-responsive">
        <table id="tabla_calificaciones_admin" class="display responsive nowrap text-center" style="width:100% ">
            <thead >
                <tr >
                  <th>#</th>
                  <th>Estudiantes</th>
                  <th>Docentes</th>
                  <th>Materias</th>
                  <th>Aula</th>
                  <th>Nota 25%</th>
                  <th>Nota 25%</th>
                  <th>Nota 25%</th>
                  <th>Nota 25%</th>
                  <th>Definitiva</th>
                  <th>Estado</th>
                  <th>Acci&oacute;n</th>


              </tr>
          </thead>
          <tfoot>
              <th>#</th>
              <th>Estudiantes</th>
                  <th>Docentes</th>
                  <th>Materias</th>
                  <th>Aula</th>
                  <th>Nota 25%</th>
                  <th>Nota 25%</th>
                  <th>Nota 25%</th>
                  <th>Nota 25%</th>
                  <th>Definitiva</th>
                  <th>Estado</th>
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


<!-- modar para editar notas admin -->
<form autocomplete="false" onsubmit="return false" id="modal1">
    <div class="modal fade" id="modal_editar_admin" role="dialog">
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
        <button type="button" class="btn btn-primary" onclick="Editar_calificaciones()"><i class="fa fa-edit" ><b>&nbsp;Editar!</b></i></button>
    </div>
</div>
</div>
</div>
</form>


<script src="../Plantilla/plugins/select2/select2.min.js"></script>
<script>
    $(document).ready(function() {
        listar_calificaciones_admin();
     $('.js-example-basic-single').select2();

 
 

   
    })
 



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
