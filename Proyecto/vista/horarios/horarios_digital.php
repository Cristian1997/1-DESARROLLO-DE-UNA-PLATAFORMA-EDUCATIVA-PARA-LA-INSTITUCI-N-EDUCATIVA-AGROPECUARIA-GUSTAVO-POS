<!DOCTYPE html>
<html>

<script type="text/javascript" src="../js/horarios.js?rev=<?php echo time(); ?>"></script>

<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="../Plantilla/plugins/select2/select2.min.css">
<head>
  <title>Horario Semanal</title>
  <style>
    body {
      font-family: Arial, sans-serif;
    }
    table {
      border-collapse: collapse;
      width: 100%;
    }
    th, td {
      padding: 10px;
      text-align: center;
    }
    th {
      background-color: #f2f2f2;
      font-weight: bold; /* Días en negrita */
    }
    td {
      background-color: #ffffff;
    }
    td[id^="lunes"], td[id^="martes"], td[id^="miercoles"], td[id^="jueves"], td[id^="viernes"] {
      border-radius: 50%;
    }
    .descanso {
      font-weight: bold;
      line-height: 1em;
      white-space: pre-line;
      background-color: #ffffff; /* Fondo blanco para descansos */
    }
    .bloque-numero {
      font-weight: bold;
      display: block;
    }
    .grado {
      font-weight: bold;
      text-align: center;
      padding: 10px;
    }
  </style>
</head>
<body>
  <table border="1">
    <tr>
      <td colspan="9" class="grado" id="grado">6A</td>
    </tr>
    <tr>
      <th></th>
      <th><span class="bloque-numero" id="bloque_1">1</span><br>12:05 PM - 1:00 PM</th>
      <th><span class="bloque-numero" id="bloque_2">2</span><br>1:00 PM - 1:55 PM</th>
     <td class="descanso" rowspan="6">D<br><br>E<br><br>S<br><br>C<br><br>A<br><br>N<br><br>S<br><br>O</td>
      <th><span class="bloque-numero" id="bloque_3">3</span><br>2:15 PM - 3:10 PM</th>
      <th><span class="bloque-numero" id="bloque_4">4</span><br>3:10 PM - 4:05 PM</th>
    <td class="descanso" rowspan="6">D<br><br>E<br><br>S<br><br>C<br><br>A<br><br>N<br><br>S<br><br>O</td>
      <th><span class="bloque-numero" id="bloque_5">5</span><br>4:15 PM - 5:10 PM</th>
      <th><span class="bloque-numero" id="bloque_6">6</span><br>5:10 PM - 6:05 PM</th>
    </tr>
    <tr>
      <td><b>Lunes</b></td>
      <td id="lunes_1">Ingles</td>
      <td id="lunes_2">Emprendimiento</td>
      <td id="lunes_3">Español</td>
      <td id="lunes_4">Matemáticas</td>
      <td id="lunes_5">Geografía</td>
      <td id="lunes_6">Geografía</td>
    </tr>
    <tr>
      <td><b>Martes</b></td>
      <td id="martes_1">Educación Física</td>
      <td id="martes_2">Ciencias Naturales</td>
      <td id="martes_3">Español</td>
      <td id="martes_4">Ética</td>
      <td id="martes_5">Español</td>
      <td id="martes_6"></td>
    </tr>
    <tr>
      <td><b>Miércoles</b></td>
      <td id="miercoles_1">Afrocolombiano</td>
      <td id="miercoles_2">Religión</td>
      <td id="miercoles_3">Matemáticas</td>
      <td id="miercoles_4">Artes</td>
      <td id="miercoles_5">Artística</td>
      <td id="miercoles_6"></td>
    </tr>
    <tr>
      <td><b>Jueves</b></td>
      <td id="jueves_1">Ciencias Naturales</td>
      <td id="jueves_2">Matemáticas</td>
      <td id="jueves_3">Matemáticas</td>
      <td id="jueves_4">Español</td>
      <td id="jueves_5">Ciencias Naturales</td>
      <td id="jueves_6"></td>
    </tr>
    <tr>
      <td><b>Viernes</b></td>
      <td id="viernes_1">Informática</td>
      <td id="viernes_2">Historia</td>
      <td id="viernes_3">Inglés</td>
      <td id="viernes_4">Inglés</td>
      <td id="viernes_5">Historia</td>
      <td id="viernes_6"></td>
    </tr>
 
  </table>
