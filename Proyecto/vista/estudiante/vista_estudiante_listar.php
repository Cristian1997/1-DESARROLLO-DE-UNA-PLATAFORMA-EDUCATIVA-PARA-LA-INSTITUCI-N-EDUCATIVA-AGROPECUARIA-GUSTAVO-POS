<script type="text/javascript" src="../js/estudiante.js?rev=<?php echo time();?>"></script>
<div class="col-md-12">
    <div class="box box-warning box-solid">
        <div class="box-header with-border">
            <h3 class="box-title">ESTUDIANTES</h3>


            <!-- /.box-tools -->
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="form-group">
                <div class="col-lg-10">
                    <div class="input-group">
                        <input type="text" class="global_filter form-control" id="global_filter"
                            placeholder="Ingresar dato a buscar">
                        <span class="input-group-addon"><i class="fa fa-search"></i></span>
                    </div>
                    <br>
                </div>
                <div class="col-lg-2">
                    <button class="btn btn-danger" style="width:100%" onclick="AbrirModalRegistro()"><i
                            class="glyphicon glyphicon-plus"></i>Nuevo Registro</button>
                </div>
            </div>
            <table id="tabla_estudiante" class="display responsive nowrap text-center" style="width:100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Documento</th>
                        <th>Estudiante</th>
                        <th>Fecha de nacimiento</th>
                        <th>Telefono</th>
                        <th>Sexo</th>
                        <th>Email</th>
                        <th>Grados</th>
                        <th>Acci&oacute;n</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>#</th>
                        <th>Documento</th>
                        <th>Estudiante</th>
                        <th>Fecha de nacimiento</th>
                        <th>Telefono</th>
                        <th>Sexo</th>
                        <th>Email</th>
                        <th>Grados</th>
                        <th>Acci&oacute;n</th>
                    </tr>
                </tfoot>
            </table>

        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->
</div>

<form autocomplete="false" onsubmit="return false">
    <div class="modal fade" id="modal_registro" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><b>Registro De Estudiantes</b></h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <label for="">Documento</label>
                            <input type="text" class="form-control" id="txt_documento" placeholder="Ingrese documento"
                                onkeypress="return soloNumeros(event)"><br>
                        </div>
                        <div class="col-lg-6">
                            <label for="">Nombres</label>
                            <input type="text" class="form-control" id="txt_nombres" placeholder="Ingrese nombres"
                                maxlength="50" onkeypress="return soloLetras(event)"><br>
                        </div>
                        <div class="col-lg-6">
                            <label for="">Apellidos</label>
                            <input type="text" class="form-control" id="txt_apellidos" placeholder="Ingrese apellidos"
                                maxlength="50" onkeypress="return soloLetras(event)"><br>
                        </div>


                        <div class="col-lg-6">
                            <label for="">Telefono</label>
                            <input type="data" class="form-control" id="txt_telefono" placeholder="Ingrese telefono"
                                onkeypress="return soloNumeros(event)"><br>

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
                            <input type="password" class="form-control" id="txt_contra"
                                placeholder="Ingrese contraseña"><br>
                        </div>

                        <div class="col-lg-4">
                            <label for="">Confirmar Contrase&ntilde;a</label>
                            <input type="password" class="form-control" id="txt_contra1"
                                placeholder="Ingrese contraseña"><br>
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
                    <button class="btn btn-primary" onclick="Registrar_Estudiante()"><i
                            class="fa fa-check"><b>&nbsp;Registrar</b></i></button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i
                            class="fa fa-close"><b>&nbsp;Cerrar</b></i></button>
                </div>
            </div>
        </div>
    </div>
</form>

