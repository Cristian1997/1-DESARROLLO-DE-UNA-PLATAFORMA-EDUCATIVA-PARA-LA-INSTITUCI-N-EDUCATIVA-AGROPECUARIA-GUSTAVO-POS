<script type="text/javascript" src="../js/secretaria.js?rev=<?php echo time();?>"></script>
<div class="col-md-12">
    <div class="box box-warning box-solid">
        <div class="box-header with-border">
            <h3 class="box-title">GRUPOS</h3>


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
                    <button class="btn btn-danger" style="width:100%" onclick="abrir_registro()"><i class="glyphicon glyphicon-plus"></i>Nuevo Registro</button>
                </div>
                
            </div>
            <table id="tabla_secretaria" class="display responsive nowrap text-center" style="width:100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Grupo</th>
                        <th>Docente</th>
                        <th>Asignatura</th>
                        <th>Fecha de Asgnación</th>
                        <th>Estado</th>
                        <th>Acci&oacute;n</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>#</th>
                        <th>Grupo</th>
                        <th>Docente</th>
                        <th>Asignatura</th>
                        <th>Fecha de Asgnación</th>
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
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><b>Nuevo Grupo</b></h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        
                        <div class="col-lg-12">
                            <label for="">Grupo</label>
                            <select class="js-example-basic-single" name="state" id="cbm_grupo" style="width:100%;">
                            </select>
                            <br>
                            <br>
                        </div>
                        
                        <div class="col-lg-12">
                            <label for="">Asignatura</label>
                            <select class="js-example-basic-single1" name="state" id="cbm_asignatura" style="width:100%;">
                            </select>
                            <br>
                            <br>
                        </div>
                        
                        <div class="col-lg-12">
                            <label for="">Docente</label>
                            <select class="js-example-basic-single2" name="state" id="cbm_docente" style="width:100%;">
                            </select>
                            <br>
                            <br>
                        </div>
                        
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" onclick="Registrar_Grupo()"><i class="fa fa-check"><b>&nbsp;Registrar</b></i></button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"><b>&nbsp;Cerrar</b></i></button>
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
                    <h4 class="modal-title"><b>Editar Grupo</b></h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        
                        <div class="col-lg-12">
                            <input type="text" id="id_grupo">
                            <label for="">Grupo</label>
                            <select class="js-example-basic-single" name="state" id="cbm_grupo_editar" style="width:100%;">
                            </select>
                            <br>
                            <br>
                        </div>
                        
                        <div class="col-lg-12">
                            <label for="">Asignatura</label>
                            <select class="js-example-basic-single1" name="state" id="cbm_asignatura_editar" style="width:100%;">

                            </select>
                            <br>
                            <br>
                        </div>
                        
                        <div class="col-lg-12">
                            <label for="">Docente</label>
                            <select class="js-example-basic-single2" name="state" id="cbm_docente_editar" style="width:100%;">
                            </select>
                            <br>
                            <br>
                        </div>
                        
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" onclick="modificar_grupo()"><i class="fa fa-check"><b>&nbsp;Editar Grupo</b></i></button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"><b>&nbsp;Cerrar</b></i></button>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    $(document).ready(function(){
       $('.js-example-basic-single').select2();
        listar_grupos();
        listar_combo_grado();
        listar_combo_rol_docente();
        listar_combo_asignatura();  
        listar_combo_grado_editar();
        listar_combo_rol_docente_editar();
        listar_combo_asignatura_editar();
        traerdatos();
        $("#modal_registro").on('shown.bs.modal',function(){
            $("#txt_nombres").focus();  
        })
    });

    document.getElementById('txt_email').addEventListener('input', function() {
        campo = event.target;
        emailRegex = /^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i;
        if(emailRegex.test(campo.value)){
            $(this).css("border","");
            $("#emailOK").html("");
            $("#validar_email").val("correcto");
        }else{
            $(this).css("border","1px solid red");
            $("#emailOK").html("Email Incorrecto");
            $("#validar_email").val("incorrecto");
        }
    });
    
    document.getElementById('txt_email_editar').addEventListener('input', function() {
        campo = event.target;
        emailRegex = /^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i;
        if(emailRegex.test(campo.value)){
            $(this).css("border","");
            $("#emailOK_editar").html("");
            $("#validar_email_editar").val("correcto");
        }else{
            $(this).css("border","1px solid red");
            $("#emailOK_editar").html("Email Incorrecto");
            $("#validar_email_editar").val("incorrecto");
        }
    });

    $('.box').boxWidget({
        animationSpeed : 500,
        collapseTrigger: '[data-widge="collapse"]',
        removeTrigger  : '[data-widge="remove"]',
        collapseIcon   : 'fa-minus',
        expandIcon     : 'fa-plus',
        removeIcon     : 'fa-times'
    })
</script>
