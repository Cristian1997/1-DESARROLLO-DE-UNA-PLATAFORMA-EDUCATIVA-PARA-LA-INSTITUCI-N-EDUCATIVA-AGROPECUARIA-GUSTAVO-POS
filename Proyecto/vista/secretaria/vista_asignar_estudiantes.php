<script type="text/javascript" src="../js/secretaria.js?rev=<?php echo time();?>"></script>
<div class="col-md-12">
    <div class="box box-warning box-solid">
        <div class="box-header with-border">
            <h3 class="box-title">ASIGNACIÓN DE ESTUDIANTES</h3>
            <!-- /.box-tools -->
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="form-group">
                
                <div class="col-lg-3">
                    <input type="text" id="docente_id" hidden>
                    <label for="">Grupos</label>
                    <select class="js-example-basic-single" name="state" id="cbm_grupos" style="width:100%;">
                    </select>
                    <br>
                    <br>

                </div>
                <div class="col-lg-3">
                    <label for="">Docentes</label>
                    <select class="js-example-basic-single" name="state" id="cbm_profesor" style="width:100%;">
                    </select>
                    <br>
                    <br>
                </div>

                <div class="col-lg-3">
                    <label for="">&nbsp;</label>
                    <br>
                    <button class="btn btn-primary" style="width:100%" onclick="datos()"><i class="fa fa-search"></i> Listar</button>
                </div>

                <div class="col-lg-3">
                    <label for="">&nbsp;</label>
                    <br>
                    <button class="btn btn-primary" style="width:100%" onclick="cargar_registros()"><i class="fa fa-spinner"></i> &nbsp;Asignar Estudiantes </button>
                </div>
                
            </div>

            <table id="tabla_grupos" class="display responsive nowrap text-center" style="width:100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Grupo</th>
                        <th>Docente</th>
                        <th>Estudiante</th>

                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>#</th>
                        <th>Grupo</th>
                        <th>Docente</th>
                        <th>Estudiante</th>

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

                    <h4 class="modal-title"><b>Asignar Estudiantes</b></h4>
                </div>
                <div class="modal-body">
                    <div class="row">

                        <div class="col-lg-12">
                            <label for="">Docente</label>
                            <select class="js-example-basic-single" name="state" id="cbm_docente" style="width:100%;">
                            </select>
                            <br>
                            <br>
                        </div>
                        
                        <div class="col-lg-12">
                            <label for="">Grupo</label>
                            <select class="js-example-basic-single" name="state" id="cbm_grupo_listar" style="width:100%;">
                            </select>
                            <br>
                            <br>
                        </div>
                        
                        <div class="col-lg-12" hidden>
                            <select class="js-example-basic-single" name="state" id="cbm_grupo_verifity" style="width:100%;">
                            </select>
                            <br>
                            <br>
                        </div>

                        <div class="col-lg-12">
                            <label for="">Estudiantes</label>

                            <select name="" class="js-example-basic-single" id="cbm_estudiante" style="width: 100%;">
                            </select>
                            <br>
                            <br>
                        </div>

                        <div class="col-lg-12" hidden>
                            <select class="js-example-basic-single" name="state" id="cbm_calificaciones" style="width:100%;">
                            </select>
                            <br>
                            <br>
                        </div>
                        
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" onclick="registar()"><i class="fa fa-check"><b>&nbsp;Registrar</b></i></button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"><b>&nbsp;Cerrar</b></i></button>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    $(document).ready(function(){
       $('.js-example-basic-single').select2();
       listar_combo_profesores(); 
       listar_combo_docente(); 
       listar_combo_grupo(); 
       listar_combo_grupos();
       listar_asignacion_grupo();

       $("#cbm_profesor").change(function(){
         var id_docente = $("#cbm_profesor").val();
         listar_combo_grupo(id_docente);
     });   
        
       $("#cbm_docente").change(function(){
         var id_docente = $("#cbm_docente").val();
         var id_docentes = $("#txtiddocente").val();
         listar_combo_grupos(id_docente);
     });  
        
       $("#cbm_grupo_listar").change(function(){
         var id_grupo = $("#cbm_grupo_listar").val();
         var id_grupos = $("#id_aula").val();
         listar_combo_grupo_verifity(id_grupo);
     });  
        
       $("#cbm_estudiante").change(function(){
        var id_estudiantes = $("#cbm_estudiante").val();

        listar_combo_grupos_calificaciones(id_estudiantes);
    });  
        
       $("#cbm_grupo_verifity").change(function(){
        var id_grupo_verifity = $("#cbm_grupo_verifity").val();

        listar_combo_grupos_estudiantes('',id_grupo_verifity);
    });  

       listar_combo_grupos_estudiantes(); 
       listar_combo_grupo_verifity();
       listar_combo_grupos_calificaciones();
       datos();
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
