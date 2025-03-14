<script type="text/javascript" src="../js/horarios.js?rev=<?php echo time(); ?>"></script>

<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="../Plantilla/plugins/select2/select2.min.css">
<div class="col-md-12">
    <div class="box box-warning box-solid">
        <div class="box-header with-border">
          <h3 class="box-title">HORARIOS ESPECIFICOS DE ESTUDIANTES</h3>

        <!-- /.box-tools -->
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <div class="form-group">
        <div class="col-lg-8">
                <div class="input-group">
                    <input type="text" class="global_filter form-control" id="global_filter" placeholder="Ingresar dato a buscar">
                    <span class="input-group-addon"><i class="fa fa-search"></i></span>
                </div>
                <br>
            </div>

            <div class="col-lg-2">
                <button class="btn btn-danger" style="width:100%" onclick="registrar_horarios()"><i class="glyphicon glyphicon-plus"></i>Nuevo Registro</button>
            </div>
         
            <div class="col-lg-2">
         <button class="btn btn-success" style="width:100%" onclick="cargar_contenido('contenido_principal','horarios/vista_horarios_docentes.php')" ><i class="fa fa-table"></i>&nbsp;Horarios Docentes</button>
     </div>   
     <!-- /.tabla notas admin -->
     <div class="col-lg-12 table-responsive">
        <table id="tabla_horarios" class="display responsive nowrap text-center" style="width:100% ">
            <thead >
                <tr >
                  <th>#</th>
                  <th>Grado</th>
                  <th>Ver Horario</th>
                  <th>Acci&oacute;n</th>


              </tr>
          </thead>
          <tfoot>
              <th>#</th>
              <th>Grado</th>
              <th>Ver Horario</th>
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



<form autocomplete="false" onsubmit="return false">
    <style>
        /* Estilo para el modal */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1050;
            width: 100%;
            height: 100%;
            overflow: hidden;
            outline: 0;
        }
         /* Estilo para el fondo oscuro del modal */
         .modal-backdrop {
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1040;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5); /* Ajusta la opacidad del fondo oscuro aquí */
        }

        
    </style>
    <div class="modal fade" id="modal_registro_horarios" role="dialog">
        <div class="modal-dialog" style="width: 95%;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><b>Registro De Horarios</b></h4>
                </div>
                <div class="modal-body">
                    <div class="row">  
                    <div class="col-md-12">
                    <div class="box box-solid">


                    <table border="1" style="font-family: Arial, sans-serif; border-collapse: collapse; width: 100%; font-size: 13px">
  <tr>
    <td colspan="9" class="grado" id="grado" style="font-weight: bold; text-align: center; padding: 10px;"><select class="js" name="state" id="cbm_grado" style="width:30%;"></select></td>
  </tr>
  <tr>
  <th style="padding: 5px; text-align: center; background-color: #f2f2f2; font-weight: bold;"> </th>
  <th style="padding: 5px; text-align: center; background-color: #f2f2f2;">
    <span class="bloque-numero">1</span><br>
    <input type="text" id="bloque_1" style="width: 120px;" placeholder="12:05 PM - 1:00 PM">
</th>
<th style="padding: 5px; text-align: center; background-color: #f2f2f2;">
    <span class="bloque-numero">2</span><br>
    <input type="text" id="bloque_2" style="width: 120px;" placeholder="1:00 PM - 1:55 PM">
</th>
<td class="descanso" rowspan="6" style="font-weight: bold; line-height: 1em; white-space: pre-line; background-color: #ffffff; border-radius: 50%; text-align: center; padding: 10px;">D<br><br>E<br><br>S<br><br>C<br><br>A<br><br>N<br><br>S<br><br>O</td>
<th style="padding: 5px; text-align: center; background-color: #f2f2f2;">
    <span class="bloque-numero">3</span><br>
    <input type="text" id="bloque_3" style="width: 120px;" placeholder="2:15 PM - 3:10 PM">
