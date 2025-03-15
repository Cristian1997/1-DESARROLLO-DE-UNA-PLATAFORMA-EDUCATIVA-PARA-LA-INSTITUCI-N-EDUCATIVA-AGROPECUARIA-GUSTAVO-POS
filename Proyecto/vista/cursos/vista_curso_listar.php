<script type="text/javascript" src="../js/cursos.js?rev=<?php echo time();?>"></script>
<div class="col-md-12">
    <div class="box box-warning box-solid">
        <div class="box-header with-border">
            <h3 class="box-title">CURSOS</h3>
            <!-- /.box-tools -->
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="form-group">
                <div class="col-lg-10">
                    <div class="input-group">
                        <input type="text" class="global_filter form-control" id="global_filter" placeholder="Ingresar dato a buscar">
                        <span class="input-group-addon"><i class="fa fa-search"></i></span>
                    </div>
                    <br>
                </div>
                <div class="col-lg-2">
                    <button class="btn btn-danger" style="width:100%" onclick="AbrirModalRegistro()"><i class="glyphicon glyphicon-plus"></i>Nuevo Registro</button>
                </div>
            </div>
            <table id="tabla_cursos" class="display responsive nowrap text-center" style="width:100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Cursos</th>
                        <th>Estado</th>
                        <th>Acci&oacute;n</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>#</th>
                        <th>Cursos</th>
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

<form autocomplete="false" onsubmit="return false">
    <div class="modal fade" id="modal_registro" role="dialog">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><b>Registrar Nueva asignatura</b></h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <label for="">Nombre Asignatura</label>
                            <input type="text" class="form-control" id="txt_nombres" placeholder="Ingrese nombres de Asignatura" maxlength="50" onkeypress="return soloLetras(event)">
                            <br>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" onclick="Registrar_asignatura()"><i class="fa fa-check"><b>&nbsp;Registrar</b></i></button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"><b>&nbsp;Cerrar</b></i></button>
                </div>
            </div>
        </div>
    </div>
</form>

<form autocomplete="false" onsubmit="return false">
    <div class="modal fade" id="modal_editar" role="dialog">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><b>Editar Asignatura</b></h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <input type="text" id="id_asignatura" hidden>
                            <label for="">Nombre de Asignatura</label>
                            <input type="text" class="form-control" id="txt_nombres_editar" placeholder="Ingrese nombres" maxlength="50" onkeypress="return soloLetras(event)">
                            <br>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" onclick="Editar_Asignaturas()"><i class="fa fa-check"><b>&nbsp;Editar Registro</b></i></button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"><b>&nbsp;Cerrar</b></i></button>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    
    $(document).ready(function() {
        listar_cursos();
    
        $('.js-example-basic-single').select2();
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