<form autocomplete="false" onsubmit="return false">
    <div class="modal fade" id="modal_editar" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><b>Editar Datos Del Estudiante</b></h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <label for="">Documento</label>
                            <input type="text" id="txt_documento_editar_actual"><input type="text" class="form-control"
                                id="txt_documento_editar_nuevo" placeholder="Ingrese documento"
                                onkeypress="return soloNumeros(event)"><br>
                        </div>
                        <div class="col-lg-6">
                            <input type="text" id="id_estudiante" hidden>
                            <label for="">Nombres</label>
                            <input type="text" class="form-control" id="txt_nombres_editar"
                                placeholder="Ingrese nombres" maxlength="50" onkeypress="return soloLetras(event)"><br>
                        </div>
                        <div class="col-lg-6">
                            <label for="">Apellidos</label>
                            <input type="text" class="form-control" id="txt_apellidos_editar"
                                placeholder="Ingrese apellidos" maxlength="50"
                                onkeypress="return soloLetras(event)"><br>
                        </div>

                        <div class="col-lg-4">
                            <label for="">Telefono</label>
                            <input type="data" class="form-control" id="txt_telefono_editar"
                                placeholder="Ingrese telefono" onkeypress="return soloNumeros(event)"><br>

                        </div>

                        <div class="col-lg-4">
                            <label for="">Fecha de Nacimiento</label>
                            <input type="date" class="form-control" id="txt_fecha_editar"><br>
                        </div>

                        <div class="col-lg-4">
                            <label for="">Email</label>
                            <input type="text" class="form-control" id="txt_email_editar"
                                placeholder="Ingrese email"><br>
                            <label for="" id="emailOK_editar" style="color:red;"></label>
                            <input type="text" id="validar_email_editar" hidden>
                        </div>

                        <div class="col-lg-6">
                            <label for="">Sexo</label>
                            <select class="js-example-basic-single" name="state" id="cbm_sexo_editar"
                                style="width:100%;">
                                <option value="M">MASCULINO</option>
                                <option value="F">FEMENINO</option>
                            </select><br><br>
                        </div>

                        <div class="col-lg-6">
                            <label for="">Grado</label>
                            <select class="js" name="state" id="cbm_grado_editar" style="width:100%;">
                            </select><br>
                        </div>

                        <div class="col-lg-12" style="text-align:center">
                            <b>DATOS DEL USUARIO</b><br><br>
                        </div>

                        <div class="col-lg-6">
                            <input type="text" id="id_usuario" hidden>
                            <label for="">Usuario</label>
                            <input type="text" class="form-control" id="txt_usu_editar" placeholder="Ingrese usuario"
                                disabled><br>
                        </div>


                        <div class="col-lg-6 text-center">
                            <label for="" class="text-center">Estado de Cuenta</label><br>
                            <span class="bt btn btn-success" id="status" style="width: 120px; height: 35px;"></span>
                        </div>



                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" onclick="Editar_Estudiante()"><i class="fa fa-check"><b>&nbsp;Editar
                                Registro</b></i></button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i
                            class="fa fa-close"><b>&nbsp;Cerrar</b></i></button>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
$(document).ready(function() {

    listar_estudiante();
    listar_combo_grado();
    $("#modal_registro").on('shown.bs.modal', function() {
        $("#txt_nombres").focus();
    })
});


document.getElementById('txt_email').addEventListener('input', function() {
    campo = event.target;
    emailRegex = /^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i;
    if (emailRegex.test(campo.value)) {
        $(this).css("border", "");
        $("#emailOK").html("");
        $("#validar_email").val("correcto");
    } else {
        $(this).css("border", "1px solid red");
        $("#emailOK").html("Email Incorrecto");
        $("#validar_email").val("incorrecto");
    }

});
document.getElementById('txt_email_editar').addEventListener('input', function() {
    campo = event.target;
    emailRegex = /^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i;
    if (emailRegex.test(campo.value)) {
        $(this).css("border", "");
        $("#emailOK_editar").html("");
        $("#validar_email_editar").val("correcto");
    } else {
        $(this).css("border", "1px solid red");
        $("#emailOK_editar").html("Email Incorrecto");
        $("#validar_email_editar").val("incorrecto");
    }

});

$('.box').boxWidget({
    animationSpeed: 500,
    collapseTrigger: '[data-widge="collapse"]',
    removeTrigger: '[data-widge="remove"]',
    collapseIcon: 'fa-minus',
    expandIcon: 'fa-plus',
    removeIcon: 'fa-times'
})
</script>