</th>
<th style="padding: 5px; text-align: center; background-color: #f2f2f2;">
    <span class="bloque-numero">4</span><br>
    <input type="text" id="bloque_4" style="width: 120px;" placeholder="3:10 PM - 4:05 PM">
</th>
<td class="descanso" rowspan="6" style="font-weight: bold; line-height: 1em; white-space: pre-line; background-color: #ffffff; border-radius: 50%; text-align: center; padding: 10px;">D<br><br>E<br><br>S<br><br>C<br><br>A<br><br>N<br><br>S<br><br>O</td>
<th style="padding: 5px; text-align: center; background-color: #f2f2f2;">
    <span class="bloque-numero">5</span><br>
    <input type="text" id="bloque_5" style="width: 120px;" placeholder="4:15 PM - 5:10 PM">
</th>
<th style="padding: 5px; text-align: center; background-color: #f2f2f2;">
    <span class="bloque-numero">6</span><br>
    <input type="text" id="bloque_6" style="width: 120px;" placeholder="5:10 PM - 6:05 PM">
</th>
  </tr>
  <tr>
    <td style="text-align: center;"><b>Lunes</b></td>
    <td id="lunes_1" style="text-align: center;"><select class="js" name="state" id="cbm_lunes_1" style="width:100%; "></select></td>
    <td id="lunes_2" style="text-align: center;"><select class="js" name="state" id="cbm_lunes_2" style="width:100%;"></select></td>
    <td id="lunes_3" style="text-align: center;"><select class="js" name="state" id="cbm_lunes_3" style="width:100%;"></select></td>
    <td id="lunes_4" style="text-align: center;"><select class="js" name="state" id="cbm_lunes_4" style="width:100%;"></select></td>
    <td id="lunes_5" style="text-align: center;"><select class="js" name="state" id="cbm_lunes_5" style="width:100%;"></select></td>
    <td id="lunes_6" style="text-align: center;"><select class="js" name="state" id="cbm_lunes_6" style="width:100%;"></select></td>
  </tr>
  <tr>
    <td style="text-align: center;"><b>Martes</b></td>
    <td id="martes_1" style="text-align: center;"><select class="js" name="state" id="cbm_martes_1" style="width:100%;"></select></td>
    <td id="martes_2" style="text-align: center;"><select class="js" name="state" id="cbm_martes_2" style="width:100%;"></select></td>
    <td id="martes_3" style="text-align: center;"><select class="js" name="state" id="cbm_martes_3" style="width:100%;"></select></td>
    <td id="martes_4" style="text-align: center;"><select class="js" name="state" id="cbm_martes_4" style="width:100%;"></select></td>
    <td id="martes_5" style="text-align: center;"><select class="js" name="state" id="cbm_martes_5" style="width:100%;"></select></td>
    <td id="martes_6" style="text-align: center;"><select class="js" name="state" id="cbm_martes_6" style="width:100%;"></select></td>
  </tr>
  <tr>
    <td style="text-align: center;"><b>Miércoles</b></td>
    <td id="miercoles_1" style="text-align: center;"><select class="js" name="state" id="cbm_miercoles_1" style="width:100%;"></select></td>
    <td id="miercoles_2" style="text-align: center;"><select class="js" name="state" id="cbm_miercoles_2" style="width:100%;"></select></td>
    <td id="miercoles_3" style="text-align: center;"><select class="js" name="state" id="cbm_miercoles_3" style="width:100%;"></select></td>
    <td id="miercoles_4" style="text-align: center;"><select class="js" name="state" id="cbm_miercoles_4" style="width:100%;"></select></td>
    <td id="miercoles_5" style="text-align: center;"><select class="js" name="state" id="cbm_miercoles_5" style="width:100%;"></select></td>
    <td id="miercoles_6" style="text-align: center;"><select class="js" name="state" id="cbm_miercoles_6" style="width:100%;"></select></td>
  </tr>
  <tr>
    <td style="text-align: center;"><b>Jueves</b></td>
    <td id="jueves_1" style="text-align: center;"><select class="js" name="state" id="cbm_jueves_1" style="width:100%;"></select></td>
    <td id="jueves_2" style="text-align: center;"><select class="js" name="state" id="cbm_jueves_2" style="width:100%;"></select></td>
    <td id="jueves_3" style="text-align: center;"><select class="js" name="state" id="cbm_jueves_3" style="width:100%;"></select></td>
    <td id="jueves_4" style="text-align: center;"><select class="js" name="state" id="cbm_jueves_4" style="width:100%;"></select></td>
    <td id="jueves_5" style="text-align: center;"><select class="js" name="state" id="cbm_jueves_5" style="width:100%;"></select></td>
    <td id="jueves_6" style="text-align: center;"><select class="js" name="state" id="cbm_jueves_6" style="width:100%;"></select></td>
  </tr>
  <tr>
    <td style="text-align: center;"><b>Viernes</b></td>
    <td id="viernes_1" style="text-align: center;"><select class="js" name="state" id="cbm_viernes_1" style="width:100%;"></select></td>
    <td id="viernes_2" style="text-align: center;"><select class="js" name="state" id="cbm_viernes_2" style="width:100%;"></select></td>
    <td id="viernes_3" style="text-align: center;"><select class="js" name="state" id="cbm_viernes_3" style="width:100%;"></select></td>
    <td id="viernes_4" style="text-align: center;"><select class="js" name="state" id="cbm_viernes_4" style="width:100%;"></select></td>
    <td id="viernes_5" style="text-align: center;"><select class="js" name="state" id="cbm_viernes_5" style="width:100%;"></select></td>
    <td id="viernes_6" style="text-align: center;"><select class="js" name="state" id="cbm_viernes_6" style="width:100%;"></select></td>
  </tr>