</body>
</html>




<form autocomplete="false" onsubmit="return false">
    <div class="modal fade" id="modal_registro_horarios2" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><b>Registro De Horarios1</b></h4>
                </div>
                <div class="modal-body">
                    <div class="row">  
                        <div class="col-lg-12">
                            <label for="">Documento</label>
                            <input type="text" class="form-control" id="txt_documento" placeholder="Ingrese documento"onkeypress="return soloNumeros(event)"><br>
                        </div>
                        <div class="col-lg-6">
                            <label for="">Nombres</label>
                            <input type="text" class="form-control" id="txt_nombres" placeholder="Ingrese nombres" maxlength="50" onkeypress="return soloLetras(event)"><br>
                        </div>
                        <div class="col-lg-6">
                            <label for="">Apellidos</label>
                            <input type="text" class="form-control" id="txt_apellidos" placeholder="Ingrese apellidos" maxlength="50" onkeypress="return soloLetras(event)"><br>
                        </div>


                        <div class="col-lg-6">
                            <label for="">Telefono</label>
                            <input type="data" class="form-control" id="txt_telefono" placeholder="Ingrese telefono"onkeypress="return soloNumeros(event)"><br>

                        </div>

                        <div class="col-lg-6">
                            <label for="">Fecha de Nacimiento</label>
                            <input type="date" class="form-control" id="txt_fecha"><br>
                        </div>

                   
                        <div class="col-lg-6">
                            <label for="">Grado</label>
                            <select class="js" name="state" id="cbm_grado" style="width:100%;">
                            </select><br><br>
                        </div>

                        <div class="col-lg-6">
                            <label for="">Sexo</label>
                            <select class="js-example-basic-single" name="state" id="cbm_sexo" style="width:100%;">
                                <option value="M">MASCULINO</option>
                                <option value="F">FEMENINO</option>
                            </select><br><br>
                        </div>

                        <div class="col-lg-12" style="text-align:center">
                         <b>DATOS DEL USUARIO</b><br><br>
                     </div>

                     <div class="col-lg-4">
                        <label for="">Usuario</label>
                        <input type="text" class="form-control" id="txt_usu" placeholder="Ingrese usuario"><br>
                    </div>

                    <div class="col-lg-4">
                        <label for="">Contrase&ntilde;a</label>
                        <input type="password" class="form-control" id="txt_contra" placeholder="Ingrese contraseña"><br>
                    </div>  

                    <div class="col-lg-4">
                        <label for="">Confirmar Contrase&ntilde;a</label>
                        <input type="password" class="form-control" id="txt_contra1" placeholder="Ingrese contraseña"><br>
                    </div>
                    <div class="col-lg-12">
                        <label for="">Email</label>
                        <input type="text" class="form-control" id="txt_email" placeholder="Ingrese email"><br>
                        <label for="" id="emailOK" style="color:red;"></label>
                        <input type="text" id="validar_email" hidden>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" onclick="Registrar_Estudiante()"><i class="fa fa-check"><b>&nbsp;Registrar</b></i></button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"><b>&nbsp;Cerrar</b></i></button>
            </div>
        </div>
    </div>
</div>
</form>



<script src="../Plantilla/plugins/select2/select2.min.js"></script>
<script>
    $(document).ready(function() {
   
     $('.js-example-basic-single').select2();
 

   
    })
 


</script>