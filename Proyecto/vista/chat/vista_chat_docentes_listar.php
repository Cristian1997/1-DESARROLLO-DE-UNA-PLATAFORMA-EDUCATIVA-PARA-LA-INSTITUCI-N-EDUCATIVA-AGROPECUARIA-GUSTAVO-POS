<script type="text/javascript" src="../js/chat.js?rev=<?php echo time(); ?>"></script>

<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="../Plantilla/plugins/select2/select2.min.css">

<div class="col-md-12">
    <div class="box box-warning box-solid" hidden>
        <div class="box-header with-border">

            <h3 class="box-title">Chat</h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
            </div>
            <!-- /.box-tools -->
        </div>
        <!-- /.box-header -->
        <div class="box-body">

            <div class="form-group ">
                <div class="col-lg-8">
                    <div class="input-group">
                        <input type="text" class="global_filter form-control" id="global_filter"
                            placeholder="Ingresar dato a buscar">
                        <span class="input-group-addon"><i class="fa fa-search"></i></span>
                    </div>
                </div>
                <div class="col-lg-2">
                    <button class="btn btn-success btn-block" onclick="comentario_nuevo()"><i
                            class="fa fa-commenting-o"></i> Nuevo comentario</button>
                </div>

            </div><br><br>




            <div class="col-lg-12 table-responsive">
                <table id="tabla_chat_estudiantes" class="display responsive nowrap text-center" style="width:100% ">
                    <thead>
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>



                        </tr>
                    </thead>
                    <tfoot>
                        <th></th>

                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tfoot>
                </table> <br><br>
            </div>

            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>



    <style>
    /* Estilos adicionales para las cajas */
    .conversations-box {
        height: calc(96vh - 70px);
        /* Altura ajustada para ocupar el espacio vertical */
        overflow-y: auto;
        /* Agregar barra de desplazamiento vertical si el contenido es largo */

    }



    .contacts-list-name {
        color: black !important;
        /* Cambia el color del texto a negro, anulando cualquier otro estilo */


    }
    </style>





    <div class="row">
        <div class="col-md-5">
            <div class="box box-success conversations-box ">
                <div class="box-header with-border">

                    <div class="form-group">
                        <div class="col-lg-7">
                            <div class="input-group">
                                <input type="text" class="global_filter_nombre_conversaciones form-control"
                                    id="global_filter_nombre_conversaciones" placeholder="Buscar por nombre">
                                <span class="input-group-addon"><i class="fa fa-search"></i></span>
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <button class="btn btn-success btn-block" onclick="nuevo_chat_docentes()"><i
                                    class="fa fa-commenting-o"></i> Nuevo Chat</button>
                        </div>
                    </div>
                </div>
                <div class="box-header with-border">

                    <h3 class="box-title">CONVERSACIONES</h3>

                    <div class="box-tools pull-right">

                        <span class="label label-danger">Total Conversaciones: <span
                                id="txt_contador_conversaciones"></span></span>
                    </div>
                </div>
                <ul class="contacts-list" id="lista_conversaciones">
                    <!-- Aquí se mostrarán las conversaciones -->
                </ul>

            </div>
        </div>







        <div class="col-md-7">
            <div class="box box-success direct-chat direct-chat-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Chat Directo</h3>
                    <input type="text" id="id_chat" hidden>
                    <input type="text" id="id_chat_no_abierto" hidden>
                    <input type="text" id="id_chat_visto" hiddeN>
                    <div class="box-tools pull-right" style="display: none;">
                        <!-- Elemento de imagen del usuario -->
                        <img id="message_user_image" class="direct-chat-img" src="../dist/img/user1-128x128.jpg"
                            alt="Message User Image">
                        <!-- Elemento del nombre del usuario -->
                        <span id="message_user_name" class="direct-chat-name pull-left">nombre</span>
                        <!-- Mensaje "Escribiendo..." -->
                        <span id="mensaje_escribiendo" class="escribiendo" style="display: none;">Escribiendo...</span>
                    </div>
                </div>
                <div class="box-body">
                    <div class="direct-chat-messages">
                        <!-- Aquí se agregarán los comentarios -->
                    </div>
                    <div class="col-lg-12">
                        <br>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="">&nbsp;Mensaje</label>

                                <div class="btn-group">
                                    <button type="button" title="Elegir archivo!"
                                        class="btn btn-success fa fa-paperclip" id="archivo" data-toggle="dropdown">
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a href="#" id="elegir_documento" class="fa fa-paperclip"> Elegir
                                                documento</a></li>
                                        <li><a href="#" id="elegir_imagen" class="fa fa-picture-o"> Elegir imagen</a>
                                        </li>
                                    </ul>
                                </div>

                            </div>

                            <div class="col-md-6 text-right">
                                <button type="button" title="Desplazar chat hasta los últimos mensajes!"
                                    class="btn btn-success fa fa-long-arrow-down" id="scrollDownButton"></button>
                            </div>
                        </div><br>
                        <textarea name="" id="txt_comentario" cols="1" rows="3" class="form-control"
                            style="resize:none;"></textarea><br>
                    </div>

                    <div class="modal-footer">
                        <div class="pull-left">
                            <button type="button" class="btn btn-primary" onclick="responder_chat()"><i
                                    class="fa fa-commenting-o"></i>&nbsp;<b>Enviar Mensaje</b></button>
                        </div>
                    </div>


                </div>
            </div>
        </div>






        <div class="modal fade" id="modal_nuevo_chat_docentes" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header" style="text-align:center">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title"><i class="fa fa-commenting-o"></i><b>&nbsp; Iniciar un chat nuevo</b>
                        </h4>
                        <input type="text" id="id_nuevo_chat" hidden>
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="box box-danger">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">Integrantes del salón</h3>
                                        <div class="box-tools pull-right">
                                            <span class="label label-danger">Total Integrantes: <span
                                                    id="txt_contador_integrantes">0</span></span>

                                        </div>
                                    </div>
                                    <div class="box-body no-padding">
                                        <ul id="lista_docentes" class="users-list clearfix">
                                            <!-- Los integrantes del salón se agregarán aquí dinámicamente -->
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i
                                class="fa fa-close"><b>&nbsp;Cerrar</b></i></button>
                    </div>
                </div>
            </div>
        </div>






        <div class="modal fade" id="modal_archivo_documento" role="dialog">
            <div class="modal-dialog modal-xs">
                <div class="modal-content">
                    <div class="modal-header" style="text-align:center">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title"><i class="fa fa-commenting-o"></i><b>&nbsp; Elegir Archivo</b></h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">

                            <div class="col-lg-12"><br>
                                <label for="">&nbsp;Mensaje</label><br>
                                <textarea name="" id="txt_mensaje_documento" cols="1" rows="6" class="form-control"
                                    style="resize:none;"></textarea>
                            </div>
                            <div class="col-lg-12"><br>

                                <label for="">&nbsp;Subir Archivo</label><br>
                                <input type="file" id="txt_archivo_subir"><br><br>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" onclick="enviar_archivo()"><i
                                class="fa fa-check"><b>&nbsp;Enviar archivo</b></i></button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i
                                class="fa fa-close"><b>&nbsp;Cerrar</b></i></button>
                    </div>
                </div>
            </div>
        </div>



        <div class="modal fade" id="modal_archivo_imagen" role="dialog">
            <div class="modal-dialog modal-xs">
                <div class="modal-content">
                    <div class="modal-header" style="text-align:center">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title"><i class="fa fa-commenting-o"></i><b>&nbsp; Elegir Una Imagen</b></h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12"><br>
                                <label for="">&nbsp;Mensaje</label><br>
                                <textarea name="" id="txt_mensaje_imagen" cols="1" rows="6" class="form-control"
                                    style="resize:none;"></textarea>
                            </div>
                            <div class="col-lg-12"><br>
                                <label for="">&nbsp;Subir imagen</label><br>
                                <input type="file" id="txt_imagen_subir" onchange="previewImage()"><br><br>
                                <img id="imagen_previa" src="#" alt="Vista previa de la imagen"
                                    style="max-width: 100%; max-height: 200px; display: none; margin: auto; display: block;">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" onclick="enviar_imagen()"><i
                                class="fa fa-check"><b>&nbsp;Enviar imagen</b></i></button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i
                                class="fa fa-close"><b>&nbsp;Cerrar</b></i></button>
                    </div>
                </div>
            </div>
        </div>




        <div class="modal fade" id="modal_archivo_imagen_ver" role="dialog">
            <div class="modal-dialog modal-xs">
                <div class="modal-content">
                    <div class="modal-header" style="text-align:center">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title"><i class="fa fa-commenting-o"></i><b>&nbsp; ver Imagen</b></h4>

                    </div>
                    <div class="modal-body">
                        <div class="row">

                            <!-- Contenedor para mostrar la imagen -->
                            <div id="imagen_contenedor" style="text-align: center;">
                                <img id="imagen_mostrada" style="max-width: 100%; height: auto;">
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i
                                class="fa fa-close"><b>&nbsp;Cerrar</b></i></button>
                    </div>
                </div>
            </div>
        </div>


        <script src="../Plantilla/plugins/select2/select2.min.js"></script>
        <script>
        $(document).ready(function() {

            $('.js-example-basic-single1').select2();
            listar_chat_estudiantes_es();
            listar_chat_estudiantes()

            listar_combo_docentes();



            document.getElementById('txt_archivo').addEventListener("change", () => {
                var FileName = document.getElementById('txt_archivo').value;
                var idDot = FileName.lastIndexOf(".") + 1;
                var exfile = FileName.substr(idDot, FileName.length).toLowerCase();
                if (exfile == "pdf" || exfile == "doc") {

                } else {
                    document.getElementById('txt_archivo').value = "";
                    Swal.fire("Mensaje De Advertencia",
                        "SOLO SE ACEPTA IMAGENES - USTED SUBIO UN ARCHIVO CON EXTENCION " + exfile,
                        "warning");
                }

            });
            document.getElementById('txt_archivo_editar').addEventListener("change", () => {
                var FileName = document.getElementById('txt_archivo_editar').value;
                var idDot = FileName.lastIndexOf(".") + 1;
                var exfile = FileName.substr(idDot, FileName.length).toLowerCase();
                if (exfile == "pdf" || exfile == "doc") {

                } else {
                    document.getElementById('txt_archivo_editar').value = "";
                    Swal.fire("Mensaje De Advertencia",
                        "SOLO SE ACEPTA IMAGENES - USTED SUBIO UN ARCHIVO CON EXTENCION " + exfile,
                        "warning");

                }

            });

        });



        $('.box').boxWidget({
            animationSpeed: 500,
            collapseTrigger: '[data-widget="collapse"]',
            removeTrigger: '[data-widget="remove"]',
            collapseIcon: 'fa-minus',
            expandIcon: 'fa-plus',
            removeIcon: 'fa-times'
        })
        $(document).ready(function() {


        })
        </script>