</table>



                    </div>
                </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" onclick="Registrar_Horario()()"><i class="fa fa-check"><b>&nbsp;Registrar</b></i></button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"><b>&nbsp;Cerrar</b></i></button>
                </div>
            </div>
        </div>
    </div>
</form>








<form autocomplete="false" onsubmit="return false">
    <style>
        /* Estilo para el modal */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1050;
            width: 100%;
            height: 100%;
            overflow: hidden;
            outline: 0;
        }
         /* Estilo para el fondo oscuro del modal */
         .modal-backdrop {
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1040;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5); /* Ajusta la opacidad del fondo oscuro aquí */
        }

        
    </style>
    <div class="modal fade" id="modal_editar_horarios" role="dialog">
        <div class="modal-dialog" style="width: 95%;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><b>Editar Horario</b></h4>
                </div>
                <input type="hidde"  id="txt_id_horario" hidden>
                <div class="modal-body">
                    <div class="row">  
                    <div class="col-md-12">
                    <div class="box box-solid">

              

                    <table border="1" style="font-family: Arial, sans-serif; border-collapse: collapse; width: 100%; font-size: 13px">
                    <tr>
    <td colspan="9" class="grado"  style="font-weight: bold; text-align: center; padding: 10px;" id="txt_grado_editar"></td>
  </tr>
  <tr>
  <th style="padding: 5px; text-align: center; background-color: #f2f2f2; font-weight: bold;"> </th>
  <th style="padding: 5px; text-align: center; background-color: #f2f2f2;">
    <span class="bloque-numero">1</span><br>
    <input type="text" id="bloque_1_editar" style="width: 120px;" placeholder="12:05 PM - 1:00 PM">
</th>
<th style="padding: 5px; text-align: center; background-color: #f2f2f2;">
    <span class="bloque-numero">2</span><br>
    <input type="text" id="bloque_2_editar" style="width: 120px;" placeholder="1:00 PM - 1:55 PM">
</th>
<td class="descanso" rowspan="6" style="font-weight: bold; line-height: 1em; white-space: pre-line; background-color: #ffffff; border-radius: 50%; text-align: center; padding: 10px;">D<br><br>E<br><br>S<br><br>C<br><br>A<br><br>N<br><br>S<br><br>O</td>
<th style="padding: 5px; text-align: center; background-color: #f2f2f2;">
    <span class="bloque-numero">3</span><br>
    <input type="text" id="bloque_3_editar" style="width: 120px;" placeholder="2:15 PM - 3:10 PM">
