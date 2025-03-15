<script type="text/javascript" src="../js/conferencia.js?rev=<?php echo time();?>"></script>
<div class="col-md-12">
    <div class="box box-warning box-solid">
        <div class="box-header with-border">
          <h3 class="box-title">VIDEO CONFERENCIAS</h3>
          <!-- /.box-tools -->
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <div class="form-group">
            
            <div class="col-lg-6">
                <div class="input-group">
                    <input type="text" class="global_filter form-control" id="global_filter" placeholder="Ingresar dato a buscar">
                    <span class="input-group-addon"><i class="fa fa-search"></i></span>
            </div>
                
            </div>
            <div class="col-lg-3">
            <button class="btn btn-primary" style="width:100%"  onclick="window.open('video_conferencia/conferencias.php', '_blank');"><i class="fa fa-commenting-o"></i>&nbsp;  Iniciar video llamada</button>
       </div>
            
            <div class="col-lg-3">
                <button class="btn btn-danger" style="width:100%" onclick="AbrirModalRegistro()"><i class="glyphicon glyphicon-plus"></i>Nuevo Registro</button>
                </div>  
</div><br><br>

   <div class="col-lg-12 table-responsive">
        <table id="tabla_conferencia" class="display responsive nowrap text-center" style="width:100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Tema</th>
                    <th>Detalle</th> 
                    <th>Grado</th>
                    <th>Materia</th> 
                    <th>Fecha</th>
                    <th>Link</th>          
                    <th>Acci&oacute;n</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                <th>#</th>
                    <th>Tema</th>
                    <th>Detalle</th> 
                    <th>Grado</th>
                    <th>Materia</th> 
                    <th>Fecha</th>
                    <th>Link</th>          
                    <th>Acci&oacute;n</th>
                </tr>
            </tfoot>
        </table>

    </div>
    <!-- /.box-body -->
</div>
<!-- /.box -->
</div>

<script>
    $(document).ready(function() {
        listar_conferencia();
        $('.js-example-basic-single').select2();
        listar_combo_rol();
        $("#modal_registro").on('shown.bs.modal',function(){
            $("#txt_usu").focus();  
        })
    } );
</script>