</th>
<th style="padding: 5px; text-align: center; background-color: #f2f2f2;">
    <span class="bloque-numero">4</span><br>
    <input type="text" id="bloque_4_editar" style="width: 120px;" placeholder="3:10 PM - 4:05 PM">
</th>
<td class="descanso" rowspan="6" style="font-weight: bold; line-height: 1em; white-space: pre-line; background-color: #ffffff; border-radius: 50%; text-align: center; padding: 10px;">D<br><br>E<br><br>S<br><br>C<br><br>A<br><br>N<br><br>S<br><br>O</td>
<th style="padding: 5px; text-align: center; background-color: #f2f2f2;">
    <span class="bloque-numero">5</span><br>
    <input type="text" id="bloque_5_editar" style="width: 120px;" placeholder="4:15 PM - 5:10 PM">
</th>
<th style="padding: 5px; text-align: center; background-color: #f2f2f2;">
    <span class="bloque-numero">6</span><br>
    <input type="text" id="bloque_6_editar" style="width: 120px;" placeholder="5:10 PM - 6:05 PM">
</th>
  </tr>
  <tr>
    <td style="text-align: center;"><b>Lunes</b></td>
    <td id="lunes_1" style="text-align: center;"><select class="js" name="state" id="cbm_lunes_1_editar" style="width:100%; "></select></td>
    <td id="lunes_2" style="text-align: center;"><select class="js" name="state" id="cbm_lunes_2_editar" style="width:100%;"></select></td>
    <td id="lunes_3" style="text-align: center;"><select class="js" name="state" id="cbm_lunes_3_editar" style="width:100%;"></select></td>
    <td id="lunes_4" style="text-align: center;"><select class="js" name="state" id="cbm_lunes_4_editar" style="width:100%;"></select></td>
    <td id="lunes_5" style="text-align: center;"><select class="js" name="state" id="cbm_lunes_5_editar" style="width:100%;"></select></td>
    <td id="lunes_6" style="text-align: center;"><select class="js" name="state" id="cbm_lunes_6_editar" style="width:100%;"></select></td>
  </tr>
  <tr>
    <td style="text-align: center;"><b>Martes</b></td>
    <td id="martes_1" style="text-align: center;"><select class="js" name="state" id="cbm_martes_1_editar" style="width:100%;"></select></td>
    <td id="martes_2" style="text-align: center;"><select class="js" name="state" id="cbm_martes_2_editar" style="width:100%;"></select></td>
    <td id="martes_3" style="text-align: center;"><select class="js" name="state" id="cbm_martes_3_editar" style="width:100%;"></select></td>
    <td id="martes_4" style="text-align: center;"><select class="js" name="state" id="cbm_martes_4_editar" style="width:100%;"></select></td>
    <td id="martes_5" style="text-align: center;"><select class="js" name="state" id="cbm_martes_5_editar" style="width:100%;"></select></td>
    <td id="martes_6" style="text-align: center;"><select class="js" name="state" id="cbm_martes_6_editar" style="width:100%;"></select></td>
  </tr>
  <tr>
    <td style="text-align: center;"><b>Miércoles</b></td>
    <td id="miercoles_1" style="text-align: center;"><select class="js" name="state" id="cbm_miercoles_1_editar" style="width:100%;"></select></td>
    <td id="miercoles_2" style="text-align: center;"><select class="js" name="state" id="cbm_miercoles_2_editar" style="width:100%;"></select></td>
    <td id="miercoles_3" style="text-align: center;"><select class="js" name="state" id="cbm_miercoles_3_editar" style="width:100%;"></select></td>
    <td id="miercoles_4" style="text-align: center;"><select class="js" name="state" id="cbm_miercoles_4_editar" style="width:100%;"></select></td>
    <td id="miercoles_5" style="text-align: center;"><select class="js" name="state" id="cbm_miercoles_5_editar" style="width:100%;"></select></td>
    <td id="miercoles_6" style="text-align: center;"><select class="js" name="state" id="cbm_miercoles_6_editar" style="width:100%;"></select></td>
  </tr>
  <tr>
    <td style="text-align: center;"><b>Jueves</b></td>
    <td id="jueves_1" style="text-align: center;"><select class="js" name="state" id="cbm_jueves_1_editar" style="width:100%;"></select></td>
    <td id="jueves_2" style="text-align: center;"><select class="js" name="state" id="cbm_jueves_2_editar" style="width:100%;"></select></td>
    <td id="jueves_3" style="text-align: center;"><select class="js" name="state" id="cbm_jueves_3_editar" style="width:100%;"></select></td>
    <td id="jueves_4" style="text-align: center;"><select class="js" name="state" id="cbm_jueves_4_editar" style="width:100%;"></select></td>
    <td id="jueves_5" style="text-align: center;"><select class="js" name="state" id="cbm_jueves_5_editar" style="width:100%;"></select></td>
    <td id="jueves_6" style="text-align: center;"><select class="js" name="state" id="cbm_jueves_6_editar" style="width:100%;"></select></td>
  </tr>
  <tr>
    <td style="text-align: center;"><b>Viernes</b></td>
    <td id="viernes_1" style="text-align: center;"><select class="js" name="state" id="cbm_viernes_1_editar" style="width:100%;"></select></td>
    <td id="viernes_2" style="text-align: center;"><select class="js" name="state" id="cbm_viernes_2_editar" style="width:100%;"></select></td>
    <td id="viernes_3" style="text-align: center;"><select class="js" name="state" id="cbm_viernes_3_editar" style="width:100%;"></select></td>
    <td id="viernes_4" style="text-align: center;"><select class="js" name="state" id="cbm_viernes_4_editar" style="width:100%;"></select></td>
    <td id="viernes_5" style="text-align: center;"><select class="js" name="state" id="cbm_viernes_5_editar" style="width:100%;"></select></td>
    <td id="viernes_6" style="text-align: center;"><select class="js" name="state" id="cbm_viernes_6_editar" style="width:100%;"></select></td>
  </tr>
</table>
                    </div>
                </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" onclick="Editar_Horario()()"><i class="fa fa-check"><b>&nbsp;Editar Horario</b></i></button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"><b>&nbsp;Cerrar</b></i></button>
                </div>
            </div>
        </div>
    </div>
</form>


<form autocomplete="false" onsubmit="return false">
    <div class="modal fade" id="modal_ver_horarios" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><b>Ver Horario</b></h4>
                </div>
                <div class="modal-body">
                    <div class="row">  
                    <div class="col-md-12">
                    <div class="box box-solid">
               


                    <table border="1" style="font-family: Arial, sans-serif; border-collapse: collapse; width: 100%;">
  <tr>
    <td colspan="9" class="grado" id="txt_grado" style="font-weight: bold; text-align: center; padding: 10px;"></td>
  </tr>
  <tr>
  <th style="padding: 5px; text-align: center; background-color: #f2f2f2; font-weight: bold;"> </th>
    <th style="padding: 5px; text-align: center; background-color: #f2f2f2;"><span class="bloque-numero" >1</span><br><span style="font-size: 12px;"id="txt_bloque_1">12:05 PM - 1:00 PM</span></th>
    <th style="padding: 5px; text-align: center; background-color: #f2f2f2;"><span class="bloque-numero" >2</span><br><span style="font-size: 12px;"id="txt_bloque_2">1:00 PM - 1:55 PM</span></th>
    <td class="descanso" rowspan="6" style="font-weight: bold; line-height: 1em; white-space: pre-line; background-color: #ffffff; border-radius: 50%; text-align: center; padding: 10px;">D<br><br>E<br><br>S<br><br>C<br><br>A<br><br>N<br><br>S<br><br>O</td>
    <th style="padding: 5px; text-align: center; background-color: #f2f2f2;"><span class="bloque-numero" >3</span><br><span style="font-size: 12px;"id="txt_bloque_3">2:15 PM - 3:10 PM</span></th>
    <th style="padding: 5px; text-align: center; background-color: #f2f2f2;"><span class="bloque-numero" >4</span><br><span style="font-size: 12px;"id="txt_bloque_4">3:10 PM - 4:05 PM</span></th>
    <td class="descanso" rowspan="6" style="font-weight: bold; line-height: 1em; white-space: pre-line; background-color: #ffffff; border-radius: 50%; text-align: center; padding: 10px;">D<br><br>E<br><br>S<br><br>C<br><br>A<br><br>N<br><br>S<br><br>O</td>
    <th style="padding: 5px; text-align: center; background-color: #f2f2f2;"><span class="bloque-numero" >5</span><br><span style="font-size: 12px;"id="txt_bloque_5">4:15 PM - 5:10 PM</span></th>
    <th style="padding: 5px; text-align: center; background-color: #f2f2f2;"><span class="bloque-numero" >6</span><br><span style="font-size: 12px;"id="txt_bloque_6">5:10 PM - 6:05 PM</span></th>
  </tr>
  <tr>
    <td style="text-align: center;"><b>Lunes</b></td>
    <td id="txt_lunes_1" style="text-align: center;"></td>
    <td id="txt_lunes_2" style="text-align: center;"></td>
    <td id="txt_lunes_3" style="text-align: center;"></td>
    <td id="txt_lunes_4" style="text-align: center;"></td>
    <td id="txt_lunes_5" style="text-align: center;"></td>
    <td id="txt_lunes_6" style="text-align: center;"></td>
  </tr>
  <tr>
    <td style="text-align: center;"><b>Martes</b></td>
    <td id="txt_martes_1" style="text-align: center;"></td>
    <td id="txt_martes_2" style="text-align: center;"></td>
    <td id="txt_martes_3" style="text-align: center;"></td>
    <td id="txt_martes_4" style="text-align: center;"></td>
    <td id="txt_martes_5" style="text-align: center;"></td>
    <td id="txt_martes_6" style="text-align: center;"></td>
  </tr>
  <tr>
    <td style="text-align: center;"><b>Miércoles</b></td>
    <td id="txt_miercoles_1" style="text-align: center;"></td>
    <td id="txt_miercoles_2" style="text-align: center;"></td>
    <td id="txt_miercoles_3" style="text-align: center;"></td>
    <td id="txt_miercoles_4" style="text-align: center;"></td>
    <td id="txt_miercoles_5" style="text-align: center;"></td>
    <td id="txt_miercoles_6" style="text-align: center;"></td>
  </tr>
  <tr>
    <td style="text-align: center;"><b>Jueves</b></td>
    <td id="txt_jueves_1" style="text-align: center;"></td>
    <td id="txt_jueves_2" style="text-align: center;"></td>
    <td id="txt_jueves_3" style="text-align: center;"></td>
    <td id="txt_jueves_4" style="text-align: center;"></td>
    <td id="txt_jueves_5" style="text-align: center;"></td>
    <td id="txt_jueves_6" style="text-align: center;"></td>
  </tr>
  <tr>
    <td style="text-align: center;"><b>Viernes</b></td>
    <td id="txt_viernes_1" style="text-align: center;"></td>
    <td id="txt_viernes_2" style="text-align: center;"></td>
    <td id="txt_viernes_3" style="text-align: center;"></td>
    <td id="txt_viernes_4" style="text-align: center;"></td>
    <td id="txt_viernes_5" style="text-align: center;"></td>
    <td id="txt_viernes_6" style="text-align: center;"></td>
  </tr>
</table>

              
              
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

<script src="../Plantilla/plugins/select2/select2.min.js"></script>
<script>
    $(document).ready(function() {
        listar_horarios();
        listar_combo_cursos();
        listar_combo_grado()
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
